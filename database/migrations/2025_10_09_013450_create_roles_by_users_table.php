<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolesByUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles_by_users', function (Blueprint $table) {
            $table->integer('id_role')->references('id')->on('roles');
            $table->integer('id_user')->references('id')->on('users');
            $table->primary(['id_role', 'id_user']);
            $table->foreign('id_role')->references('id')->on('roles');
            $table->foreign('id_user')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('roles_by_users', function (Blueprint $table) {
            $table->dropForeign(['id_role']);
            $table->dropForeign(['id_user']);
        });
        Schema::dropIfExists('roles_by_users');
    }
}
