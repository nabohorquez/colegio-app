<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGuardiansTable extends Migration
{
    public function up()
    {
        Schema::create('guardians', function (Blueprint $table) {
            $table->id();
            $table->string('first_name', 120);
            $table->string('second_name', 120)->nullable();
            $table->string('last_name', 120);
            $table->string('second_last_name', 120)->nullable();
            $table->string('email', 150)->unique();
            $table->enum('gender', ['F', 'M', 'X'])->nullable();
            $table->enum('marital_status', ['SOLTERO', 'CASADO', 'DIVORCIADO', 'UNION LIBRE', 'VIUDO'])->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('guardians');
    }
}
