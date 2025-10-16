<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RolesByPages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles_by_pages', function (Blueprint $table) {
            $table->integer('id_role')->references('id')->on('roles');
            $table->integer('id_pages')->references('id')->on('pages');
            $table->primary(['id_role', 'id_pages']);
            $table->foreign('id_role')->references('id')->on('roles');
            $table->foreign('id_pages')->references('id')->on('pages');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('roles_by_pages', function (Blueprint $table) {
            $table->dropForeign(['id_role']);
            $table->dropForeign(['id_pages']);
        });
        Schema::dropIfExists('roles_by_pages');
    }
}
