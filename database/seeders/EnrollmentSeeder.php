<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Enrollment;
use App\Models\Student;
use App\Models\Grade;
use App\Models\EnrollmentType;
use Illuminate\Support\Facades\DB;

class EnrollmentSeeder extends Seeder
{
    public function run(): void
    {
        // Obtener datos existentes usando DB directamente
        $students = DB::table('students')->get();
        $grades = DB::table('grades')->get();
        $enrollmentTypes = DB::table('enrollment_types')->get();

        if ($students->count() === 0 || $grades->count() === 0 || $enrollmentTypes->count() === 0) {
            $this->command->warn('No hay estudiantes: ' . $students->count() . ', grados: ' . $grades->count() . ', tipos de matrícula: ' . $enrollmentTypes->count());
            return;
        }

        $this->command->info('Iniciando seeding de matrículas...');
        $this->command->info('Estudiantes: ' . $students->count() . ', Grados: ' . $grades->count() . ', Tipos: ' . $enrollmentTypes->count());

        $paymentMethods = ['efectivo', 'cheque', 'transferencia', 'tarjeta de crédito'];
        $paymentStatuses = ['pendiente', 'parcial', 'pagado'];

        // Crear matrículas para estudiantes existentes
        $enrollmentCount = 0;
        foreach ($students->take(10) as $student) {
            /** @var \stdClass $student */
            // Cada estudiante puede tener 1-2 matrículas en diferentes grados
            $numEnrollments = rand(1, 2);
            
            for ($i = 0; $i < $numEnrollments; $i++) {
                /** @var Grade $grade */
                $grade = $grades->random();
                /** @var EnrollmentType $enrollmentType */
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
