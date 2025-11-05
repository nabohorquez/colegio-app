<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            // users.id is an integer (not bigInteger), so keep the same type for the FK
            $table->integer('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->enum('gender', ['F', 'M', 'X'])->nullable();
            $table->enum('marital_status', ['SOLTERO', 'CASADO', 'DIVORCIADO', 'UNIÓN LIBRE', 'VIUDO'])->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
}
