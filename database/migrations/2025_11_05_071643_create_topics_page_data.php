<?php

use Illuminate\Database\Migrations\Migration;
use App\Models\Page;
use App\Models\PageType;
use App\Models\Role;
use App\Models\Permission;
use App\Models\RoleByPage;

return new class extends Migration
{
    public function up()
    {
        // 1. Obtener o crear el tipo de página
        $pageType = PageType::firstOrCreate(
            ['type_name' => 'Temas'],
            ['description' => 'Gestión de temas académicos']
        );

        // Obtener o crear la página padre (Administración de Colegio)
        $parentPage = Page::firstOrCreate(
            ['page_name' => 'Administración de Colegio'],
            [
                'description' => 'Módulo de administración del colegio',
                'route' => 'school.admin',
                'id_page_type' => PageType::where('type_name', 'Administración')->first()?->id ?? 1,
            ]
        );

        // 2. Crear la página de temas
        $page = Page::create([
            'page_name' => 'Gestión de Temas',
            'description' => 'Gestión de temas académicos del colegio',
            'route' => 'topics.index',
            'id_page_type' => $pageType->id,
            'id_father_page' => $parentPage->id,
        ]);

        // 3. Asignar permisos a roles
        $adminRole = Role::where('rol_name', 'Administrador')->first();
        
        if ($adminRole && $page) {
            $permissions = Permission::all();
            
            foreach ($permissions as $permission) {
                RoleByPage::create([
                    'id_role' => $adminRole->id,
                    'id_page' => $page->id,
                    'id_permission' => $permission->id
                ]);
            }
        }
    }

    public function down()
    {
        $page = Page::where('route', 'topics.index')->first();
        
        if ($page) {
            // Eliminar los permisos de roles relacionados
            RoleByPage::where('id_page', $page->id)->delete();
            
            // Eliminar la página
            $page->delete();
        }

        // Eliminar el tipo de página si no tiene otras páginas asociadas
        $pageType = PageType::where('type_name', 'Temas')->first();
        if ($pageType) {
            $hasPages = Page::where('id_page_type', $pageType->id)->exists();
            if (!$hasPages) {
                $pageType->delete();
            }
        }
    }
};
