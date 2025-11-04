<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddPermissionToRolesByPagesPrimary extends Migration
{
    public function up()
    {
        $db = env('DB_DATABASE');

        // 1) DROP foreign keys if they exist (safe)
        try {
            // Drop FK by column names if they exist
            if ($this->fkExists('roles_by_pages', 'roles_by_pages_id_role_foreign')) {
                Schema::table('roles_by_pages', function (Blueprint $table) {
                    $table->dropForeign('roles_by_pages_id_role_foreign');
                });
            }
        } catch (\Throwable $e) {
            // ignore
        }

        try {
            if ($this->fkExists('roles_by_pages', 'roles_by_pages_id_pages_foreign')) {
                Schema::table('roles_by_pages', function (Blueprint $table) {
                    $table->dropForeign('roles_by_pages_id_pages_foreign');
                });
            }
        } catch (\Throwable $e) {
            // ignore
        }

        // 2) Drop primary if exists (wrap in try/catch)
        try {
            Schema::table('roles_by_pages', function (Blueprint $table) {
                // dropPrimary may throw if no primary exists
                $table->dropPrimary();
            });
        } catch (\Throwable $e) {
            // ignore
        }

        // 3) Rename column id_pages -> id_page if needed
        if (Schema::hasColumn('roles_by_pages', 'id_pages') && ! Schema::hasColumn('roles_by_pages', 'id_page')) {
            try {
                Schema::table('roles_by_pages', function (Blueprint $table) {
                    $table->renameColumn('id_pages', 'id_page');
                });
            } catch (\Throwable $e) {
                // If rename fails (no doctrine/dbal), try a fallback: create new column and copy (advanced)
                // For simplicity we ignore failure here; you may need composer require doctrine/dbal
            }
        }

        // 4) Add id_permission column if not exists
        if (! Schema::hasColumn('roles_by_pages', 'id_permission')) {
            Schema::table('roles_by_pages', function (Blueprint $table) {
                // add the column; adjust ->nullable() if desired
                $table->integer('id_permission')->unsigned()->after('id_page');
            });
        }

        // 5) Add foreign keys only if referenced tables/columns exist
        // permission FK
        if (Schema::hasTable('permissions') && Schema::hasColumn('roles_by_pages', 'id_permission')) {
            try {
                // create FK with explicit name to keep control
                DB::statement("
                    ALTER TABLE `roles_by_pages`
                    ADD CONSTRAINT `roles_by_pages_id_permission_foreign`
                    FOREIGN KEY (`id_permission`) REFERENCES `permissions`(`id`)
                    ON DELETE CASCADE
                ");
            } catch (\Throwable $e) {
                // ignore if already exists or cannot create
            }
        }

        // role FK
        if (Schema::hasTable('roles') && Schema::hasColumn('roles_by_pages', 'id_role')) {
            try {
                DB::statement("
                    ALTER TABLE `roles_by_pages`
                    ADD CONSTRAINT `roles_by_pages_id_role_foreign`
                    FOREIGN KEY (`id_role`) REFERENCES `roles`(`id`)
                    ON DELETE CASCADE
                ");
            } catch (\Throwable $e) {
                // ignore
            }
        }

        // page FK (note column name may be id_page now)
        $pageCol = Schema::hasColumn('roles_by_pages', 'id_page') ? 'id_page' : (Schema::hasColumn('roles_by_pages', 'id_pages') ? 'id_pages' : null);
        if ($pageCol && Schema::hasTable('pages')) {
            try {
                DB::statement("
                    ALTER TABLE `roles_by_pages`
                    ADD CONSTRAINT `roles_by_pages_id_page_foreign`
                    FOREIGN KEY (`{$pageCol}`) REFERENCES `pages`(`id`)
                    ON DELETE CASCADE
                ");
            } catch (\Throwable $e) {
                // ignore
            }
        }

        // 6) Add composite primary key if not exists
        // NOTE: adding a primary key to an existing table requires that columns are NOT nullable and no duplicates exist.
        // We add it only if there's no primary key defined.
        $hasPrimary = DB::selectOne("
            SELECT COUNT(*) AS cnt
            FROM information_schema.TABLE_CONSTRAINTS
            WHERE TABLE_SCHEMA = ?
              AND TABLE_NAME = 'roles_by_pages'
              AND CONSTRAINT_TYPE = 'PRIMARY KEY'
        ", [$db]);

        if ($hasPrimary && $hasPrimary->cnt == 0) {
            try {
                // Use raw statement to set composite PK
                DB::statement("ALTER TABLE `roles_by_pages` ADD PRIMARY KEY (`id_role`, `id_page`, `id_permission`)");
            } catch (\Throwable $e) {
                // ignore if fails (e.g., duplicates)
            }
        }
    }

    public function down()
    {
        // Remove primary if exists
        try {
            Schema::table('roles_by_pages', function (Blueprint $table) {
                $table->dropPrimary();
            });
        } catch (\Throwable $e) {
            // ignore
        }

        // Drop FKs if they exist (permission, role, page)
        foreach ([
            'roles_by_pages_id_permission_foreign',
            'roles_by_pages_id_role_foreign',
            'roles_by_pages_id_page_foreign',
            'roles_by_pages_id_pages_foreign'
        ] as $fkName) {
            try {
                if ($this->fkExists('roles_by_pages', $fkName)) {
                    Schema::table('roles_by_pages', function (Blueprint $table) use ($fkName) {
                        $table->dropForeign($fkName);
                    });
                }
            } catch (\Throwable $e) {
                // ignore
            }
        }

        // Drop column id_permission if exists
        if (Schema::hasColumn('roles_by_pages', 'id_permission')) {
            Schema::table('roles_by_pages', function (Blueprint $table) {
                $table->dropColumn('id_permission');
            });
        }

        // Rename back id_page -> id_pages if needed
        if (Schema::hasColumn('roles_by_pages', 'id_page') && ! Schema::hasColumn('roles_by_pages', 'id_pages')) {
            try {
                Schema::table('roles_by_pages', function (Blueprint $table) {
                    $table->renameColumn('id_page', 'id_pages');
                });
            } catch (\Throwable $e) {
                // ignore
            }
        }

        // Recreate previous FKs (role, pages) and primary if desired:
        // Only add if referenced tables/columns exist
        if (Schema::hasTable('roles') && Schema::hasColumn('roles_by_pages', 'id_role')) {
            try {
                DB::statement("
                    ALTER TABLE `roles_by_pages`
                    ADD CONSTRAINT `roles_by_pages_id_role_foreign`
                    FOREIGN KEY (`id_role`) REFERENCES `roles`(`id`)
                    ON DELETE CASCADE
                ");
            } catch (\Throwable $e) {}
        }

        if (Schema::hasTable('pages') && Schema::hasColumn('roles_by_pages', 'id_pages')) {
            try {
                DB::statement("
                    ALTER TABLE `roles_by_pages`
                    ADD CONSTRAINT `roles_by_pages_id_pages_foreign`
                    FOREIGN KEY (`id_pages`) REFERENCES `pages`(`id`)
                    ON DELETE CASCADE
                ");
            } catch (\Throwable $e) {}
        }

        // Recreate old primary if columns exist
        if (Schema::hasColumn('roles_by_pages', 'id_role') && Schema::hasColumn('roles_by_pages', 'id_pages')) {
            try {
                DB::statement("ALTER TABLE `roles_by_pages` ADD PRIMARY KEY (`id_role`, `id_pages`)");
            } catch (\Throwable $e) {}
        }
    }

    /**
     * Helper to check if a FK constraint exists on given table.
     */
    protected function fkExists(string $table, string $constraintName): bool
    {
        $db = env('DB_DATABASE');
        $res = DB::selectOne("
            SELECT CONSTRAINT_NAME
            FROM information_schema.KEY_COLUMN_USAGE
            WHERE TABLE_SCHEMA = ?
              AND TABLE_NAME = ?
              AND CONSTRAINT_NAME = ?
        ", [$db, $table, $constraintName]);

        return (bool) $res;
    }
}
