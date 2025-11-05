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
            // Drop foreign keys if they exist
            $foreignKeys = Schema::getConnection()->getDoctrineSchemaManager()->listTableForeignKeys('roles_by_pages');
            foreach ($foreignKeys as $foreignKey) {
                if ($foreignKey->getLocalColumns() === ['id_role'] || $foreignKey->getLocalColumns() === ['id_pages']) {
                    $table->dropForeign($foreignKey->getName());
                }
            }
            $table->dropPrimary();
        });

        Schema::table('roles_by_pages', function (Blueprint $table) {
            $table->renameColumn('id_pages', 'id_page');
            // id_permission was already added in previous migration
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
            // Drop foreign keys if they exist
            $foreignKeys = Schema::getConnection()->getDoctrineSchemaManager()->listTableForeignKeys('roles_by_pages');
            foreach ($foreignKeys as $foreignKey) {
                if ($foreignKey->getLocalColumns() === ['id_permission'] || 
                    $foreignKey->getLocalColumns() === ['id_role'] || 
                    $foreignKey->getLocalColumns() === ['id_page']) {
                    $table->dropForeign($foreignKey->getName());
                }
            }
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
