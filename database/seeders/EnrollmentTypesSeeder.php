<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EnrollmentType;

class EnrollmentTypesSeeder extends Seeder
{
    public function run()
    {
        $types = [
            ['name' => 'Regular', 'code' => 'REG', 'description' => 'Regular enrollment', 'fee' => 1000.00, 'is_active' => true],
            ['name' => 'Scholarship', 'code' => 'SCH', 'description' => 'Scholarship student', 'fee' => 0.00, 'is_active' => true],
            ['name' => 'Transfer', 'code' => 'TRF', 'description' => 'Transfer from other institution', 'fee' => 500.00, 'is_active' => true],
        ];

        foreach ($types as $t) {
            EnrollmentType::updateOrCreate(['code' => $t['code']], $t);
        }
    }
}
