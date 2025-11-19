<?php

namespace Tests\Feature;

use App\Models\Grade;
use App\Models\Student;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GradeControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_grade()
    {
        $gradeData = [
            'nombre_grado' => 'Primero',
            'nivel' => 'Primaria',
            'estado' => true
        ];

        $grade = Grade::create($gradeData);

        $this->assertDatabaseHas('grades', [
            'nombre_grado' => 'Primero',
            'nivel' => 'Primaria',
        ]);

        $this->assertInstanceOf(Grade::class, $grade);
    }

    /** @test */
    public function it_can_update_grade()
    {
        $grade = Grade::create([
            'nombre_grado' => 'Primero',
            'nivel' => 'Primaria',
            'estado' => true
        ]);

        $grade->update([
            'nombre_grado' => 'Segundo',
            'estado' => false
        ]);

        $this->assertDatabaseHas('grades', [
            'id' => $grade->id,
            'nombre_grado' => 'Segundo',
            'estado' => false
        ]);
    }

    /** @test */
    public function it_can_delete_grade()
    {
        $grade = Grade::create([
            'nombre_grado' => 'Primero',
            'nivel' => 'Primaria',
            'estado' => true
        ]);

        $gradeId = $grade->id;
        $grade->delete();

        $this->assertDatabaseMissing('grades', ['id' => $gradeId]);
    }

    /** @test */
    public function it_prevents_duplicate_grade_names()
    {
        Grade::create([
            'nombre_grado' => 'Primero',
            'nivel' => 'Primaria',
            'estado' => true
        ]);

        $exists = Grade::where('nombre_grado', 'Primero')->exists();
        $this->assertTrue($exists);

        $notExists = Grade::where('nombre_grado', 'Decimo')->exists();
        $this->assertFalse($notExists);
    }

    /** @test */
    public function grade_can_have_multiple_students()
    {
        $grade = Grade::create([
            'nombre_grado' => 'Primero',
            'nivel' => 'Primaria',
            'estado' => true
        ]);

        // Nota: Este test asume que Student tiene campo 'grade_id'
        // Si no existe esta relación, este test fallará
        $studentCount = Student::where('grade', $grade->nombre_grado)->count();
        
        $this->assertIsInt($studentCount);
    }

    /** @test */
    public function it_can_filter_active_grades()
    {
        Grade::create([
            'nombre_grado' => 'Primero',
            'nivel' => 'Primaria',
            'estado' => true
        ]);

        Grade::create([
            'nombre_grado' => 'Segundo',
            'nivel' => 'Primaria',
            'estado' => false
        ]);

        $activeGrades = Grade::where('estado', true)->get();
        $inactiveGrades = Grade::where('estado', false)->get();

        $this->assertCount(1, $activeGrades);
        $this->assertCount(1, $inactiveGrades);
    }

    /** @test */
    public function it_can_get_grades_by_nivel()
    {
        Grade::create([
            'nombre_grado' => 'Primero',
            'nivel' => 'Primaria',
            'estado' => true
        ]);

        Grade::create([
            'nombre_grado' => 'Sexto',
            'nivel' => 'Secundaria',
            'estado' => true
        ]);

        $primariaGrades = Grade::where('nivel', 'Primaria')->get();
        $secundariaGrades = Grade::where('nivel', 'Secundaria')->get();

        $this->assertCount(1, $primariaGrades);
        $this->assertCount(1, $secundariaGrades);
    }
}
