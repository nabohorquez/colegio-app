<?php

namespace Tests\Feature;

use App\Models\Guardian;
use App\Models\GuardianContact;
use App\Models\Student;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GuardianControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_guardian()
    {
        $guardianData = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@test.com',
            'gender' => 'M',
            'marital_status' => 'SOLTERO'
        ];

        $guardian = Guardian::create($guardianData);

        $this->assertDatabaseHas('guardians', [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@test.com',
        ]);

        $this->assertInstanceOf(Guardian::class, $guardian);
    }

    /** @test */
    public function it_can_update_guardian()
    {
        $guardian = Guardian::factory()->create();

        $guardian->update([
            'email' => 'newemail@test.com',
            'marital_status' => 'CASADO'
        ]);

        $this->assertDatabaseHas('guardians', [
            'id' => $guardian->id,
            'email' => 'newemail@test.com',
            'marital_status' => 'CASADO'
        ]);
    }

    /** @test */
    public function it_can_delete_guardian()
    {
        $guardian = Guardian::factory()->create();

        $guardianId = $guardian->id;
        $guardian->delete();

        $this->assertDatabaseMissing('guardians', ['id' => $guardianId]);
    }

    /** @test */
    public function guardian_can_have_multiple_contacts()
    {
        $guardian = Guardian::factory()->create();

        GuardianContact::create([
            'guardian_id' => $guardian->id,
            'type' => 'telefono',
            'value' => '1234567890'
        ]);

        GuardianContact::create([
            'guardian_id' => $guardian->id,
            'type' => 'correo',
            'value' => 'contact@test.com'
        ]);

        $guardianWithContacts = Guardian::with('contacts')->find($guardian->id);

        $this->assertCount(2, $guardianWithContacts->contacts);
    }

    /** @test */
    public function guardian_can_have_multiple_students()
    {
        $guardian = Guardian::factory()->create();

        Student::create([
            'first_name' => 'Jane',
            'last_name' => 'Doe',
            'document' => '11111111',
            'birth_date' => '2010-05-15',
            'grade' => '5°',
            'email_institutional' => 'jane@test.com',
            'guardian_id' => $guardian->id,
        ]);

        Student::create([
            'first_name' => 'Jack',
            'last_name' => 'Doe',
            'document' => '22222222',
            'birth_date' => '2012-03-20',
            'grade' => '3°',
            'email_institutional' => 'jack@test.com',
            'guardian_id' => $guardian->id,
        ]);

        $guardianWithStudents = Guardian::with('students')->find($guardian->id);

        $this->assertCount(2, $guardianWithStudents->students);
    }

    /** @test */
    public function it_returns_guardian_with_contacts_and_students()
    {
        $guardian = Guardian::factory()->create();

        GuardianContact::create([
            'guardian_id' => $guardian->id,
            'type' => 'telefono',
            'value' => '1234567890'
        ]);

        Student::create([
            'first_name' => 'Jane',
            'last_name' => 'Doe',
            'document' => '11111111',
            'birth_date' => '2010-05-15',
            'grade' => '5°',
            'email_institutional' => 'jane@test.com',
            'guardian_id' => $guardian->id,
        ]);

        GuardianContact::create([
            'guardian_id' => $guardian->id,
            'type' => 'telefono',
            'value' => '9876543210'
        ]);

        $result = Guardian::with(['contacts', 'students'])->find($guardian->id);

        $this->assertNotEmpty($result->contacts);
        $this->assertNotEmpty($result->students);
        $this->assertInstanceOf(Guardian::class, $result);
    }
}
