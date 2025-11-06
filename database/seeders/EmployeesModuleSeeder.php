<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmployeesModuleSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Crear módulo "Usuarios" si no existe
        $moduleId = DB::table('pages')->where('page_name', 'Usuarios')->value('id');

        if (!$moduleId) {
            $moduleId = DB::table('pages')->insertGetId([
                'id_page_type'   => 1,   // 1 = Módulo
                'page_name'      => 'Usuarios',
                'description'    => 'Gestión de usuarios del sistema',
                'route'          => null,
                'id_father_page' => null,
                'created_at'     => now(),
                'updated_at'     => now(),
            ]);
        }

        // 2. Crear página "Empleados" dentro del módulo "Usuarios"
        $pageId = DB::table('pages')->where('route', 'employees.index')->value('id');

        if (!$pageId) {
            $pageId = DB::table('pages')->insertGetId([
                'id_page_type'   => 2,   // 2 = Página
                'page_name'      => 'Empleados',
                'description'    => 'CRUD de empleados del colegio',
                'route'          => 'employees.index',
                'id_father_page' => $moduleId,
                'created_at'     => now(),
                'updated_at'     => now(),
            ]);
        }

        // 3. Crear permisos si no existen
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

        // Obtener IDs de permisos recién creados o existentes
        $permissionIds = DB::table('permissions')
            ->whereIn('permission', $permissions)
            ->pluck('id')
            ->toArray();

        // 4. Obtener ID del rol SuperAdministrador
        $roleId = DB::table('roles')
            ->where('rol_name', 'SuperAdministrador')
            ->value('id');

        if (!$roleId) {
            $this->command->error("⚠️ No se encontró el rol 'SuperAdministrador'. Debes crearlo primero.");
            return;
        }

        // 5. Asignar permisos al rol en esta página (sin timestamps)
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

        $this->command->info("✅ Módulo 'Usuarios' y página 'Empleados' creados con permisos para SuperAdministrador.");
    }
}
