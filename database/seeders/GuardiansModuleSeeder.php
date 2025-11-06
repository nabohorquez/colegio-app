<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GuardiansModuleSeeder extends Seeder
{
    public function run(): void
    {

        // 1. Obtener o crear módulo "Usuarios"
        $moduleId = DB::table('pages')->where('page_name', 'Usuarios')->value('id');

        if (!$moduleId) {
            $moduleId = DB::table('pages')->insertGetId([
                'id_page_type'   => 1, // Módulo
                'page_name'      => 'Usuarios',
                'description'    => 'Gestión de personas dentro del sistema',
                'route'          => null,
                'id_father_page' => null,
                'created_at'     => now(),
                'updated_at'     => now(),
            ]);
        }

        // 2. Crear página "Acudientes" dentro del módulo
        $pageId = DB::table('pages')->where('route', 'guardians.index')->value('id');

        if (!$pageId) {
            $pageId = DB::table('pages')->insertGetId([
                'id_page_type'   => 2, // Página
                'page_name'      => 'Acudientes',
                'description'    => 'CRUD de acudientes',
                'route'          => 'guardians.index',
                'id_father_page' => $moduleId,
                'created_at'     => now(),
                'updated_at'     => now(),
            ]);
        }

        // 3. Crear permisos base si no existen
        $permissions = ['create', 'edit', 'delete'];

        foreach ($permissions as $perm) {
            if (!DB::table('permissions')->where('permission', $perm)->exists()) {
                DB::table('permissions')->insert([
                    'permission' => $perm,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        $permissionIds = DB::table('permissions')
            ->whereIn('permission', $permissions)
            ->pluck('id')
            ->toArray();

        // 4. Obtener ID de SuperAdministrador
        $roleId = DB::table('roles')->where('rol_name', 'SuperAdministrador')->value('id');

        if (!$roleId) {
            $this->command->error("⚠️ No existe el rol SuperAdministrador. Debes crearlo primero.");
            return;
        }

        // 5. Asignar permisos a la página para el rol SuperAdministrador
foreach ($permissionIds as $permId) {
    if (!DB::table('roles_by_pages')->where([
        'id_role'       => $roleId,
        'id_page'       => $pageId,
        'id_permission' => $permId,
    ])->exists()) {

        DB::table('roles_by_pages')->insert([
            'id_role'       => $roleId,
            'id_page'       => $pageId,
            'id_permission' => $permId,
        ]);
    }
}

        $this->command->info("✅ Módulo 'Usuarios' y página 'Acudientes' creados con permisos para SuperAdministrador.");
    }
}
