<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SubjectController extends Controller
{
    public function getAll()
    {
        return view('subjects.index', ['subjects' => Subject::all()]);
    }

    public function getById($id)
    {
        $subject = $this->getSubjectById($id);
        return view('subjects.form', ['subject' => $subject]);
    }

    public function viewCreate()
    {
        return view('subjects.form', ['subject' => null]);
    }

    public function create(Request $request)
    {
        $request->validate([
            'nombre_materia' => 'required|string|max:255|unique:subjects',
            'descripcion' => 'nullable|string',
            'estado' => 'boolean'
        ]);

        $subject = Subject::create([
            'nombre_materia' => $request->nombre_materia,
            'descripcion' => $request->descripcion,
            'estado' => $request->boolean('estado', true)
        ]);

        return redirect()->route('subjects.index')
            ->with('success', 'Materia creada correctamente');
    }

    public function update(Request $request, $id)
    {
        $subject = $this->getSubjectById($id);

        $request->validate([
            'nombre_materia' => "required|string|max:255|unique:subjects,nombre_materia,{$id}",
            'descripcion' => 'nullable|string',
            'estado' => 'boolean'
        ]);

        $subject->update([
            'nombre_materia' => $request->nombre_materia,
            'descripcion' => $request->descripcion,
            'estado' => $request->boolean('estado', true)
        ]);

        return redirect()->route('subjects.index')
            ->with('success', 'Materia actualizada correctamente');
    }

    public function delete($id)
    {
        $subject = $this->getSubjectById($id);
        $subject->delete();

        return redirect()->route('subjects.index')
            ->with('success', 'Materia eliminada correctamente');
    }

    private function getSubjectById(int $id)
    {
        $subject = Subject::find($id);
        if ($subject) {
            return $subject;
        } else {
            throw new NotFoundHttpException('La materia no se encuentra');
        }
    }
}
