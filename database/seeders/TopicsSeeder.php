<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Topic;
use App\Models\User;

class TopicsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtenemos el ID del primer usuario administrador
        $adminUser = User::first();

        if (!$adminUser) {
            $this->command->error('No hay usuarios en la base de datos. Por favor, ejecuta primero el seeder de usuarios.');
            return;
        }

        $topics = [
            [
                'title' => 'Matemáticas Básicas',
                'description' => 'Fundamentos de aritmética, álgebra y geometría para el nivel básico.',
                'created_by' => $adminUser->id,
            ],
            [
                'title' => 'Lengua y Literatura',
                'description' => 'Comprensión lectora, gramática y análisis literario.',
                'created_by' => $adminUser->id,
            ],
            [
                'title' => 'Ciencias Naturales',
                'description' => 'Estudio de los seres vivos, el medio ambiente y fenómenos naturales.',
                'created_by' => $adminUser->id,
            ],
            [
                'title' => 'Historia y Geografía',
                'description' => 'Historia universal, nacional y geografía básica.',
                'created_by' => $adminUser->id,
            ],
            [
                'title' => 'Inglés Básico',
                'description' => 'Vocabulario fundamental, gramática básica y conversación.',
                'created_by' => $adminUser->id,
            ],
            [
                'title' => 'Educación Artística',
                'description' => 'Expresión artística, música y manualidades.',
                'created_by' => $adminUser->id,
            ],
            [
                'title' => 'Educación Física',
                'description' => 'Desarrollo físico, deportes y hábitos saludables.',
                'created_by' => $adminUser->id,
            ],
            [
                'title' => 'Tecnología e Informática',
                'description' => 'Uso básico de computadoras y herramientas digitales.',
                'created_by' => $adminUser->id,
            ],
        ];

        foreach ($topics as $topic) {
            Topic::create($topic);
        }

        $this->command->info('Se han creado ' . count($topics) . ' temas de ejemplo.');
    }
}
