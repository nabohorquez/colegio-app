<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Activity;
use App\Models\User;

class SampleActivitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener un usuario administrador existente
        $adminUser = User::where('email', 'admin@example.com')->first() 
                    ?? User::first();

        if (!$adminUser) {
            $this->command->warn('⚠️ No se encontró usuario administrador. Saltando ActivitiesSeeder.');
            return;
        }

        // Limpiar actividades existentes
        Activity::truncate();

        $activities = [
            [
                'title' => 'Taller de Escritura Creativa',
                'description' => 'Actividad para fomentar la escritura de cuentos y poemas. Los estudiantes crearán historias originales y compartirán con la clase.',
                'created_by' => $adminUser->id,
            ],
            [
                'title' => 'Olimpiadas de Matemáticas',
                'description' => 'Competencia de resolución de problemas matemáticos. Se evaluará rapidez y precisión en la solución de ejercicios complejos.',
                'created_by' => $adminUser->id,
            ],
            [
                'title' => 'Feria de Ciencias',
                'description' => 'Exposición de proyectos científicos de los estudiantes. Cada grupo presentará investigaciones sobre temas de física, química o biología.',
                'created_by' => $adminUser->id,
            ],
            [
                'title' => 'Club de Debate',
                'description' => 'Práctica de argumentación y oratoria sobre temas de actualidad. Los estudiantes aprenderán técnicas de persuasión y comunicación.',
                'created_by' => $adminUser->id,
            ],
            [
                'title' => 'Torneo Deportivo Interescolar',
                'description' => 'Competencias de fútbol, baloncesto y voleibol entre instituciones educativas. Eventos programados para fin de semestre.',
                'created_by' => $adminUser->id,
            ],
        ];

        foreach ($activities as $activity) {
            try {
                Activity::create($activity);
            } catch (\Exception $e) {
                $this->command->error('Error creando actividad: ' . $e->getMessage());
            }
        }

        $this->command->info('✅ Se crearon ' . count($activities) . ' actividades de ejemplo.');
    }
}
