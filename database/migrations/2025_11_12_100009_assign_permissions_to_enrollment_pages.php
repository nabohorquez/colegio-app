<?php

use Illuminate\Database\Migrations\Migration;
use App\Models\Page;
use App\Models\Role;
use App\Models\Permission;
use App\Models\RoleByPage;

return new class extends Migration
{
    public function up()
    {
        // Obtener el rol de Administrador
        $adminRole = Role::where('rol_name', 'Administrador')->first();
        
        if (!$adminRole) {
            return;
        }

        // Obtener las páginas de Matrículas y Tipos de Matrículas
        $enrollmentPages = Page::whereIn('route', ['enrollments.index', 'enrollment-types.index'])->get();
        
        if ($enrollmentPages->isEmpty()) {
            return;
        }

        // Obtener todos los permisos
        $permissions = Permission::all();
        
        foreach ($enrollmentPages as $page) {
            /** @var Page $page */
            // Verificar si ya existen permisos para esta página y rol
            $existingPermissions = RoleByPage::where('id_role', $adminRole->id)
                ->where('id_page', $page->id)
                ->count();
            
            // Si no existen permisos, crearlos
            if ($existingPermissions === 0) {
                foreach ($permissions as $permission) {
                    /** @var Permission $permission */
                    RoleByPage::create([
                        'id_role' => $adminRole->id,
                        'id_page' => $page->id,
                        'id_permission' => $permission->id
                    ]);
                }
            }
        }
    }

    public function down()
    {
        // Obtener el rol de Administrador
        $adminRole = Role::where('rol_name', 'Administrador')->first();
        
        if (!$adminRole) {
            return;
        }

        // Obtener las páginas de Matrículas y Tipos de Matrículas
        $enrollmentPages = Page::whereIn('route', ['enrollments.index', 'enrollment-types.index'])->get();
        
        foreach ($enrollmentPages as $page) {
            RoleByPage::where('id_role', $adminRole->id)
                ->where('id_page', $page->id)
                ->delete();
        }
    }
};
