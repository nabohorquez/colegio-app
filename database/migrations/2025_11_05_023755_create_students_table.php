<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->string('first_name');
            $table->string('last_name');
            $table->date('birth_date')->nullable();
            $table->string('document')->unique();
            $table->string('grade');
            $table->string('email_institutional')->unique()->nullable();
            $table->string('address')->nullable();

            // ✅ Relación con Acudiente (un estudiante tiene un acudiente)
            // guardians.id is created with $table->id() (unsignedBigInteger),
            // so use unsignedBigInteger here to match types and avoid FK errors.
            $table->unsignedBigInteger('guardian_id')->nullable();
            $table->foreign('guardian_id')
                ->references('id')->on('guardians')
                ->nullOnDelete(); // Si se elimina acudiente, el estudiante queda sin acudiente

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('students');
    }
}
