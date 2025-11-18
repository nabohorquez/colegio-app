<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentSubjectTable extends Migration
{
    public function up(): void
    {
        Schema::create('student_subject', function (Blueprint $table) {
            $table->id();
            
            $table->integer('estudiante_id');
            $table->unsignedBigInteger('materia_id');

            $table->timestamps();

            $table->unique(['estudiante_id', 'materia_id']);
        });

        Schema::table('student_subject', function (Blueprint $table) {
            $table->foreign('estudiante_id')
                ->references('id')->on('students')
                ->cascadeOnDelete();
            $table->foreign('materia_id')
                ->references('id')->on('subjects')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_subject');
    }
}
