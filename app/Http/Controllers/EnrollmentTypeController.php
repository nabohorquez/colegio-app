<?php

namespace App\Http\Controllers;

use App\Models\EnrollmentType;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class EnrollmentTypeController extends Controller
{
    public function getAll()
    {
        return view('enrollment_types.index', ['enrollment_types' => EnrollmentType::all()]);
    }

    public function getById($id)
    {
        $enrollmentType = $this->getEnrollmentTypeById($id);
        return view('enrollment_types.form', ['enrollment_type' => $enrollmentType]);
    }

    public function viewCreate()
    {
        return view('enrollment_types.form', ['enrollment_type' => null]);
    }

    public function create(Request $request)
    {
        $request->validate([
            'nombre_tipo' => 'required|string|max:255|unique:enrollment_types',
            'descripcion' => 'nullable|string',
            'estado' => 'boolean'
        ]);

        $enrollmentType = EnrollmentType::create([
            'nombre_tipo' => $request->nombre_tipo,
            'descripcion' => $request->descripcion,
            'estado' => $request->boolean('estado', true)
        ]);

        return redirect()->route('enrollment-types.index')
            ->with('success', 'Tipo de matrícula creado correctamente');
    }

    public function update(Request $request, $id)
    {
        $enrollmentType = $this->getEnrollmentTypeById($id);

        $request->validate([
            'nombre_tipo' => "required|string|max:255|unique:enrollment_types,nombre_tipo,{$id}",
            'descripcion' => 'nullable|string',
            'estado' => 'boolean'
        ]);

        $enrollmentType->update([
            'nombre_tipo' => $request->nombre_tipo,
            'descripcion' => $request->descripcion,
            'estado' => $request->boolean('estado', true)
        ]);

        return redirect()->route('enrollment-types.index')
            ->with('success', 'Tipo de matrícula actualizado correctamente');
    }

    public function delete($id)
    {
        $enrollmentType = $this->getEnrollmentTypeById($id);
        $enrollmentType->delete();

        return redirect()->route('enrollment-types.index')
            ->with('success', 'Tipo de matrícula eliminado correctamente');
    }

    private function getEnrollmentTypeById(int $id)
    {
        $enrollmentType = EnrollmentType::find($id);
        if ($enrollmentType) {
            return $enrollmentType;
        } else {
            throw new NotFoundHttpException('El tipo de matrícula no se encuentra');
        }
    }
}
