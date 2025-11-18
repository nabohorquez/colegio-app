<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class GradesPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pageModel = new \App\Models\Page();
        $fatherPageName = 'Administración del Colegio';

        $fatherPage = $pageModel::where('page_name', $fatherPageName)->first();
        if ($fatherPage) {
            // Create or get the 'Calificaciones' page under the school admin father page
            $pageCreated = $pageModel::firstOrCreate(
                ['page_name' => 'Calificaciones'],
                [
                    'route' => 'school.grades.index',
                    'id_page_type' => 2,
                    'description' => 'Gestión de calificaciones de estudiantes',
                    'id_father_page' => $fatherPage->id,
                ]
            );

            $superAdminRole = \App\Models\Role::where('rol_name', 'SuperAdministrador')->first();
            $firstUser = \App\Models\User::first();

            if ($superAdminRole && $firstUser) {
                \App\Models\RoleByUser::firstOrCreate(
                    ['id_role' => $superAdminRole->id, 'id_user' => $firstUser->id]
                );

                // Assign all permissions available to SuperAdmin for this page
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
