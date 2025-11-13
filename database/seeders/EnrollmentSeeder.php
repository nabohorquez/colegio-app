<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Enrollment;
use App\Models\Student;
use App\Models\Grade;
use App\Models\EnrollmentType;

class EnrollmentSeeder extends Seeder
{
    public function run(): void
    {
        // Obtener datos existentes
        $students = Student::all();
        $grades = Grade::all();
        $enrollmentTypes = EnrollmentType::all();

        if ($students->isEmpty() || $grades->isEmpty() || $enrollmentTypes->isEmpty()) {
            $this->command->warn('No hay estudiantes, grados o tipos de matrícula. Ejecute primero sus seeders.');
            return;
        }

        $paymentMethods = ['efectivo', 'cheque', 'transferencia', 'tarjeta de crédito'];
        $paymentStatuses = ['pendiente', 'parcial', 'pagado'];

        // Crear matrículas para estudiantes existentes
        $enrollmentCount = 0;
        foreach ($students->take(10) as $student) {
            // Cada estudiante puede tener 1-2 matrículas en diferentes grados
            $numEnrollments = rand(1, 2);
            
            for ($i = 0; $i < $numEnrollments; $i++) {
                $grade = $grades->random();
                $enrollmentType = $enrollmentTypes->random();
                $paymentMethod = $paymentMethods[array_rand($paymentMethods)];
                
                // Determinar costo según tipo de matrícula
                $baseCost = 500000; // Costo base en pesos
                $costMultiplier = match($enrollmentType->nombre_tipo) {
                    'Regular' => 1.0,
                    'Especial' => 1.5,
                    'Becado' => 0.5,
                    'Extranjero' => 1.3,
                    'Trasferencia' => 0.8,
                    default => 1.0,
                };
                
                $cost = $baseCost * $costMultiplier;
                $paymentStatus = $paymentStatuses[array_rand($paymentStatuses)];

                Enrollment::create([
                    'estudiante_id' => $student->id,
                    'grado_id' => $grade->id,
                    'tipo_matricula_id' => $enrollmentType->id,
                    'forma_pago' => $paymentMethod,
                    'costo' => $cost,
                    'estado_pago' => $paymentStatus,
                    'fecha' => now()->subDays(rand(0, 30)),
                    'estado' => true,
                ]);

                $enrollmentCount++;
            }
        }

        $this->command->info("Se crearon {$enrollmentCount} matrículas exitosamente.");
    }
}
