<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Optimizar tabla pages
        if (Schema::hasTable('pages')) {
            Schema::table('pages', function (Blueprint $table) {
                if (!$this->indexExists('pages', 'pages_id_father_page_index')) {
                    $table->index('id_father_page');
                }
                if (!$this->indexExists('pages', 'pages_route_index')) {
                    $table->index('route');
                }
                if (!$this->indexExists('pages', 'pages_page_name_index')) {
                    $table->index('page_name');
                }
            });
        }

        // Optimizar tabla users
        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                if (!$this->indexExists('users', 'users_email_index')) {
                    $table->index('email');
                }
            });
        }

        // Optimizar tabla role_by_pages
        if (Schema::hasTable('role_by_pages')) {
            Schema::table('role_by_pages', function (Blueprint $table) {
                if (!$this->indexExists('role_by_pages', 'role_by_pages_id_page_index')) {
                    $table->index('id_page');
                }
                if (!$this->indexExists('role_by_pages', 'role_by_pages_id_role_index')) {
                    $table->index('id_role');
                }
            });
        }

        // Optimizar tabla role_by_users
        if (Schema::hasTable('role_by_users')) {
            Schema::table('role_by_users', function (Blueprint $table) {
                if (!$this->indexExists('role_by_users', 'role_by_users_id_user_index')) {
                    $table->index('id_user');
                }
                if (!$this->indexExists('role_by_users', 'role_by_users_id_role_index')) {
                    $table->index('id_role');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }

    private function indexExists($table, $indexName)
    {
        $result = DB::selectOne("
            SELECT COUNT(*) as count
            FROM information_schema.STATISTICS
            WHERE TABLE_SCHEMA = DATABASE()
            AND TABLE_NAME = ?
            AND INDEX_NAME = ?
        ", [$table, $indexName]);

        return isset($result) && $result->count > 0;
    }
};

