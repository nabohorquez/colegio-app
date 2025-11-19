<?php

namespace App\Http\Controllers;

use App\Models\StudentGrade;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentGradesController extends Controller
{
    /**
     * ✅ Mostrar todas las calificaciones de estudiantes
     */
    public function index()
    {
        $grades = StudentGrade::with(['student', 'subject'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('student_grades.index', [
            'grades' => $grades,
            'title' => 'Calificaciones de Estudiantes'
        ]);
    }

    /**
     * ✅ Formulario para crear calificación
     */
    public function create()
    {
        return view('student_grades.create', [
            'students' => Student::orderBy('first_name')->get(),
            'subjects' => Subject::where('estado', true)->get(),
            'grade' => null,
            'title' => 'Nueva Calificación'
        ]);
    }

    /**
     * ✅ Guardar nueva calificación
     */
    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'subject_id' => 'required|exists:subjects,id',
            'partial_1' => 'nullable|numeric|between:0,5',
            'partial_2' => 'nullable|numeric|between:0,5',
            'final_grade' => 'nullable|numeric|between:0,5',
            'observations' => 'nullable|string|max:500'
        ]);

        DB::beginTransaction();
        try {
            StudentGrade::create([
                'student_id' => $request->student_id,
                'subject_id' => $request->subject_id,
                'partial_1' => $request->partial_1,
                'partial_2' => $request->partial_2,
                'final_grade' => $request->final_grade,
                'observations' => $request->observations,
                'created_by' => auth()->id()
            ]);

            DB::commit();
            return redirect()->route('student-grades.index')
                ->with('success', 'Calificación registrada correctamente');

        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error al guardar: ' . $e->getMessage());
        }
    }

    /**
     * ✅ Ver detalles de una calificación
     */
    public function show($id)
    {
        $grade = StudentGrade::with(['student', 'subject', 'creator'])->findOrFail($id);

        return view('student_grades.show', [
            'grade' => $grade,
            'title' => 'Detalle de Calificación'
        ]);
    }

    /**
     * ✅ Formulario para editar calificación
     */
    public function edit($id)
    {
        $grade = StudentGrade::findOrFail($id);

        return view('student_grades.edit', [
            'grade' => $grade,
            'students' => Student::orderBy('first_name')->get(),
            'subjects' => Subject::where('estado', true)->get(),
            'title' => 'Editar Calificación'
        ]);
    }

    /**
     * ✅ Actualizar calificación
     */
    public function update(Request $request, $id)
    {
        $grade = StudentGrade::findOrFail($id);

        $request->validate([
            'student_id' => 'required|exists:students,id',
            'subject_id' => 'required|exists:subjects,id',
            'partial_1' => 'nullable|numeric|between:0,5',
            'partial_2' => 'nullable|numeric|between:0,5',
            'final_grade' => 'nullable|numeric|between:0,5',
            'observations' => 'nullable|string|max:500'
        ]);

        DB::beginTransaction();
        try {
            $grade->update([
                'student_id' => $request->student_id,
                'subject_id' => $request->subject_id,
                'partial_1' => $request->partial_1,
                'partial_2' => $request->partial_2,
                'final_grade' => $request->final_grade,
                'observations' => $request->observations
            ]);

            DB::commit();
            return redirect()->route('student-grades.index')
                ->with('success', 'Calificación actualizada correctamente');

        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error al actualizar: ' . $e->getMessage());
        }
    }

    /**
     * ✅ Eliminar calificación
     */
    public function destroy($id)
    {
        $grade = StudentGrade::findOrFail($id);
        $grade->delete();

        return redirect()->route('student-grades.index')
            ->with('success', 'Calificación eliminada correctamente');
    }

    /**
     * ✅ Ver calificaciones de un estudiante
     */
    public function byStudent($studentId)
    {
        $student = Student::findOrFail($studentId);
        $grades = $student->grades()->paginate(15);

        return view('student_grades.by_student', [
            'student' => $student,
            'grades' => $grades,
            'title' => 'Calificaciones de ' . $student->full_name
        ]);
    }
}
