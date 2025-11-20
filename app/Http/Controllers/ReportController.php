<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StudentGrade;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Activity;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    /**
     * Reporte detallado de notas por estudiante
     * Muestra todas las actividades y notas por estudiante y materia
     */
    public function detailedGrades(Request $request)
    {
        $query = StudentGrade::with([
            'student.guardian',
            'subject.employees.user',
            'creator'
        ]);

        // Filtros opcionales
        if ($request->filled('student_id')) {
            $query->where('student_id', $request->student_id);
        }

        if ($request->filled('subject_id')) {
            $query->where('subject_id', $request->subject_id);
        }

        $grades = $query->orderBy('student_id')
            ->orderBy('subject_id')
            ->get();

        // Obtener lista de estudiantes y materias para filtros
        $students = Student::orderBy('first_name')->get();
        $subjects = Subject::where('estado', true)->orderBy('nombre_materia')->get();

        return view('reports.grades.detailed', compact('grades', 'students', 'subjects'));
    }

    /**
     * Reporte consolidado de notas por estudiante
     * Muestra solo la nota final por estudiante y materia
     */
    public function consolidatedGrades(Request $request)
    {
        $query = StudentGrade::with([
            'student.guardian',
            'subject.employees.user',
            'creator'
        ])->whereNotNull('final_grade');

        // Filtros opcionales
        if ($request->filled('student_id')) {
            $query->where('student_id', $request->student_id);
        }

        if ($request->filled('subject_id')) {
            $query->where('subject_id', $request->subject_id);
        }

        if ($request->filled('status')) {
            if ($request->status === 'aprobado') {
                $query->where('final_grade', '>=', 3.0);
            } elseif ($request->status === 'reprobado') {
                $query->where('final_grade', '<', 3.0);
            }
        }

        $grades = $query->orderBy('student_id')
            ->orderBy('subject_id')
            ->get();

        // Calcular estadísticas
        $statistics = [
            'total_students' => $grades->unique('student_id')->count(),
            'total_subjects' => $grades->unique('subject_id')->count(),
            'approved' => $grades->where('final_grade', '>=', 3.0)->count(),
            'failed' => $grades->where('final_grade', '<', 3.0)->count(),
            'average' => $grades->avg('final_grade')
        ];

        // Obtener lista de estudiantes y materias para filtros
        $students = Student::orderBy('first_name')->get();
        $subjects = Subject::where('estado', true)->orderBy('nombre_materia')->get();

        return view('reports.grades.consolidated', compact('grades', 'students', 'subjects', 'statistics'));
    }
}
