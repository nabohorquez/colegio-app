<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class Roles extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Use firstOrCreate so seeding is idempotent and safe to run multiple times
        Role::firstOrCreate(
            ['rol_name' => 'SuperAdministrador'],
            ['description' => 'Super Administrador del aplicativo, solo uso para sistemas']
        );
    }
}
