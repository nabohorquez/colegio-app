<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\User;
use App\Models\EmployeeContact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class EmployeeController extends Controller
{
    /**
     * Mostrar vista con todos los empleados
     */
    public function getAll()
    {
        return view('employees.index', [
            'employees' => Employee::with('user')->get(),
        ]);
    }

    /**
     * ✅ Obtener un empleado en JSON para el modal AJAX
     */
    public function getById($id)
    {
        $employee = Employee::with('user')->find($id);

        if (!$employee) {
            throw new NotFoundHttpException("Empleado no encontrado");
        }

        return response()->json([
            'employee' => $employee,
            'user' => $employee->user,
            'contacts' => $employee->contacts()->get(),
        ]);
    }

    /**
     * ✅ Actualizar empleado (AJAX PUT desde modal)
     */
    public function update(Request $request, $id)
    {
        $employee = Employee::with('user')->find($id);

        if (!$employee) {
            throw new NotFoundHttpException("Empleado no encontrado");
        }

        // ✅ Validación del request
        $request->validate([
            'first_name' => 'required|string|max:120',
            'last_name' => 'required|string|max:120',
            'email' => "required|email|unique:users,email,{$employee->user->id}",
            'gender' => 'required|string',
            'marital_status' => 'required|string',
            'contacts' => 'array',
            'contacts.*.type' => 'required|string',
            'contacts.*.value' => 'required|string'
        ]);

        DB::beginTransaction();
        try {
            // ✅ 1. Actualizar datos del usuario
            $employee->user->update([
                'first_name' => $request->first_name,
                'last_name'  => $request->last_name,
                'email'      => $request->email,
            ]);

            // ✅ 2. Actualizar datos del empleado
            $employee->update([
                'gender' => $request->gender,
                'marital_status' => $request->marital_status,
            ]);

            // ✅ 3. Limpiar y recrear contactos
            EmployeeContact::where('employee_id', $employee->id)->delete();

            foreach ($request->contacts ?? [] as $contact) {
                EmployeeContact::create([
                    'employee_id' => $employee->id,
                    'type' => $contact['type'],
                    'value' => $contact['value'],
                ]);
            }

            DB::commit();
            return response()->json(['message' => 'Empleado actualizado correctamente'], 200);

        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    /**
     * ❗️ CRUD restante (ya lo tienes, no lo toco)
     */
  public function viewCreate()
{
    return view('employees.create');
}

public function create(Request $request)
{
    // ✅ 1. Limpiar contactos vacíos antes de validar
    if ($request->has('contacts')) {
        $request->merge([
            'contacts' => collect($request->contacts)
                ->filter(fn($c) => !empty($c['type']) && !empty($c['value']))
                ->values()
                ->toArray()
        ]);
    }

    // ✅ 2. Validación
    $request->validate([
        'first_name' => 'required|string|max:120',
        'last_name' => 'required|string|max:120',
        'email' => 'required|email|unique:users,email',
        'username' => 'required|string|unique:users,username',
        'password' => 'required|string|min:6',
        'gender' => 'required|string',
        'marital_status' => 'required|string',
        'contacts.*.type' => 'required|string',
        'contacts.*.value'=> 'required|string',
    ]);

    DB::beginTransaction();
    try {
        // ✅ 3. Crear usuario
        $user = User::create([
            'name' => $request->first_name . ' ' . $request->last_name,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'username' => $request->username, // ✅ ahora sí se guarda
            'password' => bcrypt($request->password),
        ]);

        // ✅ 4. Crear empleado
        $employee = Employee::create([
            'user_id' => $user->id,
            'gender' => $request->gender,
            'marital_status' => $request->marital_status,
        ]);

        // ✅ 5. Guardar contactos
        foreach ($request->contacts ?? [] as $contact) {
            EmployeeContact::create([
                'employee_id' => $employee->id,
                'type' => $contact['type'],
                'value' => $contact['value'],
            ]);
        }

        DB::commit();

        return redirect()
            ->route('employees.index')
            ->with('success', 'Empleado creado correctamente ✅');

    } catch (\Throwable $e) {
        DB::rollBack();
        return back()->withErrors(['error' => $e->getMessage()]);
    }
}

public function delete($id)
{
    $employee = Employee::with('user')->find($id);

    if (!$employee) {
        return response()->json(['message' => 'Empleado no encontrado'], 404);
    }

    DB::beginTransaction();
    try {
        // 1. Borrar contactos
        EmployeeContact::where('employee_id', $employee->id)->delete();

        // 2. Borrar empleado
        $employee->delete();

        // 3. Borrar usuario asociado
        $employee->user->delete();

        DB::commit();
        return response()->json(['message' => 'Empleado eliminado correctamente'], 200);

    } catch (\Throwable $e) {
        DB::rollBack();
        return response()->json(['message' => $e->getMessage()], 400);
    }
}


}