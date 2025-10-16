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
        $user = new User();
        $user->name = 'Superadmin';
        $user->email = 'email@email.com';
        $user->password = bcrypt('@Superadmin123');

        $user->save();
    }
}
