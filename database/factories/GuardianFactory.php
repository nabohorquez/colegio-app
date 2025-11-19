<?php

namespace Database\Factories;

use App\Models\Guardian;
use Illuminate\Database\Eloquent\Factories\Factory;

class GuardianFactory extends Factory
{
    protected $model = Guardian::class;

    public function definition()
    {
        return [
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'email' => $this->faker->unique()->safeEmail(),
            'gender' => $this->faker->randomElement(['F', 'M', 'X']),
            'marital_status' => $this->faker->randomElement(['SOLTERO', 'CASADO', 'DIVORCIADO', 'UNION LIBRE', 'VIUDO']),
        ];
    }
}
