<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // Primero quitamos la restricción única
        Schema::table('pages', function (Blueprint $table) {
            $table->dropUnique('pages_route_unique');
        });

        // Luego modificamos el tamaño de la columna
        Schema::table('pages', function (Blueprint $table) {
            $table->string('route', 100)->nullable()->change();
        });

        // Finalmente volvemos a agregar la restricción única
        Schema::table('pages', function (Blueprint $table) {
            $table->unique('route');
        });
    }

    public function down(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->dropUnique('pages_route_unique');
            $table->string('route', 20)->nullable()->change();
            $table->unique('route');
        });
    }
};
