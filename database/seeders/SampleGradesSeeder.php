<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Grade;
use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Str;

class SampleGradesSeeder extends Seeder
{
    public function run()
    {
        // Ensure there's at least one user to set as created_by
        $user = User::first();
        if (!$user) {
            $user = User::create([
                'name' => 'Seeder Admin',
                'email' => 'seeder.admin@example.com',
                'password' => bcrypt('password123')
            ]);
        }

        $students = Student::take(3)->get();
        $subjects = [
            'Matemáticas',
            'Lengua Española',
            'Inglés',
            'Ciencias Naturales',
            'Estudios Sociales',
            'Educación Física',
            'Artes',
            'Informática',
        ];

        foreach ($students as $student) {
            // Create grades for multiple subjects for each student
            foreach ($subjects as $subject) {
                Grade::firstOrCreate([
                    'student_id' => $student->id,
                    'subject' => $subject,
                    'academic_period' => '2025-I'
                ], [
                    'first_partial' => round(rand(25, 50) / 10, 1), // 2.5 - 5.0
                    'second_partial' => round(rand(25, 50) / 10, 1),
                    'final_grade' => round(rand(25, 50) / 10, 1),
                    'notes' => 'Calificación generada automáticamente',
                    'created_by' => $user->id
                ]);
            }
        }
    }
}
