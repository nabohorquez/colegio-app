<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPermissionToRolesByPagesPrimary extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('roles_by_pages', function (Blueprint $table) {
            $table->dropForeign(['id_role']);
            $table->dropForeign(['id_pages']);
            $table->dropPrimary();
        });

        Schema::table('roles_by_pages', function (Blueprint $table) {
            $table->renameColumn('id_pages', 'id_page');
            $table->addColumn('integer', 'id_permission')->references('id')->on('permissions');
            $table->foreign('id_permission')->references('id')->on('permissions');
            $table->foreign('id_role')->references('id')->on('roles');
            $table->foreign('id_page')->references('id')->on('pages');
            $table->primary(['id_role', 'id_page', 'id_permission']);
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
            $table->dropForeign(['id_permission']);
            $table->dropForeign(['id_role']);
            $table->dropForeign(['id_page']);
            $table->dropPrimary();
        });

        Schema::table('roles_by_pages', function (Blueprint $table) {
            $table->renameColumn('id_page', 'id_pages');
            $table->dropColumn('id_permission');
            $table->foreign('id_role')->references('id')->on('roles');
            $table->foreign('id_pages')->references('id')->on('pages');
            $table->primary(['id_role', 'id_pages']);
        });
    }
}
