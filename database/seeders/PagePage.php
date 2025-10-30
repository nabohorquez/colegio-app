<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PagePage extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pageModel = new \App\Models\Page();
        $fatherPageName = 'Administración del Sistema';

        $fatherPage = $pageModel::where('page_name', $fatherPageName)->first();
        if ($fatherPage) {
            $pageCreated = $pageModel::create([
                'page_name' => 'Gestión de Paginas',
                'route' => 'pages.index',
                'id_page_type' => 2,
                'description' => 'Página para la gestión de paginas',
                'id_father_page' => $fatherPage->id,
            ]);


            $superAdminRole = \App\Models\Role::where('rol_name', 'SuperAdministrador')->first();
            $firstUser = \App\Models\User::first();

            if ($superAdminRole && $firstUser) {
                \App\Models\RoleByUser::firstOrCreate(
                    ['id_role' => $superAdminRole->id, 'id_user' => $firstUser->id]
                );

                $permissions = \App\Models\Permission::all();
                foreach ($permissions as $permission) {
                    \App\Models\RoleByPage::firstOrCreate([
                        'id_role' => $superAdminRole->id,
                        'id_page' => $pageCreated->id,
                        'id_permission' => $permission->id,
                    ]);
                }
            }
        }
    }
}
