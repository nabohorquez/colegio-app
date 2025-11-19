<?php

namespace Tests\Feature;

use App\Models\Employee;
use App\Models\User;
use App\Models\EmployeeContact;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EmployeeControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_an_employee()
    {
        $user = User::factory()->create();

        $employee = Employee::create([
            'user_id' => $user->id,
            'gender' => 'M',
            'marital_status' => 'SOLTERO'
        ]);

        $this->assertDatabaseHas('employees', [
            'user_id' => $user->id,
            'gender' => 'M',
        ]);

        $this->assertInstanceOf(Employee::class, $employee);
    }

    /** @test */
    public function employee_belongs_to_user()
    {
        $user = User::factory()->create();

        $employee = Employee::create([
            'user_id' => $user->id,
            'gender' => 'F',
            'marital_status' => 'CASADO'
        ]);

        $employeeWithUser = Employee::with('user')->find($employee->id);

        $this->assertInstanceOf(User::class, $employeeWithUser->user);
        $this->assertEquals($user->id, $employeeWithUser->user->id);
    }

    /** @test */
    public function it_can_update_employee()
    {
        $user = User::factory()->create();

        $employee = Employee::create([
            'user_id' => $user->id,
            'gender' => 'M',
            'marital_status' => 'SOLTERO'
        ]);

        $employee->update([
            'marital_status' => 'CASADO'
        ]);

        $this->assertDatabaseHas('employees', [
            'id' => $employee->id,
            'marital_status' => 'CASADO'
        ]);
    }

    /** @test */
    public function it_can_delete_employee()
    {
        $user = User::factory()->create();

        $employee = Employee::create([
            'user_id' => $user->id,
            'gender' => 'M',
            'marital_status' => 'SOLTERO'
        ]);

        $employeeId = $employee->id;
        $employee->delete();

        $this->assertDatabaseMissing('employees', ['id' => $employeeId]);
    }

    /** @test */
    public function employee_can_have_multiple_contacts()
    {
        $user = User::factory()->create();

        $employee = Employee::create([
            'user_id' => $user->id,
            'gender' => 'M',
            'marital_status' => 'SOLTERO'
        ]);

        EmployeeContact::create([
            'employee_id' => $employee->id,
            'type' => 'phone',
            'value' => '1234567890'
        ]);

        EmployeeContact::create([
            'employee_id' => $employee->id,
            'type' => 'email',
            'value' => 'employee@test.com'
        ]);

        $employeeWithContacts = Employee::with('contacts')->find($employee->id);

        $this->assertCount(2, $employeeWithContacts->contacts);
    }

    /** @test */
    public function it_returns_employee_with_user_and_contacts()
    {
        $user = User::factory()->create();

        $employee = Employee::create([
            'user_id' => $user->id,
            'gender' => 'F',
            'marital_status' => 'SOLTERO'
        ]);

        EmployeeContact::create([
            'employee_id' => $employee->id,
            'type' => 'phone',
            'value' => '1234567890'
        ]);

        $result = Employee::with(['user', 'contacts'])->find($employee->id);

        $this->assertNotNull($result->user);
        $this->assertNotEmpty($result->contacts);
        $this->assertInstanceOf(Employee::class, $result);
    }
}
