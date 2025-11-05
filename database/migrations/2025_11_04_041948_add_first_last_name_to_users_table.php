<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('first_name', 100)->nullable()->after('id');
            $table->string('last_name', 100)->nullable()->after('first_name');
        });

        // --- AUTO-SEPARAR NOMBRE COMPLETO ---
        // Toma "name" y divide en primer palabra = first_name, resto = last_name
        DB::table('users')->select('id', 'name')->orderBy('id')->chunk(50, function ($users) {
            foreach ($users as $user) {
                $parts = explode(' ', trim($user->name));
                $firstName = array_shift($parts);
                $lastName = implode(' ', $parts);

                DB::table('users')->where('id', $user->id)->update([
                    'first_name' => $firstName ?: null,
                    'last_name'  => $lastName ?: null,
                ]);
            }
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['first_name', 'last_name']);
        });
    }
};
