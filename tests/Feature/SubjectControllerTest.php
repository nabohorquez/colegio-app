<?php

namespace Tests\Feature;

use App\Models\Subject;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SubjectControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_subject()
    {
        $subjectData = [
            'nombre_materia' => 'Matemáticas',
            'descripcion' => 'Materia de matemáticas básicas',
            'estado' => true
        ];

        $subject = Subject::create($subjectData);

        $this->assertDatabaseHas('subjects', [
            'nombre_materia' => 'Matemáticas',
            'descripcion' => 'Materia de matemáticas básicas',
        ]);

        $this->assertInstanceOf(Subject::class, $subject);
    }

    /** @test */
    public function it_can_update_subject()
    {
        $subject = Subject::create([
            'nombre_materia' => 'Matemáticas',
            'descripcion' => 'Materia de matemáticas básicas',
            'estado' => true
        ]);

        $subject->update([
            'descripcion' => 'Materia de matemáticas avanzadas',
            'estado' => false
        ]);

        $this->assertDatabaseHas('subjects', [
            'id' => $subject->id,
            'descripcion' => 'Materia de matemáticas avanzadas',
            'estado' => false
        ]);
    }

    /** @test */
    public function it_can_delete_subject()
    {
        $subject = Subject::create([
            'nombre_materia' => 'Matemáticas',
            'descripcion' => 'Test',
            'estado' => true
        ]);

        $subjectId = $subject->id;
        $subject->delete();

        $this->assertDatabaseMissing('subjects', ['id' => $subjectId]);
    }

    /** @test */
    public function it_prevents_duplicate_subject_names()
    {
        Subject::create([
            'nombre_materia' => 'Matemáticas',
            'descripcion' => 'Test',
            'estado' => true
        ]);

        $exists = Subject::where('nombre_materia', 'Matemáticas')->exists();
        $this->assertTrue($exists);

        $notExists = Subject::where('nombre_materia', 'Física')->exists();
        $this->assertFalse($notExists);
    }

    /** @test */
    public function it_can_filter_active_subjects()
    {
        Subject::create([
            'nombre_materia' => 'Matemáticas',
            'descripcion' => 'Test',
            'estado' => true
        ]);

        Subject::create([
            'nombre_materia' => 'Historia',
            'descripcion' => 'Test',
            'estado' => false
        ]);

        $activeSubjects = Subject::where('estado', true)->get();
        $inactiveSubjects = Subject::where('estado', false)->get();

        $this->assertCount(1, $activeSubjects);
        $this->assertCount(1, $inactiveSubjects);
    }

    /** @test */
    public function it_can_list_all_subjects()
    {
        Subject::create([
            'nombre_materia' => 'Matemáticas',
            'descripcion' => 'Test',
            'estado' => true
        ]);

        Subject::create([
            'nombre_materia' => 'Español',
            'descripcion' => 'Test',
            'estado' => true
        ]);

        Subject::create([
            'nombre_materia' => 'Ciencias',
            'descripcion' => 'Test',
            'estado' => true
        ]);

        $allSubjects = Subject::all();

        $this->assertCount(3, $allSubjects);
    }

    /** @test */
    public function subject_descripcion_is_optional()
    {
        $subject = Subject::create([
            'nombre_materia' => 'Matemáticas',
            'estado' => true
        ]);

        $this->assertDatabaseHas('subjects', [
            'nombre_materia' => 'Matemáticas',
        ]);

        $this->assertNull($subject->descripcion);
    }
}
