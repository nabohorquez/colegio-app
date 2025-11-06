<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Guardian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class StudentController extends Controller
{
    /**
     * ✅ Mostrar vista principal con todos los estudiantes
     */
    public function index()
    {
        $permissions = (new RoleController())->getPermissionsPageByRoleId(auth()->id(), 'students');
        
        return view('students.index', [
            'students' => Student::with('guardian')->get(),
            'guardians' => Guardian::all(),
            'permissions' => $permissions
        ]);
    }

    /**
     * ✅ Obtener estudiante en JSON (para modal AJAX)
     */
    public function getById($id)
    {
        $student = Student::with('guardian')->find($id);

        if (!$student) {
            return response()->json(['message' => 'Estudiante no encontrado'], 404);
        }

        return response()->json($student);
    }

    /**
     * ✅ Crear estudiante con generación automática de correo institucional
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name'  => 'required|string|max:120',
            'last_name'   => 'required|string|max:120',
            'birth_date'  => 'nullable|date',
            'document'    => 'nullable|numeric',
            'grade'       => 'required|string|max:50',
            'guardian_id' => 'nullable|integer|exists:guardians,id'
        ]);

        DB::beginTransaction();
        try {
            // 1️⃣ Generar email institucional único
            $email = $this->generateInstitutionalEmail($request->first_name, $request->last_name);

            // 2️⃣ Crear estudiante
            Student::create([
                'first_name'         => $request->first_name,
                'last_name'          => $request->last_name,
                'birth_date'         => $request->birth_date,
                'document'           => $request->document,
                'grade'              => $request->grade,
                'guardian_id'        => $request->guardian_id,
                'institutional_email'=> $email
            ]);

            DB::commit();
            return response()->json(['message' => 'Estudiante registrado correctamente'], 201);

        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    /**
     * ✅ Actualizar estudiante
     */
    public function update(Request $request, $id)
    {
        $student = Student::find($id);
        if (!$student) return response()->json(['message' => 'Estudiante no encontrado'], 404);

        $request->validate([
            'first_name'  => 'required|string|max:120',
            'last_name'   => 'required|string|max:120',
            'birth_date'  => 'nullable|date',
            'document'    => 'nullable|numeric',
            'grade'       => 'required|string|max:50',
            'guardian_id' => 'nullable|integer|exists:guardians,id'
        ]);

        DB::beginTransaction();
        try {
            $student->update($request->only([
                'first_name', 'last_name', 'birth_date', 'document', 'grade', 'guardian_id'
            ]));

            DB::commit();
            return response()->json(['message' => 'Estudiante actualizado correctamente'], 200);

        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    /**
     * ✅ Eliminar estudiante
     */
    public function destroy($id)
    {
        $student = Student::find($id);
        if (!$student) return response()->json(['message' => 'Estudiante no encontrado'], 404);

        $student->delete();
        return response()->json(['message' => 'Estudiante eliminado correctamente'], 200);
    }

    /**
     * 🔥 Función generadora de email institucional único
     */
    private function generateInstitutionalEmail($first, $last)
    {
        $base = strtolower(str_replace(' ', '', $first . $last));
        $base = iconv('UTF-8', 'ASCII//TRANSLIT', $base); // quitar acentos
        $email = $base . '@academicsoft.com';

        $counter = 1;
        while (Student::where('institutional_email', $email)->exists()) {
            $email = $base . sprintf("%02d", $counter) . '@academicsoft.com';
            $counter++;
        }

        return $email;
    }
}
