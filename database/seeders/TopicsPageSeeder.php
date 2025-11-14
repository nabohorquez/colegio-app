<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Page;

class TopicsPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pageModel = new Page();
        $fatherPageName = 'Administración del Colegio';

        $fatherPage = $pageModel::where('page_name', $fatherPageName)->first();
        if ($fatherPage) {
            $pageCreated = $pageModel::create([
                'page_name' => 'Gestión de Temas',
                'route' => 'school.topics.index',
                'id_page_type' => 2,
                'description' => 'Gestión de temas académicos del colegio',
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
