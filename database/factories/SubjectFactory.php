<?php

namespace Database\Factories;

use App\Models\Subject;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubjectFactory extends Factory
{
    protected $model = Subject::class;

    public function definition()
    {
        return [
            'nombre_materia' => $this->faker->unique()->randomElement(['Matemáticas', 'Español', 'Ciencias', 'Historia', 'Geografía', 'Inglés', 'Educación Física', 'Arte']),
            'descripcion' => $this->faker->sentence(),
            'estado' => $this->faker->boolean(80),
        ];
    }
}
