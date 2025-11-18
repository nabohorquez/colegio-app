<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnrollmentsTable extends Migration
{
    public function up(): void
    {
        Schema::create('enrollments', function (Blueprint $table) {
            $table->id();
            
            $table->integer('estudiante_id');
            $table->unsignedBigInteger('grado_id');
            $table->unsignedBigInteger('tipo_matricula_id');

            $table->string('forma_pago')->default('mensual');
            $table->date('fecha');
            $table->boolean('estado')->default(true);
            
            $table->timestamps();

            // Agregar claves foráneas
            $table->foreign('grado_id')
                ->references('id')->on('grades')
                ->cascadeOnDelete();
            $table->foreign('tipo_matricula_id')
                ->references('id')->on('enrollment_types')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('enrollments');
    }
}

