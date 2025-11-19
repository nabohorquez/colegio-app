<?php

namespace Database\Factories;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeeFactory extends Factory
{
    protected $model = Employee::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'gender' => $this->faker->randomElement(['F', 'M', 'X']),
            'marital_status' => $this->faker->randomElement(['SOLTERO', 'CASADO', 'DIVORCIADO', 'UNIÓN LIBRE', 'VIUDO']),
        ];
    }
}
