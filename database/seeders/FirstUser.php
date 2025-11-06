<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class FirstUser extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Make seeder idempotent: create the user if it doesn't exist
        User::firstOrCreate(
            ['email' => 'email@email.com'],
            [
                'name' => 'Superadmin',
                'username' => 'superadmin',
                'password' => bcrypt('@Superadmin123'),
            ]
        );
    }
}
