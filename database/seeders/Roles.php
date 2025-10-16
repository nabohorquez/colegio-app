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
        $roles = new Role();
        $roles->rol_name = 'SuperAdministrador';
        $roles->description = 'Super Administrador del aplicativo, solo uso para sistemas';
        $roles->save();
    }
}
