<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Activity;
use App\Models\User;

class ActivitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtenemos el ID del primer usuario administrador
        $adminUser = User::first();

        if (!$adminUser) {
            $this->command->error('No users found in the database. Please run the user seeder first.');
            return;
        }

        $activities = [
            [
                'title' => 'Taller de Escritura Creativa',
                'description' => 'Actividad para fomentar la escritura de cuentos y poemas.',
                'created_by' => $adminUser->id,
            ],
            [
                'title' => 'Olimpiadas de Matemáticas',
                'description' => 'Competencia de resolución de problemas matemáticos.',
                'created_by' => $adminUser->id,
            ],
            [
                'title' => 'Feria de Ciencias',
                'description' => 'Exposición de proyectos científicos de los estudiantes.',
                'created_by' => $adminUser->id,
            ],
            [
                'title' => 'Club de Debate',
                'description' => 'Práctica de argumentación y oratoria sobre temas de actualidad.',
                'created_by' => $adminUser->id,
            ],
            [
                'title' => 'Torneo Deportivo Interescolar',
                'description' => 'Competencias de fútbol, baloncesto y voleibol.',
                'created_by' => $adminUser->id,
            ],
        ];

        foreach ($activities as $activity) {
            Activity::create($activity);
        }

        $this->command->info('Created ' . count($activities) . ' sample activities.');
    }
}
