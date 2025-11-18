<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Grade;

class GradeSeeder extends Seeder
{
    public function run(): void
    {
        $grades = [
            // Primaria
            ['nombre_grado' => 'Primero de Primaria', 'nivel' => '1', 'estado' => true],
            ['nombre_grado' => 'Segundo de Primaria', 'nivel' => '2', 'estado' => true],
            ['nombre_grado' => 'Tercero de Primaria', 'nivel' => '3', 'estado' => true],
            ['nombre_grado' => 'Cuarto de Primaria', 'nivel' => '4', 'estado' => true],
            ['nombre_grado' => 'Quinto de Primaria', 'nivel' => '5', 'estado' => true],
            ['nombre_grado' => 'Sexto de Primaria', 'nivel' => '6', 'estado' => true],
            
            // Secundaria
            ['nombre_grado' => 'Séptimo de Secundaria', 'nivel' => '7', 'estado' => true],
            ['nombre_grado' => 'Octavo de Secundaria', 'nivel' => '8', 'estado' => true],
            ['nombre_grado' => 'Noveno de Secundaria', 'nivel' => '9', 'estado' => true],
            ['nombre_grado' => 'Décimo de Secundaria', 'nivel' => '10', 'estado' => true],
            ['nombre_grado' => 'Once de Secundaria', 'nivel' => '11', 'estado' => true],
        ];

        $count = 0;
        foreach ($grades as $grade) {
            try {
                Grade::create($grade);
                $count++;
            } catch (\Exception $e) {
                $this->command->error("Error al crear grado {$grade['nombre_grado']}: " . $e->getMessage());
            }
        }
        
        $this->command->info("Se crearon {$count} grados exitosamente.");
    }
}
