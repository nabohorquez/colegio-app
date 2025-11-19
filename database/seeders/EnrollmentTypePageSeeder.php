<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Page;
use App\Models\Role;

class EnrollmentTypePageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pageModel = new Page();
        
        // Buscar la página padre por ruta (es más confiable que por nombre)
        $fatherPage = $pageModel::where('route', 'school.admin')
            ->where('id_father_page', null)
            ->first();
        
        if ($fatherPage) {
            // Create or get the 'Tipos de Matrícula' page under the school admin father page
            $pageCreated = $pageModel::firstOrCreate(
                ['route' => 'enrollment-types.index'],
                [
                    'page_name' => 'Tipos de Matrícula',
                    'id_page_type' => 2,
                    'description' => 'Gestión de tipos de matrícula del colegio',
                    'id_father_page' => $fatherPage->id,
                ]
            );

            $superAdminRole = Role::where('rol_name', 'SuperAdministrador')->first();
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
