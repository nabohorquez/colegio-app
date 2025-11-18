<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeSubjectTable extends Migration
{
    public function up(): void
    {
        Schema::create('employee_subject', function (Blueprint $table) {
            $table->id();
            
            $table->integer('employee_id');
            $table->unsignedBigInteger('materia_id');

            $table->timestamps();

            $table->unique(['employee_id', 'materia_id']);
        });

        Schema::table('employee_subject', function (Blueprint $table) {
            $table->foreign('employee_id')
                ->references('id')->on('employees')
                ->cascadeOnDelete();
            $table->foreign('materia_id')
                ->references('id')->on('subjects')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employee_subject');
    }
}
