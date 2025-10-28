<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FixPageTypesColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // remove foreign key referencing page_types so we can modify the table
        Schema::table('pages', function (Blueprint $table) {
            $table->dropForeign(['id_page_type']);
        });

        // drop the incorrectly-typed columns
        Schema::table('page_types', function (Blueprint $table) {
            if (Schema::hasColumn('page_types', 'type_name')) {
                $table->dropColumn('type_name');
            }
            if (Schema::hasColumn('page_types', 'description')) {
                $table->dropColumn('description');
            }
        });

        // add columns with the correct string types
        Schema::table('page_types', function (Blueprint $table) {
            $table->string('type_name')->unique();
            $table->string('description')->nullable();
        });

        // re-add foreign key on pages.id_page_type
        Schema::table('pages', function (Blueprint $table) {
            $table->foreign('id_page_type')->references('id')->on('page_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->dropForeign(['id_page_type']);
        });

        Schema::table('page_types', function (Blueprint $table) {
            // remove string columns
            if (Schema::hasColumn('page_types', 'type_name')) {
                $table->dropColumn('type_name');
            }
            if (Schema::hasColumn('page_types', 'description')) {
                $table->dropColumn('description');
            }
            // restore original (incorrect) integer columns to match original migration
            $table->integer('type_name')->unique();
            $table->integer('description')->nullable();
        });

        Schema::table('pages', function (Blueprint $table) {
            $table->foreign('id_page_type')->references('id')->on('page_types');
        });
    }
}
