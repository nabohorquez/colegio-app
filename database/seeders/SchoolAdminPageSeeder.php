<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Page;
use App\Models\Role;

class SchoolAdminPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener la página padre "Administración de Colegio" que ya fue creada por la migración
        // También intentar encontrar variaciones del nombre
        $schoolAdminPage = Page::where('route', 'school.admin')
            ->where('id_father_page', null)
            ->first();
        
        // Si no existe, crearla
        if (!$schoolAdminPage) {
            $schoolAdminPage = Page::firstOrCreate(
                ['route' => 'school.admin', 'id_father_page' => null],
                [
                    'page_name' => 'Administración de Colegio',
                    'id_page_type' => 1,
                    'description' => 'Página principal de administración del colegio',
                ]
            );
        }

        // Asignar permisos a SuperAdministrador
        $superAdminRole = Role::where('rol_name', 'SuperAdministrador')->first();
        $firstUser = \App\Models\User::first();

        if ($superAdminRole && $firstUser) {
            \App\Models\RoleByUser::firstOrCreate(
                ['id_role' => $superAdminRole->id, 'id_user' => $firstUser->id]
            );

            $permissionIds = \App\Models\Permission::pluck('id');
            foreach ($permissionIds as $permissionId) {
                \App\Models\RoleByPage::firstOrCreate([
                    'id_role' => $superAdminRole->id,
                    'id_page' => $schoolAdminPage->id,
                    'id_permission' => $permissionId,
                ]);
            }
            // Limpiar la caché del menú para el primer usuario (si existe)
            try {
                if ($firstUser) {
                    \Illuminate\Support\Facades\Cache::forget('menu_modules_' . $firstUser->id);
                }
            } catch (\Throwable $e) {
                // En entornos donde Cache no esté disponible, no interrumpir el seeder
            }
        }
    }
}
