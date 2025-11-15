<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PermissionSuperAdmin extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superAdminRole = \App\Models\Role::where('rol_name', 'SuperAdministrador')->first();
        $firstUser = \App\Models\User::first();

        if ($superAdminRole && $firstUser) {
            \App\Models\RoleByUser::firstOrCreate(
                ['id_role' => $superAdminRole->id, 'id_user' => $firstUser->id]
            );

            $pages = \App\Models\Page::all();
            $permissionIds = \App\Models\Permission::pluck('id');
            /** @var \App\Models\Page $pageItem */
            foreach ($pages as $pageItem) {
                foreach ($permissionIds as $permissionId) {
                    \App\Models\RoleByPage::firstOrCreate([
                        'id_role' => $superAdminRole->id,
                        'id_page' => $pageItem->id,
                        'id_permission' => $permissionId,
                    ]);
                }
            }
        }
    }
}
