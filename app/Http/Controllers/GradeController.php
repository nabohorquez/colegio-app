<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class GradeController extends Controller
{
    public function getAll()
    {
        return view('grades.index', ['grades' => Grade::all()]);
    }

    public function getById($id)
    {
        $grade = $this->getGradeById($id);
        return view('grades.form', ['grade' => $grade]);
    }

    public function viewCreate()
    {
        return view('grades.form', ['grade' => null]);
    }

    public function create(Request $request)
    {
        $request->validate([
            'nombre_grado' => 'required|string|max:255|unique:grades',
            'nivel' => 'required|string|max:100',
            'estado' => 'boolean'
        ]);

        $grade = Grade::create([
            'nombre_grado' => $request->nombre_grado,
            'nivel' => $request->nivel,
            'estado' => $request->boolean('estado', true)
        ]);

        return redirect()->route('grades.index')
            ->with('success', 'Grado creado correctamente');
    }

    public function update(Request $request, $id)
    {
        $grade = $this->getGradeById($id);

        $request->validate([
            'nombre_grado' => "required|string|max:255|unique:grades,nombre_grado,{$id}",
            'nivel' => 'required|string|max:100',
            'estado' => 'boolean'
        ]);

        $grade->update([
            'nombre_grado' => $request->nombre_grado,
            'nivel' => $request->nivel,
            'estado' => $request->boolean('estado', true)
        ]);

        return redirect()->route('grades.index')
            ->with('success', 'Grado actualizado correctamente');
    }

    public function delete($id)
    {
        $grade = $this->getGradeById($id);
        $grade->delete();

        return redirect()->route('grades.index')
            ->with('success', 'Grado eliminado correctamente');
    }

    private function getGradeById(int $id)
    {
        $grade = Grade::find($id);
        if ($grade) {
            return $grade;
        } else {
            throw new NotFoundHttpException('El grado no se encuentra');
        }
    }
}
