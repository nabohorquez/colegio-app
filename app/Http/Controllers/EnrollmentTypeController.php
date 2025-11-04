<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EnrollmentType;

class EnrollmentTypeController extends Controller
{
    public function getAll()
    {
        $enrollmentTypes = EnrollmentType::all();
        return view('enrollment-types.index', compact('enrollmentTypes'));
    }

    public function viewCreate()
    {
        return view('enrollment-types.create');
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'nullable|string|max:255',
        ]);

        EnrollmentType::create($request->all());
        return redirect()->route('enrollment-types.index')->with('success', 'Tipo de matrícula creado correctamente.');
    }

    public function getById($id)
    {
        $type = EnrollmentType::findOrFail($id);
        return view('enrollment-types.edit', compact('type'));
    }

    public function update(Request $request, $id)
    {
        $type = EnrollmentType::findOrFail($id);
        $type->update($request->all());
        return redirect()->route('enrollment-types.index')->with('success', 'Tipo de matrícula actualizado.');
    }

    public function delete($id)
    {
        $type = EnrollmentType::findOrFail($id);
        $type->delete();
        return redirect()->route('enrollment-types.index')->with('success', 'Tipo de matrícula eliminado.');
    }
}
