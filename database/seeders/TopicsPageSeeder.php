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
            // Usar firstOrCreate para evitar duplicados si se corre el seeder varias veces
            $pageCreated = $pageModel::firstOrCreate(
                ['page_name' => 'Gestión de Temas'],
                [
                    'route' => 'school.topics.index',
                    'id_page_type' => 2,
                    'description' => 'Gestión de temas académicos del colegio',
                    'id_father_page' => $fatherPage->id,
                ]
            );

            $superAdminRole = \App\Models\Role::where('rol_name', 'SuperAdministrador')->first();
            $firstUser = \App\Models\User::first();

            if ($superAdminRole && $firstUser) {
                \App\Models\RoleByUser::firstOrCreate(
                    ['id_role' => $superAdminRole->id, 'id_user' => $firstUser->id]
                );

                $permissionIds = \App\Models\Permission::pluck('id');
                foreach ($permissionIds as $permissionId) {
                    \App\Models\RoleByPage::firstOrCreate([
                        'id_role' => $superAdminRole->id,
                        'id_page' => $pageCreated->id,
                        'id_permission' => $permissionId,
                    ]);
                }
            }
        }
    }
}
