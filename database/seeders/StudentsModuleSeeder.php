<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Page;
use App\Models\PageType;
use App\Models\Role;
use App\Models\RoleByPage;
use App\Models\Permission;
use Illuminate\Support\Facades\DB;

class StudentsModuleSeeder extends Seeder
{
    public function run()
    {
        try {
            DB::beginTransaction();

            // Buscar el módulo de Usuarios
            $usersModule = Page::where('page_name', 'Usuarios')->first();
            if (!$usersModule) {
                throw new \Exception('El módulo de Usuarios no existe');
            }

            // Verificar si la página ya existe
            $existingPage = Page::where('page_name', 'Estudiantes')->first();
            if ($existingPage) {
                // Si la página existe, eliminar sus permisos existentes
                RoleByPage::where('id_page', $existingPage->id)->delete();
                $studentsModule = $existingPage;
                
                // Actualizar la página para que sea subpágina de Usuarios
                $studentsModule->id_father_page = $usersModule->id;
                $studentsModule->save();
            } else {
                // Crear la página como subpágina del módulo de usuarios
                $pageType = PageType::where('type_name', 'Página')->first();
                $studentsModule = Page::create([
                    'page_name' => 'Estudiantes',
                    'route' => 'students.index',
                    'description' => 'Gestión de estudiantes',
                    'id_page_type' => $pageType->id,
                    'id_father_page' => $usersModule->id
                ]);
            }

            // Obtener el rol de SuperAdmin
            $superAdminRole = Role::where('rol_name', 'SuperAdministrador')->first();

            // Obtener todos los permisos disponibles
            $permissions = Permission::all();

            // Asignar todos los permisos al SuperAdmin para el módulo de estudiantes
            foreach ($permissions as $permission) {
                RoleByPage::create([
                    'id_role' => $superAdminRole->id,
                    'id_page' => $studentsModule->id,
                    'id_permission' => $permission->id
                ]);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}