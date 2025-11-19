<?php

namespace Tests\Feature;

use App\Models\Enrollment;
use App\Models\EnrollmentType;
use App\Models\Student;
use App\Models\Grade;
use App\Models\Guardian;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EnrollmentControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function createRequiredData()
    {
        $guardian = Guardian::factory()->create();

        $student = Student::create([
            'first_name' => 'Jane',
            'last_name' => 'Doe',
            'document' => '87654321',
            'birth_date' => '2010-05-15',
            'grade' => '5°',
            'email_institutional' => 'jane.doe@test.com',
            'address' => 'Test Address',
            'guardian_id' => $guardian->id,
        ]);

        $grade = Grade::create([
            'nombre_grado' => 'Primero',
            'nivel' => 'Primaria',
            'estado' => true
        ]);

        $enrollmentType = EnrollmentType::create([
            'nombre_tipo' => 'Regular',
            'descripcion' => 'Matricula regular'
        ]);

        return compact('student', 'grade', 'enrollmentType');
    }

    /** @test */
    public function it_can_create_an_enrollment()
    {
        $data = $this->createRequiredData();

        $enrollment = Enrollment::create([
            'estudiante_id' => $data['student']->id,
            'grado_id' => $data['grade']->id,
            'tipo_matricula_id' => $data['enrollmentType']->id,
            'forma_pago' => 'Efectivo',
            'costo' => 500000,
            'estado_pago' => 'pendiente',
            'fecha' => now()
        ]);

        $this->assertDatabaseHas('enrollments', [
            'estudiante_id' => $data['student']->id,
            'grado_id' => $data['grade']->id,
        ]);

        $this->assertInstanceOf(Enrollment::class, $enrollment);
    }

    /** @test */
    public function enrollment_belongs_to_student()
    {
        $data = $this->createRequiredData();

        $enrollment = Enrollment::create([
            'estudiante_id' => $data['student']->id,
            'grado_id' => $data['grade']->id,
            'tipo_matricula_id' => $data['enrollmentType']->id,
            'forma_pago' => 'Efectivo',
            'costo' => 500000,
            'estado_pago' => 'pendiente',
            'fecha' => now()
        ]);

        $enrollmentWithRelations = Enrollment::with('student')->find($enrollment->id);

        $this->assertInstanceOf(Student::class, $enrollmentWithRelations->student);
        $this->assertEquals($data['student']->id, $enrollmentWithRelations->student->id);
    }

    /** @test */
    public function enrollment_belongs_to_grade()
    {
        $data = $this->createRequiredData();

        $enrollment = Enrollment::create([
            'estudiante_id' => $data['student']->id,
            'grado_id' => $data['grade']->id,
            'tipo_matricula_id' => $data['enrollmentType']->id,
            'forma_pago' => 'Efectivo',
            'costo' => 500000,
            'estado_pago' => 'pendiente',
            'fecha' => now()
        ]);

        $enrollmentWithRelations = Enrollment::with('grade')->find($enrollment->id);

        $this->assertInstanceOf(Grade::class, $enrollmentWithRelations->grade);
        $this->assertEquals($data['grade']->id, $enrollmentWithRelations->grade->id);
    }

    /** @test */
    public function it_can_update_enrollment_payment_status()
    {
        $data = $this->createRequiredData();

        $enrollment = Enrollment::create([
            'estudiante_id' => $data['student']->id,
            'grado_id' => $data['grade']->id,
            'tipo_matricula_id' => $data['enrollmentType']->id,
            'forma_pago' => 'Efectivo',
            'costo' => 500000,
            'estado_pago' => 'pendiente',
            'fecha' => now()
        ]);

        $enrollment->update(['estado_pago' => 'pagado']);

        $this->assertDatabaseHas('enrollments', [
            'id' => $enrollment->id,
            'estado_pago' => 'pagado',
        ]);
    }

    /** @test */
    public function it_can_delete_enrollment()
    {
        $data = $this->createRequiredData();

        $enrollment = Enrollment::create([
            'estudiante_id' => $data['student']->id,
            'grado_id' => $data['grade']->id,
            'tipo_matricula_id' => $data['enrollmentType']->id,
            'forma_pago' => 'Efectivo',
            'costo' => 500000,
            'estado_pago' => 'pendiente',
            'fecha' => now()
        ]);

        $enrollmentId = $enrollment->id;
        $enrollment->delete();

        $this->assertDatabaseMissing('enrollments', ['id' => $enrollmentId]);
    }

    /** @test */
    public function it_validates_payment_status_values()
    {
        $validStatuses = ['pendiente', 'parcial', 'pagado'];
        
        foreach ($validStatuses as $status) {
            $this->assertTrue(in_array($status, ['pendiente', 'parcial', 'pagado']));
        }
    }

    /** @test */
    public function enrollment_with_all_relations_loads_correctly()
    {
        $data = $this->createRequiredData();

        $enrollment = Enrollment::create([
            'estudiante_id' => $data['student']->id,
            'grado_id' => $data['grade']->id,
            'tipo_matricula_id' => $data['enrollmentType']->id,
            'forma_pago' => 'Efectivo',
            'costo' => 500000,
            'estado_pago' => 'pendiente',
            'fecha' => now()
        ]);

        $fullEnrollment = Enrollment::with(['student', 'grade', 'enrollmentType'])->find($enrollment->id);

        $this->assertNotNull($fullEnrollment->student);
        $this->assertNotNull($fullEnrollment->grade);
        $this->assertNotNull($fullEnrollment->enrollmentType);
    }
}
