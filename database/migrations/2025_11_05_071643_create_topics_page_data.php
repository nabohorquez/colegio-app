<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // 1. Insertar el tipo de página si no existe
        $pageTypeId = DB::table('page_types')->where('type_name', 'Temas')->first()?->id;
        
        if (!$pageTypeId) {
            $pageTypeId = DB::table('page_types')->insertGetId([
                'type_name' => 'Temas',
                'description' => 'Gestión de temas académicos',
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        // 2. Insertar la página de temas
        $pageId = DB::table('pages')->insertGetId([
            'page_name' => 'Gestión de Temas',
            'description' => 'Administración de temas académicos',
            'route' => 'topics.index',

            'id_page_type' => $pageTypeId,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // 3. Asignar permisos a roles (asumiendo que el rol de administrador tiene ID 1)
        $adminRoleId = DB::table('roles')->where('rol_name', 'Administrador')->first()?->id;
        
        if ($adminRoleId) {
            // Obtener IDs de los permisos
            $permissions = DB::table('permissions')->get();
            
            foreach ($permissions as $permission) {
                DB::table('roles_by_pages')->insert([
                    'id_role' => $adminRoleId,
                    'id_page' => $pageId,
                    'id_permission' => $permission->id
                ]);
            }
        }
    }

    public function down()
    {
        // Obtener el ID de la página de temas
        $page = DB::table('pages')->where('route', 'topics.index')->first();
        
        if ($page) {
            // Eliminar los permisos de roles relacionados
            DB::table('roles_by_pages')->where('id_page', $page->id)->delete();
            
            // Eliminar la página
            DB::table('pages')->where('id', $page->id)->delete();
        }

        // Eliminar el tipo de página si no tiene otras páginas asociadas
        $pageType = DB::table('page_types')->where('type_name', 'Temas')->first();
        if ($pageType) {
            $hasPages = DB::table('pages')->where('id_page_type', $pageType->id)->exists();
            if (!$hasPages) {
                DB::table('page_types')->where('id', $pageType->id)->delete();
            }
        }
    }
};
