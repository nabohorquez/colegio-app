<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PagePage extends Seeder
{
    public function run(): void
    {
        $pageModel = new \App\Models\Page();
        $fatherPageName = 'Administración del Sistema';

        $fatherPage = $pageModel::where('page_name', $fatherPageName)->first();

        if ($fatherPage) {
            // Página: Gestión de Páginas
            $pageCreated = $pageModel::firstOrCreate([
                'page_name' => 'Gestión de Paginas',
                'route' => 'pages.index',
                'id_page_type' => 2,
                'description' => 'Página para la gestión de páginas',
                'id_father_page' => $fatherPage->id,
            ]);

            // Tipos de Matrícula
            $enrollmentPage = $pageModel::firstOrCreate([
                'page_name' => 'Tipos de Matrícula',
                'route' => 'enrollment-types.index',
                'id_page_type' => 2,
                'description' => 'Página para gestionar los tipos de matrícula',
                'id_father_page' => $fatherPage->id,
            ]);

            // Asignar permisos al SuperAdministrador
            $superAdminRole = \App\Models\Role::where('rol_name', 'SuperAdministrador')->first();
            $firstUser = \App\Models\User::first();

            if ($superAdminRole && $firstUser) {
                \App\Models\RoleByUser::firstOrCreate([
                    'id_role' => $superAdminRole->id,
                    'id_user' => $firstUser->id
                ]);

                $permissions = \App\Models\Permission::all();

                //permisos a ambas páginas
                foreach ([$pageCreated, $enrollmentPage] as $page) {
                    foreach ($permissions as $permission) {
                        \App\Models\RoleByPage::firstOrCreate([
                            'id_role' => $superAdminRole->id,
                            'id_page' => $page->id,
                            'id_permission' => $permission->id,
                        ]);
                    }
                }
            }
        }
    }
}
