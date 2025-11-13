<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('enrollments', function (Blueprint $table) {
            // Agregar costo de matrícula para mejor lógica de negocio
            if (!Schema::hasColumn('enrollments', 'costo')) {
                $table->decimal('costo', 10, 2)->nullable()->after('forma_pago');
            }
            // Agregar estado de pago para rastrear si está pagado
            if (!Schema::hasColumn('enrollments', 'estado_pago')) {
                $table->enum('estado_pago', ['pendiente', 'parcial', 'pagado'])->default('pendiente')->after('costo');
            }
        });
    }

    public function down(): void
    {
        Schema::table('enrollments', function (Blueprint $table) {
            $table->dropColumn(['costo', 'estado_pago']);
        });
    }
};
