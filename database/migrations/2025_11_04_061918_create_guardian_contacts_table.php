<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGuardianContactsTable extends Migration
{
    public function up()
    {
        Schema::create('guardian_contacts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guardian_id')->constrained('guardians')->onDelete('cascade');
            $table->enum('type', ['telefono', 'correo']);
            $table->string('value', 150);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('guardian_contacts');
    }
}
