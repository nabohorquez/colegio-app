<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EnrollmentType;

class EnrollmentTypeController extends Controller
{
    /**
     * Mostrar la lista de tipos de matrícula.
     */
    public function getAll()
    {
        $enrollmentTypes = EnrollmentType::paginate(10);

        // Cambiado: apunta a resources/views/enrollment_types/index.blade.php
        return view('enrollment_types.index', [
            'types' => $enrollmentTypes
        ]);
    }

    /**
     * Mostrar el formulario para crear un nuevo tipo de matrícula.
     */
    public function viewCreate()
    {
        // Cambiado: apunta a resources/views/enrollment_types/create.blade.php
        return view('enrollment_types.create');
    }

    /**
     * Guardar un nuevo tipo de matrícula en la base de datos.
     */
    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'code' => 'nullable|string|max:50',
            'fee' => 'nullable|numeric|min:0',
            'is_active' => 'boolean',
            'description' => 'nullable|string|max:255',
        ]);

        EnrollmentType::create([
            'name' => $request->name,
            'code' => $request->code,
            'fee' => $request->fee ?? 0,
            'is_active' => $request->has('is_active'),
            'description' => $request->description,
        ]);

        return redirect()->route('enrollment-types.index')
            ->with('success', 'Tipo de matrícula creado correctamente.');
    }

    /**
     * Mostrar el formulario de edición de un tipo de matrícula.
     */
    public function getById($id)
    {
        $type = EnrollmentType::findOrFail($id);
        // Cambiado: apunta a resources/views/enrollment_types/edit.blade.php
        return view('enrollment_types.edit', compact('type'));
    }

    /**
     * Actualizar un tipo de matrícula existente.
     */
    public function update(Request $request, $id)
    {
        $type = EnrollmentType::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:100',
            'code' => 'nullable|string|max:50',
            'fee' => 'nullable|numeric|min:0',
            'is_active' => 'boolean',
            'description' => 'nullable|string|max:255',
        ]);

        $type->update([
            'name' => $request->name,
            'code' => $request->code,
            'fee' => $request->fee ?? 0,
            'is_active' => $request->has('is_active'),
            'description' => $request->description,
        ]);

        return redirect()->route('enrollment-types.index')
            ->with('success', 'Tipo de matrícula actualizado correctamente.');
    }

    /**
     * Eliminar un tipo de matrícula.
     */
    public function delete($id)
    {
        $type = EnrollmentType::findOrFail($id);
        $type->delete();

        return redirect()->route('enrollment-types.index')
            ->with('success', 'Tipo de matrícula eliminado correctamente.');
    }
    public function show($id)
    {
        $type = EnrollmentType::findOrFail($id);
        return view('enrollment_types.show', compact('type'));
    }

}
