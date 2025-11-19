<?php

namespace Database\Factories;

use App\Models\EnrollmentType;
use Illuminate\Database\Eloquent\Factories\Factory;

class EnrollmentTypeFactory extends Factory
{
    protected $model = EnrollmentType::class;

    public function definition()
    {
        return [
            'nombre_tipo' => $this->faker->unique()->randomElement(['Regular', 'Especial', 'Transferencia', 'Reingreso']),
            'descripcion' => $this->faker->sentence(),
        ];
    }
}
