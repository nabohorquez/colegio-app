<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ActivitiesPageSeeder extends Seeder
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
            // Usar firstOrCreate para hacer el seeder idempotente (evita duplicados en ejecuciones repetidas)
            $pageCreated = $pageModel::firstOrCreate(
                ['page_name' => 'Actividades'],
                [
                    'route' => 'school.activities.index',
                    'id_page_type' => 2,
                    'description' => 'Gestión de actividades escolares del colegio',
                    'id_father_page' => $fatherPage->id,
                ]
            );

            $superAdminRole = \App\Models\Role::where('rol_name', 'SuperAdministrador')->first();
            $firstUser = \App\Models\User::first();

            if ($superAdminRole && $firstUser) {
                \App\Models\RoleByUser::firstOrCreate(
                    ['id_role' => $superAdminRole->id, 'id_user' => $firstUser->id]
                );

                // Iterar sólo ids para evitar avisos de tipado en el analizador estático
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
