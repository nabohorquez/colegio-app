<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use App\Models\Student;
use App\Models\Grade;
use App\Models\EnrollmentType;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class EnrollmentController extends Controller
{
    public function getAll()
    {
        return view('enrollments.index', [
            'enrollments' => Enrollment::with('student', 'grade', 'enrollmentType')->get()
        ]);
    }

    public function getById($id)
    {
        $enrollment = $this->getEnrollmentById($id);
        return view('enrollments.form', [
            'enrollment' => $enrollment,
            'students' => Student::all(),
            'grades' => Grade::all(),
            'enrollmentTypes' => EnrollmentType::all()
        ]);
    }

    public function viewCreate()
    {
        return view('enrollments.form', [
            'enrollment' => null,
            'students' => Student::all(),
            'grades' => Grade::all(),
            'enrollmentTypes' => EnrollmentType::all()
        ]);
    }

    public function create(Request $request)
    {
        $request->validate([
            'estudiante_id' => 'required|exists:students,id',
            'grado_id' => 'required|exists:grades,id',
            'tipo_matricula_id' => 'required|exists:enrollment_types,id',
            'forma_pago' => 'required|string|max:100',
            'fecha' => 'required|date',
            'estado' => 'boolean'
        ]);

        $enrollment = Enrollment::create([
            'estudiante_id' => $request->estudiante_id,
            'grado_id' => $request->grado_id,
            'tipo_matricula_id' => $request->tipo_matricula_id,
            'forma_pago' => $request->forma_pago,
            'fecha' => $request->fecha,
            'estado' => $request->boolean('estado', true)
        ]);

        return redirect()->route('enrollments.index')
            ->with('success', 'Matrícula creada correctamente');
    }

    public function update(Request $request, $id)
    {
        $enrollment = $this->getEnrollmentById($id);

        $request->validate([
            'estudiante_id' => 'required|exists:students,id',
            'grado_id' => 'required|exists:grades,id',
            'tipo_matricula_id' => 'required|exists:enrollment_types,id',
            'forma_pago' => 'required|string|max:100',
            'fecha' => 'required|date',
            'estado' => 'boolean'
        ]);

        $enrollment->update([
            'estudiante_id' => $request->estudiante_id,
            'grado_id' => $request->grado_id,
            'tipo_matricula_id' => $request->tipo_matricula_id,
            'forma_pago' => $request->forma_pago,
            'fecha' => $request->fecha,
            'estado' => $request->boolean('estado', true)
        ]);

        return redirect()->route('enrollments.index')
            ->with('success', 'Matrícula actualizada correctamente');
    }

    public function delete($id)
    {
        $enrollment = $this->getEnrollmentById($id);
        $enrollment->delete();

        return redirect()->route('enrollments.index')
            ->with('success', 'Matrícula eliminada correctamente');
    }

    private function getEnrollmentById(int $id)
    {
        $enrollment = Enrollment::with('student', 'grade', 'enrollmentType')->find($id);
        if ($enrollment) {
            return $enrollment;
        } else {
            throw new NotFoundHttpException('La matrícula no se encuentra');
        }
    }
}
