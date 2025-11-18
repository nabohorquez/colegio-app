<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\EnrollmentType;

class EnrollmentTypeSeeder extends Seeder
{
    public function run(): void
    {
        $enrollmentTypes = [
            [
                'nombre_tipo' => 'Regular',
                'descripcion' => 'Matrícula regular para estudiantes de nuevo ingreso o continuidad',
                'estado' => true,
            ],
            [
                'nombre_tipo' => 'Especial',
                'descripcion' => 'Matrícula especial con necesidades educativas particulares',
                'estado' => true,
            ],
            [
                'nombre_tipo' => 'Becado',
                'descripcion' => 'Matrícula para estudiantes con beca académica o socioeconómica',
                'estado' => true,
            ],
            [
                'nombre_tipo' => 'Extranjero',
                'descripcion' => 'Matrícula para estudiantes extranjeros',
                'estado' => true,
            ],
            [
                'nombre_tipo' => 'Trasferencia',
                'descripcion' => 'Matrícula de estudiantes que transfieren desde otra institución',
                'estado' => true,
            ],
        ];

        foreach ($enrollmentTypes as $type) {
            EnrollmentType::create($type);
        }
    }
}
