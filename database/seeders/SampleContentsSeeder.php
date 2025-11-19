<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Topic;
use App\Models\Subject;
use App\Models\User;

class SampleContentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener usuario administrador
        $adminUser = User::where('email', 'admin@example.com')->first() 
                    ?? User::first();

        if (!$adminUser) {
            $this->command->warn('⚠️ No se encontró usuario. Saltando ContentsSeeder.');
            return;
        }

        // Obtener materias existentes
        $subjects = Subject::all();

        if ($subjects->isEmpty()) {
            $this->command->warn('⚠️ No hay materias. Primero ejecute SubjectSeeder.');
            return;
        }

        // Limpiar tópicos existentes
        Topic::truncate();

        $contents = [
            [
                'title' => 'Fundamentos de la Programación',
                'description' => 'Introducción a conceptos básicos de programación: variables, tipos de datos, operadores y control de flujo. Base para estudios posteriores.',
                'created_by' => $adminUser->id,
            ],
            [
                'title' => 'Estructuras de Datos',
                'description' => 'Estudio de arreglos, listas, pilas, colas y grafos. Fundamentales para optimizar la solución de problemas.',
                'created_by' => $adminUser->id,
            ],
            [
                'title' => 'Algoritmos de Búsqueda y Ordenamiento',
                'description' => 'Métodos eficientes para buscar y ordenar datos. Algoritmos: búsqueda binaria, ordenamiento rápido y fusión.',
                'created_by' => $adminUser->id,
            ],
            [
                'title' => 'Teoría de Funciones',
                'description' => 'Concepto, tipos y aplicaciones de funciones en matemáticas. Base del análisis matemático.',
                'created_by' => $adminUser->id,
            ],
            [
                'title' => 'Cálculo Integral',
                'description' => 'Antiderivadas, integrales definidas e indefinidas. Esencial para resolver problemas de área y volumen.',
                'created_by' => $adminUser->id,
            ],
        ];

        foreach ($contents as $content) {
            try {
                Topic::create($content);
            } catch (\Exception $e) {
                $this->command->error('Error: ' . $e->getMessage());
            }
        }

        $this->command->info('✅ Se crearon ' . count($contents) . ' contenidos de ejemplo.');
    }
}
