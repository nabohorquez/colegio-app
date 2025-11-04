<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnrollmentTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Crear tabla para tipos de matrícula
        Schema::create('enrollment_types', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // nombre del tipo (ej. "Regular", "Scholarship")
            $table->string('code')->nullable()->unique(); // código corto opcional (ej. "REG", "SCH")
            $table->text('description')->nullable(); // descripción del tipo
            $table->decimal('fee', 10, 2)->default(0); // valor de la matrícula
            $table->boolean('is_active')->default(true); // si está activo para selección
            $table->timestamps();
            $table->softDeletes(); // opcional: permite "eliminar" sin borrar
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('enrollment_types');
    }
}
