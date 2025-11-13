<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnrollmentTypesTable extends Migration
{
    public function up(): void
    {
        Schema::create('enrollment_types', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_tipo')->unique();
            $table->text('descripcion')->nullable();
            $table->boolean('estado')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('enrollment_types');
    }
}
