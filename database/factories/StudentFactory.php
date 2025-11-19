<?php

namespace Database\Factories;

use App\Models\Student;
use App\Models\Guardian;
use Illuminate\Database\Eloquent\Factories\Factory;

class StudentFactory extends Factory
{
    protected $model = Student::class;

    public function definition()
    {
        return [
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'document' => $this->faker->unique()->numerify('########'),
            'birth_date' => $this->faker->date('Y-m-d', '2015-01-01'),
            'grade' => $this->faker->randomElement(['1°', '2°', '3°', '4°', '5°', '6°', '7°', '8°', '9°', '10°', '11°']),
            'email_institutional' => $this->faker->unique()->safeEmail(),
            'address' => $this->faker->address(),
            'guardian_id' => Guardian::factory(),
        ];
    }
}
