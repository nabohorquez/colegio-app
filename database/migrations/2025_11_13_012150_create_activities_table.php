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
        Schema::create('activities', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->string('title');
            $table->text('description')->nullable();

            // Relaciones con Estudiante y Materia
            $table->integer('student_id')->nullable();
            $table->foreign('student_id')->references('id')->on('students')->onDelete('set null');
            $table->string('subject')->nullable();

            $table->integer('created_by');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');

            $table->index('student_id');
            $table->index('subject');
            $table->timestamps();
            $table->softDeletes(); // Para el borrado lógico
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('activities', function (Blueprint $table) {
            $table->dropForeign(['created_by', 'student_id']);
        });
        Schema::dropIfExists('activities');
    }
};
