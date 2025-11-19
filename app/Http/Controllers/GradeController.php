<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\Student;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class GradeController extends Controller
{
    public function index()
    {
        return view('grades.index', ['grades' => Grade::all()]);
    }

    public function create()
    {
        return view('grades.form', ['grade' => null]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre_grado' => 'required|string|max:255|unique:grades',
            'nivel' => 'required|string|max:100',
            'estado' => 'in:true,false'
        ]);

        $grade = Grade::create([
            'nombre_grado' => $request->nombre_grado,
            'nivel' => $request->nivel,
            'estado' => $request->estado === 'true' ? true : false
        ]);

        return redirect()->route('student-grades.index')
            ->with('success', 'Grado creado correctamente');
    }

    public function show($id)
    {
        $grade = $this->getGradeById($id);
        return view('grades.show', ['grade' => $grade]);
    }

    public function edit($id)
    {
        $grade = $this->getGradeById($id);
        return view('grades.form', ['grade' => $grade]);
    }

    public function update(Request $request, $id)
    {
        $grade = $this->getGradeById($id);

        $request->validate([
            'nombre_grado' => "required|string|max:255|unique:grades,nombre_grado,{$id}",
            'nivel' => 'required|string|max:100',
            'estado' => 'in:true,false'
        ]);

        $grade->update([
            'nombre_grado' => $request->nombre_grado,
            'nivel' => $request->nivel,
            'estado' => $request->estado === 'true' ? true : false
        ]);

        return redirect()->route('student-grades.index')
            ->with('success', 'Grado actualizado correctamente');
    }

    public function destroy($id)
    {
        $grade = $this->getGradeById($id);
        $grade->delete();

        return redirect()->route('student-grades.index')
            ->with('success', 'Grado eliminado correctamente');
    }

    public function studentGrades($student)
    {
        $student = Student::findOrFail($student);
        $grades = $student->grades()->get();
        return view('grades.student-grades', ['student' => $student, 'grades' => $grades]);
    }

    // Métodos legacy para compatibilidad (si los necesitas)
    public function getAll()
    {
        return $this->index();
    }

    public function getById($id)
    {
        return $this->show($id);
    }

    public function viewCreate()
    {
        return $this->create();
    }

    public function delete($id)
    {
        return $this->destroy($id);
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
