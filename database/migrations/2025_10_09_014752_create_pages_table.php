<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->integer('id_page_type')->references('id')->on('page_types');
            $table->integer('id_father_page')->references('id')->on('pages')->nullable();
            $table->string('page_name', 50);
            $table->string('description', 100)->nullable();
            $table->string('route', 20)->unique()->nullable();
            $table->timestamps();
            $table->foreign('id_page_type')->references('id')->on('page_types');
            $table->foreign('id_father_page')->references('id')->on('pages');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pages');
    }
}
