<?php

namespace Database\Factories;

use App\Models\Grade;
use Illuminate\Database\Eloquent\Factories\Factory;

class GradeFactory extends Factory
{
    protected $model = Grade::class;

    public function definition()
    {
        return [
            'nombre_grado' => $this->faker->unique()->randomElement(['Primero', 'Segundo', 'Tercero', 'Cuarto', 'Quinto', 'Sexto', 'Séptimo', 'Octavo', 'Noveno', 'Décimo', 'Once']),
            'nivel' => $this->faker->randomElement(['Primaria', 'Secundaria']),
            'estado' => $this->faker->boolean(80),
        ];
    }
}
