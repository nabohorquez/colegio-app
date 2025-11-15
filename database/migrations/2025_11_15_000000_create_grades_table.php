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
        // Ensure any partially created table is removed (safe for development)
        Schema::dropIfExists('grades');

        Schema::create('grades', function (Blueprint $table) {
            $table->id();

            // Use signed integer to match existing students.id (integer autoIncrement)
            $table->integer('student_id');
            $table->foreign('student_id')
                ->references('id')->on('students')
                ->onDelete('cascade');

            $table->string('subject');
            $table->string('academic_period')->comment('Ej: 2025-I, 2025-II');
            $table->decimal('first_partial', 5, 2)->nullable()->comment('Primera nota parcial (0-5)');
            $table->decimal('second_partial', 5, 2)->nullable()->comment('Segunda nota parcial (0-5)');
            $table->decimal('final_grade', 5, 2)->nullable()->comment('Nota final (0-5)');
            $table->text('notes')->nullable()->comment('Observaciones o comentarios');

            // Match users.id type (integer autoIncrement)
            $table->integer('created_by');
            $table->foreign('created_by')
                ->references('id')->on('users')
                ->onDelete('cascade');

            $table->timestamps();
            $table->softDeletes();

            // Indexes for performance
            $table->index('student_id');
            $table->index('academic_period');
            $table->index('subject');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grades');
    }
};
