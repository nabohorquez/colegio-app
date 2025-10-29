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
            $permissions = \App\Models\Permission::all();
            foreach ($pages as $page) {
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
