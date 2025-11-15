<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GradeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = Student::with('grades')->orderBy('first_name')->get();
        return view('school_admin.grades.index', compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $students = Student::orderBy('first_name')->get();
        $academicPeriods = ['2025-I', '2025-II', '2026-I', '2026-II'];
        $subjects = [
            'Matemáticas',
            'Lengua Española',
            'Inglés',
            'Ciencias Naturales',
            'Estudios Sociales',
            'Educación Física',
            'Artes',
            'Informática',
        ];

        // Pre-select student if provided in query string
        $selectedStudent = $request->query('student_id');

        return view('school_admin.grades.create', compact('students', 'academicPeriods', 'subjects', 'selectedStudent'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'subject' => 'required|string|max:255',
            'academic_period' => 'required|string|max:50',
            'first_partial' => 'nullable|numeric|min:0|max:5',
            'second_partial' => 'nullable|numeric|min:0|max:5',
            'final_grade' => 'nullable|numeric|min:0|max:5',
            'notes' => 'nullable|string',
        ]);

        Grade::create([
            'student_id' => $request->student_id,
            'subject' => $request->subject,
            'academic_period' => $request->academic_period,
            'first_partial' => $request->first_partial,
            'second_partial' => $request->second_partial,
            'final_grade' => $request->final_grade,
            'notes' => $request->notes,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('school.grades.index')
            ->with('success', 'Grade assigned successfully to the student.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Grade $grade)
    {
        $grade->load(['student', 'creator']);
        return view('school_admin.grades.show', compact('grade'));
    }

    /**
     * Display all grades for a specific student.
     */
    public function studentGrades(Student $student)
    {
        $grades = Grade::where('student_id', $student->id)
                       ->with(['creator'])
                       ->latest('academic_period')
                       ->get()
                       ->groupBy('academic_period');

        return view('school_admin.grades.student-grades', compact('student', 'grades'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Grade $grade)
    {
        $students = Student::orderBy('first_name')->get();
        $academicPeriods = ['2025-I', '2025-II', '2026-I', '2026-II'];
        $subjects = [
            'Matemáticas',
            'Lengua Española',
            'Inglés',
            'Ciencias Naturales',
            'Estudios Sociales',
            'Educación Física',
            'Artes',
            'Informática',
        ];

        return view('school_admin.grades.edit', compact('grade', 'students', 'academicPeriods', 'subjects'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Grade $grade)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'subject' => 'required|string|max:255',
            'academic_period' => 'required|string|max:50',
            'first_partial' => 'nullable|numeric|min:0|max:5',
            'second_partial' => 'nullable|numeric|min:0|max:5',
            'final_grade' => 'nullable|numeric|min:0|max:5',
            'notes' => 'nullable|string',
        ]);

        $grade->update($request->all());

        return redirect()->route('school.grades.index')
            ->with('success', 'Grade updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Grade $grade)
    {
        $grade->delete();

        return redirect()->route('school.grades.index')
            ->with('success', 'Grade removed successfully.');
    }
}
