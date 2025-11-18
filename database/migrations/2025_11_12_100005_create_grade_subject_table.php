<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGradeSubjectTable extends Migration
{
    public function up(): void
    {
        Schema::create('grade_subject', function (Blueprint $table) {
            $table->id();
            
            $table->unsignedBigInteger('grado_id');
            $table->foreign('grado_id')
                ->references('id')->on('grades')
                ->cascadeOnDelete();

            $table->unsignedBigInteger('materia_id');
            $table->foreign('materia_id')
                ->references('id')->on('subjects')
                ->cascadeOnDelete();

            $table->timestamps();

            $table->unique(['grado_id', 'materia_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('grade_subject');
    }
}
