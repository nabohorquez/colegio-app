<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('student_grades')) {
            Schema::create('student_grades', function (Blueprint $table) {
                $table->id();
                $table->integer('student_id');
                $table->unsignedBigInteger('subject_id');
                $table->decimal('partial_1', 3, 1)->nullable()->comment('Nota del primer parcial (0-5)');
                $table->decimal('partial_2', 3, 1)->nullable()->comment('Nota del segundo parcial (0-5)');
                $table->decimal('final_grade', 3, 1)->nullable()->comment('Nota final (0-5)');
                $table->text('observations')->nullable()->comment('Observaciones del docente');
                $table->integer('created_by')->comment('Usuario que creó la calificación');
                $table->timestamps();
                $table->softDeletes();

                // Índices
                $table->index('student_id');
                $table->index('subject_id');
                $table->index('created_by');
                $table->index('created_at');

                // Claves foráneas
                $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
                $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade');
                $table->foreign('created_by')->references('id')->on('users')->onDelete('restrict');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_grades');
    }
};
