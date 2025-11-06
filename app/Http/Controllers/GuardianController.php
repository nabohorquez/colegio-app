<?php

namespace App\Http\Controllers;

use App\Models\Guardian;
use App\Models\GuardianContact;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class GuardianController extends Controller
{
    /** ✅ Vista index */
    public function getAll()
    {
        return view('guardians.index', [
            'guardians' => Guardian::with(['contacts', 'students'])->get(),
            'students'  => Student::all(),
        ]);
    }

    /** ✅ Retornar info de acudiente (para modal EDITAR y para badge) */
    public function getById($id)
    {
        $guardian = Guardian::with(['contacts', 'students'])->find($id);

        if (!$guardian) {
            throw new NotFoundHttpException("Acudiente no encontrado");
        }

        return response()->json([
            'guardian'  => $guardian,
            'contacts'  => $guardian->contacts,
            'students'  => $guardian->students->map(function ($s) {
                return [
                    'id' => $s->id,
                    'full_name' => "{$s->first_name} {$s->last_name}",
                    'document' => $s->document,
                    'grade' => $s->grade,
                    'relationship' => $s->relationship, // ✅ columna nueva
                ];
            }),
        ]);
    }

    /** ✅ Crear acudiente */
    public function create(Request $request)
    {
        $request->validate([
            'first_name'        => 'required|string|max:120',
            'last_name'         => 'required|string|max:120',
            'email'             => 'required|email|unique:guardians,email',
            'gender'            => 'nullable|string',
            'marital_status'    => 'nullable|string',
            'contacts'          => 'array',
            'contacts.*.type'   => 'required|string',
            'contacts.*.value'  => 'required|string',
            'students'          => 'array',
            'students.*.id'     => 'required|integer|exists:students,id',
            'students.*.relationship' => 'nullable|string|in:Padre,Madre,Otro',
        ]);

        DB::beginTransaction();
        try {
            $guardian = Guardian::create($request->only([
                'first_name', 'second_name', 'last_name', 'second_last_name',
                'email', 'gender', 'marital_status'
            ]));

            // ✅ Guardar contactos
            foreach ($request->contacts ?? [] as $c) {
                GuardianContact::create([
                    'guardian_id' => $guardian->id,
                    'type'        => $c['type'],
                    'value'       => $c['value'],
                ]);
            }

            // ✅ Asignar estudiantes (1:n con relationship)
            foreach ($request->students ?? [] as $s) {
                Student::where('id', $s['id'])->update([
                    'guardian_id'  => $guardian->id,
                    'relationship' => $s['relationship'] ?? null,
                ]);
            }

            DB::commit();
            return response()->json(['message' => 'Acudiente creado correctamente'], 201);

        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    /** ✅ Actualizar acudiente */
    public function update(Request $request, $id)
    {
        $guardian = Guardian::find($id);
        if (!$guardian) {
            throw new NotFoundHttpException("Acudiente no encontrado");
        }

        $request->validate([
            'first_name'        => 'required|string|max:120',
            'last_name'         => 'required|string|max:120',
            'email'             => "required|email|unique:guardians,email,$id",
            'gender'            => 'nullable|string',
            'marital_status'    => 'nullable|string',
            'contacts'          => 'array',
            'contacts.*.type'   => 'required|string',
            'contacts.*.value'  => 'required|string',
            'students'          => 'array',
            'students.*.id'     => 'required|integer|exists:students,id',
            'students.*.relationship' => 'nullable|string|in:Padre,Madre,Otro',
        ]);

        DB::beginTransaction();
        try {
            $guardian->update($request->only([
                'first_name', 'second_name', 'last_name', 'second_last_name',
                'email', 'gender', 'marital_status'
            ]));

            // ✅ Actualizar contactos
            GuardianContact::where('guardian_id', $id)->delete();
            foreach ($request->contacts ?? [] as $contact) {
                GuardianContact::create([
                    'guardian_id' => $id,
                    'type'        => $contact['type'],
                    'value'       => $contact['value'],
                ]);
            }

            // ✅ Limpiar estudiantes anteriores
            Student::where('guardian_id', $id)->update([
                'guardian_id'  => null,
                'relationship' => null
            ]);

            // ✅ Asignar nuevos
            foreach ($request->students ?? [] as $s) {
                Student::where('id', $s['id'])->update([
                    'guardian_id'  => $id,
                    'relationship' => $s['relationship'] ?? null,
                ]);
            }

            DB::commit();
            return response()->json(['message' => 'Acudiente actualizado correctamente'], 200);

        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    /** ✅ Eliminar acudiente */
    public function delete($id)
    {
        $guardian = Guardian::find($id);
        if (!$guardian) {
            return response()->json(['message' => 'Acudiente no encontrado'], 404);
        }

        DB::beginTransaction();
        try {
            // ✅ liberar estudiantes
            Student::where('guardian_id', $id)->update([
                'guardian_id'  => null,
                'relationship' => null
            ]);

            $guardian->contacts()->delete();
            $guardian->delete();

            DB::commit();
            return response()->json(['message' => 'Acudiente eliminado correctamente'], 200);

        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }
}
