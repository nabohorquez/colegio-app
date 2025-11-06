<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Permissions extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            ['permission' => 'view'],
            ['permission' => 'create'],
            ['permission' => 'edit'],
            ['permission' => 'delete'],
        ];

        foreach ($permissions as $permissionData) {
            // Make seeding idempotent: don't insert duplicates
            \App\Models\Permission::firstOrCreate([
                'permission' => $permissionData['permission'],
            ]);
        }
    }
}
