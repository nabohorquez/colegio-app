<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Subject;

class SubjectSeeder extends Seeder
{
    public function run(): void
    {
        $subjects = [
            // Materias Básicas
            [
                'nombre_materia' => 'Matemáticas',
                'descripcion' => 'Enseñanza de operaciones matemáticas, álgebra, geometría y cálculo',
                'estado' => true,
            ],
            [
                'nombre_materia' => 'Español',
                'descripcion' => 'Gramática, literatura, comprensión lectora y expresión oral',
                'estado' => true,
            ],
            [
                'nombre_materia' => 'Inglés',
                'descripcion' => 'Idioma extranjero, vocabulario y comunicación en inglés',
                'estado' => true,
            ],
            [
                'nombre_materia' => 'Ciencias Naturales',
                'descripcion' => 'Biología, química y física',
                'estado' => true,
            ],
            [
                'nombre_materia' => 'Ciencias Sociales',
                'descripcion' => 'Historia, geografía y educación cívica',
                'estado' => true,
            ],
            
            // Materias Complementarias
            [
                'nombre_materia' => 'Educación Física',
                'descripcion' => 'Actividades deportivas y promoción de la salud',
                'estado' => true,
            ],
            [
                'nombre_materia' => 'Educación Artística',
                'descripcion' => 'Artes plásticas, música y expresión artística',
                'estado' => true,
            ],
            [
                'nombre_materia' => 'Informática',
                'descripcion' => 'Computación, programación y manejo de software',
                'estado' => true,
            ],
            [
                'nombre_materia' => 'Filosofía',
                'descripcion' => 'Pensamiento crítico, ética y reflexión sobre la existencia',
                'estado' => true,
            ],
            [
                'nombre_materia' => 'Religión',
                'descripcion' => 'Formación espiritual y valores religiosos',
                'estado' => true,
            ],
        ];

        foreach ($subjects as $subject) {
            Subject::create($subject);
        }
    }
}
