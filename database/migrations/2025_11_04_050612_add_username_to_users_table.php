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
            // ✅ Agregar columna username (sin UNIQUE aún para evitar doble creación)
            $table->string('username', 100)->after('email')->nullable();
        });

        // ✅ Autollenar username para registros antiguos
        DB::table('users')->select('id')->orderBy('id')->chunk(50, function ($users) {
            foreach ($users as $user) {
                DB::table('users')
                    ->where('id', $user->id)
                    ->update([
                        // Si ya tenía username, no se afecta
                        'username' => DB::raw("COALESCE(username, CONCAT('user', id))")
                    ]);
            }
        });

        // ✅ Asegurar que nadie queda en NULL
        DB::statement("UPDATE users SET username = CONCAT('user', id) WHERE username IS NULL");

        // NOTA: dejamos `username` como nullable durante las migraciones y seeders
        // para evitar errores cuando seeders (o código antiguo) insertan usuarios
        // sin username. Si prefieres forzar NOT NULL y UNIQUE, ejecuta un
        // migration separado después de importar/seedear y asegurarte de que
        // todos los registros tienen `username` único.
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('username');
        });
    }
};
