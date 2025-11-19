<?php

namespace Tests\Feature;

use App\Models\Student;
use App\Models\Guardian;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StudentControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    /** @test */
    public function it_can_create_a_student()
    {
        $guardian = Guardian::factory()->create();

        $studentData = [
            'first_name' => 'Jane',
            'last_name' => 'Doe',
            'document' => '87654321',
            'birth_date' => '2010-05-15',
            'grade' => '5°',
            'email_institutional' => 'jane.doe@test.com',
            'address' => 'Test Address',
            'guardian_id' => $guardian->id,
        ];

        $student = Student::create($studentData);

        $this->assertDatabaseHas('students', [
            'first_name' => 'Jane',
            'last_name' => 'Doe',
            'document' => '87654321',
        ]);

        $this->assertInstanceOf(Student::class, $student);
    }

    /** @test */
    public function it_can_get_student_by_id()
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

        $foundStudent = Student::with('guardian')->find($student->id);

        $this->assertNotNull($foundStudent);
        $this->assertEquals('Jane', $foundStudent->first_name);
        $this->assertNotNull($foundStudent->guardian);
    }

    /** @test */
    public function it_can_update_student()
    {
        $guardian = Guardian::factory()->create();

        $student = Student::create([
            'first_name' => 'Jane',
            'last_name' => 'Doe',
            'document' => '87654321',
            'birth_date' => '2010-05-15',
            'grade' => '5°',
            'email_institutional' => 'jane.doe@test.com',
            'address' => 'Old Address',
            'guardian_id' => $guardian->id,
        ]);

        $student->update(['address' => 'New Address']);

        $this->assertDatabaseHas('students', [
            'id' => $student->id,
            'address' => 'New Address',
        ]);
    }

    /** @test */
    public function it_can_delete_student()
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

        $studentId = $student->id;
        $student->delete();

        $this->assertDatabaseMissing('students', ['id' => $studentId]);
    }

    /** @test */
    public function student_belongs_to_guardian()
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

        $this->assertInstanceOf(Guardian::class, $student->guardian);
        $this->assertEquals($guardian->id, $student->guardian->id);
    }
}
