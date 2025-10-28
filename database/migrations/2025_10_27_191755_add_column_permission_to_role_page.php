<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('roles_by_pages', function (Blueprint $table) {
            $table->integer('id_permission')->references('id')->on('permissions');
            $table->foreign('id_permission')->references('id')->on('permissions');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('roles_by_pages', function (Blueprint $table) {
            $table->dropForeign(['id_permission']);
            $table->dropColumn('id_permission');
        });
    }
};
