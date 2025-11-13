<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Student;
use App\Models\Guardian;

class StudentDataSeeder extends Seeder
{
    public function run(): void
    {
        // Primero asegúrate de que haya guardianes
        $guardians = Guardian::all();
        
        if ($guardians->isEmpty()) {
            // Crear algunos guardianes si no existen
            $guardians = [];
            $guardianData = [
                ['first_name' => 'Juan', 'last_name' => 'Pérez', 'email' => 'juan.perez@email.com', 'gender' => 'M'],
                ['first_name' => 'María', 'last_name' => 'García', 'email' => 'maria.garcia@email.com', 'gender' => 'F'],
                ['first_name' => 'Carlos', 'last_name' => 'López', 'email' => 'carlos.lopez@email.com', 'gender' => 'M'],
                ['first_name' => 'Ana', 'last_name' => 'Martínez', 'email' => 'ana.martinez@email.com', 'gender' => 'F'],
                ['first_name' => 'Roberto', 'last_name' => 'Rodríguez', 'email' => 'roberto.rodriguez@email.com', 'gender' => 'M'],
            ];
            
            foreach ($guardianData as $data) {
                $guardians[] = Guardian::create($data);
            }
        }

        $students = [
            ['first_name' => 'Santiago', 'last_name' => 'Pérez García', 'birth_date' => '2010-05-15', 'document' => '1001234567', 'grade' => '6', 'guardian_id' => $guardians[0]->id ?? 1],
            ['first_name' => 'Camila', 'last_name' => 'Gómez López', 'birth_date' => '2009-08-22', 'document' => '1001234568', 'grade' => '7', 'guardian_id' => $guardians[1]->id ?? 2],
            ['first_name' => 'Mateo', 'last_name' => 'Rodríguez Martínez', 'birth_date' => '2010-03-10', 'document' => '1001234569', 'grade' => '6', 'guardian_id' => $guardians[2]->id ?? 3],
            ['first_name' => 'Valentina', 'last_name' => 'López García', 'birth_date' => '2011-07-18', 'document' => '1001234570', 'grade' => '5', 'guardian_id' => $guardians[3]->id ?? 4],
            ['first_name' => 'Miguel', 'last_name' => 'Jiménez Sánchez', 'birth_date' => '2009-11-25', 'document' => '1001234571', 'grade' => '8', 'guardian_id' => $guardians[4]->id ?? 5],
            ['first_name' => 'Isabella', 'last_name' => 'Hernández Morales', 'birth_date' => '2010-02-14', 'document' => '1001234572', 'grade' => '6', 'guardian_id' => $guardians[0]->id ?? 1],
            ['first_name' => 'Andrés', 'last_name' => 'Castillo Romero', 'birth_date' => '2011-09-30', 'document' => '1001234573', 'grade' => '4', 'guardian_id' => $guardians[1]->id ?? 2],
            ['first_name' => 'Sofía', 'last_name' => 'Vargas López', 'birth_date' => '2010-06-08', 'document' => '1001234574', 'grade' => '7', 'guardian_id' => $guardians[2]->id ?? 3],
            ['first_name' => 'Javier', 'last_name' => 'Navarro García', 'birth_date' => '2009-12-20', 'document' => '1001234575', 'grade' => '9', 'guardian_id' => $guardians[3]->id ?? 4],
            ['first_name' => 'Laura', 'last_name' => 'Flores Mendez', 'birth_date' => '2010-04-05', 'document' => '1001234576', 'grade' => '6', 'guardian_id' => $guardians[4]->id ?? 5],
        ];

        foreach ($students as $student) {
            Student::create($student);
        }

        $this->command->info('Se crearon 10 estudiantes exitosamente.');
    }
}
