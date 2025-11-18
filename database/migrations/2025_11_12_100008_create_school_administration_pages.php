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
        // 1. Obtener o crear el tipo de página para submódulos
        $submoduleType = PageType::firstOrCreate(
            ['type_name' => 'Submódulo'],
            ['description' => 'Submódulos de administración']
        );

        // 2. Obtener o crear el módulo padre "Administración de Colegio"
        $adminModule = Page::firstOrCreate(
            ['page_name' => 'Administración de Colegio'],
            [
                'description' => 'Módulo de administración del colegio',
                'route' => 'school.admin',
                'id_page_type' => PageType::where('type_name', 'Administración')->first()?->id ?? 1,
                'id_father_page' => null
            ]
        );

        // 3. Crear submódulos de Matrículas
        $enrollmentModule = Page::firstOrCreate(
            ['page_name' => 'Matrículas', 'id_father_page' => $adminModule->id],
            [
                'description' => 'Gestión de matrículas escolares',
                'route' => null,
                'id_page_type' => $submoduleType->id,
                'id_father_page' => $adminModule->id
            ]
        );

        $enrollmentTypePageData = [
            'page_name' => 'Tipos de Matrículas',
            'description' => 'Gestión de tipos de matrícula',
            'route' => 'enrollment-types.index',
            'id_page_type' => $submoduleType->id,
            'id_father_page' => $enrollmentModule->id
        ];
        $enrollmentTypePage = Page::firstOrCreate(
            ['page_name' => 'Tipos de Matrículas', 'id_father_page' => $enrollmentModule->id],
            $enrollmentTypePageData
        );

        $enrollmentPageData = [
            'page_name' => 'Matrículas',
            'description' => 'Gestión de matrículas de estudiantes',
            'route' => 'enrollments.index',
            'id_page_type' => $submoduleType->id,
            'id_father_page' => $enrollmentModule->id
        ];
        $enrollmentPage = Page::firstOrCreate(
            ['page_name' => 'Matrículas', 'id_father_page' => $enrollmentModule->id],
            $enrollmentPageData
        );

        // 4. Crear submódulo Grados
        $gradePage = Page::firstOrCreate(
            ['page_name' => 'Grados', 'id_father_page' => $adminModule->id],
            [
                'description' => 'Gestión de grados escolares',
                'route' => 'grades.index',
                'id_page_type' => $submoduleType->id,
                'id_father_page' => $adminModule->id
            ]
        );

        // 5. Crear submódulo Materias
        $subjectPage = Page::firstOrCreate(
            ['page_name' => 'Materias', 'id_father_page' => $adminModule->id],
            [
                'description' => 'Gestión de materias académicas',
                'route' => 'subjects.index',
                'id_page_type' => $submoduleType->id,
                'id_father_page' => $adminModule->id
            ]
        );

        // 6. Obtener todas las páginas creadas/actualizadas
        $pages = [
            $enrollmentTypePage,
            $enrollmentPage,
            $gradePage,
            $subjectPage
        ];

        // 7. Asignar permisos CRUD a todas las páginas para el rol Administrador
        $adminRole = Role::where('rol_name', 'Administrador')->first();
        
        if ($adminRole) {
            $permissions = Permission::all();
            
            foreach ($pages as $page) {
                /** @var Page $page */
                // Eliminar permisos previos si existen
                RoleByPage::where('id_role', $adminRole->id)
                    ->where('id_page', $page->id)
                    ->delete();
                
                // Asignar todos los permisos
                foreach ($permissions as $permission) {
                    /** @var Permission $permission */
                    RoleByPage::create([
                        'id_role' => $adminRole->id,
                        'id_page' => $page->id,
                        'id_permission' => $permission->id
                    ]);
                }
            }
        }
    }

    public function down()
    {
        // Eliminar las páginas creadas
        $pagesToDelete = [
            'Tipos de Matrículas',
            'Matrículas',
            'Grados',
            'Materias'
        ];

        foreach ($pagesToDelete as $pageName) {
            $page = Page::where('page_name', $pageName)->first();
            if ($page) {
                RoleByPage::where('id_page', $page->id)->delete();
                $page->delete();
            }
        }

        // Eliminar el submódulo Matrículas
        $enrollmentModule = Page::where('page_name', 'Matrículas')
            ->whereNotNull('id_father_page')
            ->first();
        if ($enrollmentModule) {
            RoleByPage::where('id_page', $enrollmentModule->id)->delete();
            $enrollmentModule->delete();
        }
    }
};
