<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ContentsPageSeeder extends Seeder
{
    public function run()
    {
        // Agregar página de contenidos al menú de administración
            // Insertar página de Contenidos en el menú solo si no existe
            $existingPage = DB::table('pages')->where('route', 'contents')->first();
            if ($existingPage) {
                $pageId = $existingPage->id;
            } else {
                $pageId = DB::table('pages')->insertGetId([
                    'page_name' => 'Contenidos',
                    'description' => 'Gestión de contenidos académicos',
                    'route' => 'contents',
                    'id_page_type' => 1,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }

        // Verificar o crear el rol SuperAdministrador (id=1)
        $role = DB::table('roles')->where('id', 1)->first();
        if (!$role) {
            DB::table('roles')->insert([
                'id' => 1,
                'rol_name' => 'SuperAdministrador',
                'description' => 'Rol con todos los permisos',
            ]);
        }

        // Obtener el primer permiso disponible o crear uno si no existe
        $permission = DB::table('permissions')->first();
        if (!$permission) {
            $permissionId = DB::table('permissions')->insertGetId([
                'permission' => 'view_contents',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        } else {
            $permissionId = $permission->id;
        }
        DB::table('roles_by_pages')->insert([
            'id_role' => 1,
            'id_page' => $pageId,
            'id_permission' => $permissionId
        ]);
    }
}
