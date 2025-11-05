<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeContactsTable extends Migration
{
    public function up(): void
    {
        Schema::create('employee_contacts', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            // employees.id is an integer (not bigInteger), so match types
            $table->integer('employee_id');
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
            $table->enum('type', ['phone', 'email']);
            $table->string('value');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employee_contacts');
    }
}
