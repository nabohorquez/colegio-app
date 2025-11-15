<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class SampleStudentsSeeder extends Seeder
{
    public function run()
    {
        $students = [
            [
                'first_name' => 'Juan',
                'last_name' => 'Perez',
                'birth_date' => '2010-03-12',
                'document' => 'DOC1001',
                'grade' => '5-A',
                'guardian_id' => null,
            ],
            [
                'first_name' => 'María',
                'last_name' => 'Gomez',
                'birth_date' => '2011-07-22',
                'document' => 'DOC1002',
                'grade' => '5-B',
                'guardian_id' => null,
            ],
            [
                'first_name' => 'Pedro',
                'last_name' => 'Ramirez',
                'birth_date' => '2009-11-02',
                'document' => 'DOC1003',
                'grade' => '6-A',
                'guardian_id' => null,
            ],
        ];

        foreach ($students as $data) {
            // Use firstOrCreate to avoid duplicates when seeding multiple times
            Student::firstOrCreate(
                ['document' => $data['document']],
                $data
            );
        }
    }
}
