<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Page;
use App\Models\Role;
use App\Models\Permission;
use App\Models\RoleByPage;

class ReorganizePagesStructure extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener roles
        $adminRole = Role::where('rol_name', 'Administrador')->first();
        $superAdminRole = Role::where('rol_name', 'SuperAdministrador')->first();
        
        // ============================================
        // 1. ADMINISTRACIÓN DE LA PÁGINA (Nuevo padre)
        // ============================================
        $adminPageParent = Page::firstOrCreate(
            ['page_name' => 'Administración de la Página'],
            [
                'route' => null,
                'id_page_type' => 1,
                'description' => 'Administración del sistema de páginas, roles y módulos',
                'id_father_page' => null,
            ]
        );

        // Obtener o actualizar páginas existentes de Roles, Módulos y Páginas
        $rolesPage = Page::where('route', 'roles.index')->first();
        if ($rolesPage) {
            $rolesPage->update(['id_father_page' => $adminPageParent->id]);
        } else {
            $rolesPage = Page::create([
                'page_name' => 'Roles',
                'route' => 'roles.index',
                'id_page_type' => 2,
                'description' => 'CRUD para administración de roles',
                'id_father_page' => $adminPageParent->id,
            ]);
        }

        $modulesPage = Page::where('route', 'modules.index')->first();
        if ($modulesPage) {
            $modulesPage->update(['id_father_page' => $adminPageParent->id]);
        } else {
            $modulesPage = Page::create([
                'page_name' => 'Módulos',
                'route' => 'modules.index',
                'id_page_type' => 2,
                'description' => 'CRUD para administración de módulos',
                'id_father_page' => $adminPageParent->id,
            ]);
        }

        $pagesPage = Page::where('route', 'pages.index')->first();
        if ($pagesPage) {
            $pagesPage->update(['id_father_page' => $adminPageParent->id]);
        } else {
            $pagesPage = Page::create([
                'page_name' => 'Páginas',
                'route' => 'pages.index',
                'id_page_type' => 2,
                'description' => 'CRUD para administración de páginas',
                'id_father_page' => $adminPageParent->id,
            ]);
        }

        // ============================================
        // 2. USUARIOS (Nuevo padre)
        // ============================================
        $usersParent = Page::where('page_name', 'Usuarios')->where('id_father_page', null)->first();
        
        if (!$usersParent) {
            $usersParent = Page::create([
                'page_name' => 'Usuarios',
                'route' => null,
                'id_page_type' => 1,
                'description' => 'Gestión de usuarios del sistema',
                'id_father_page' => null,
            ]);
        }

        // Actualizar páginas existentes de Empleados, Acudientes y Estudiantes
        $employeesPage = Page::where('route', 'employees.index')->first();
        if ($employeesPage) {
            $employeesPage->update(['id_father_page' => $usersParent->id]);
        }

        $guardiansPage = Page::where('route', 'guardians.index')->first();
        if ($guardiansPage) {
            $guardiansPage->update(['id_father_page' => $usersParent->id]);
        }

        $studentsPage = Page::where('route', 'students.index')->first();
        if ($studentsPage) {
            $studentsPage->update(['id_father_page' => $usersParent->id]);
        }

        // ============================================
        // 3. ADMINISTRACIÓN DE COLEGIO
        // ============================================
        $schoolAdminPage = Page::where('route', 'school.admin')->first();
        
        if (!$schoolAdminPage) {
            $schoolAdminPage = Page::create([
                'page_name' => 'Administración de Colegio',
                'route' => 'school.admin',
                'id_page_type' => 1,
                'description' => 'Administración académica del colegio',
                'id_father_page' => null,
            ]);
        }

        // Eliminar o actualizar la página submódulo "Matrículas" anterior (sin ruta)
        // Primero, reasignar sus hijos a null para que no queden huérfanos
        $oldEnrollmentsModule = Page::where('page_name', 'Matrículas')
            ->where('route', null)
            ->where('id_father_page', $schoolAdminPage->id)
            ->first();
        
        if ($oldEnrollmentsModule) {
            // Reasignar sus hijos a la página padre
            Page::where('id_father_page', $oldEnrollmentsModule->id)->update([
                'id_father_page' => $schoolAdminPage->id
            ]);
            // Eliminar los permisos asociados
            \App\Models\RoleByPage::where('id_page', $oldEnrollmentsModule->id)->delete();
            // Luego eliminar la página
            $oldEnrollmentsModule->delete();
        }

        // --- Tipos de Matrículas ---
        $enrollmentTypesPage = Page::where('route', 'enrollment-types.index')->first();
        if ($enrollmentTypesPage) {
            $enrollmentTypesPage->update(['id_father_page' => $schoolAdminPage->id]);
        } else {
            $enrollmentTypesPage = Page::create([
                'page_name' => 'Tipos de Matrículas',
                'route' => 'enrollment-types.index',
                'id_page_type' => 2,
                'description' => 'CRUD para manejo de tipos de matrícula',
                'id_father_page' => $schoolAdminPage->id,
            ]);
        }

        // --- Matrículas (CRUD) ---
        $enrollmentsModule = Page::where('route', 'enrollments.index')->first();
        if ($enrollmentsModule) {
            $enrollmentsModule->update(['id_father_page' => $schoolAdminPage->id]);
        } else {
            $enrollmentsModule = Page::create([
                'page_name' => 'Matrículas',
                'route' => 'enrollments.index',
                'id_page_type' => 2,
                'description' => 'CRUD para manejo de matrículas con forma de pago',
                'id_father_page' => $schoolAdminPage->id,
            ]);
        }

        // --- Grados ---
        $gradesPage = Page::where('route', 'grades.index')->first();
        if ($gradesPage) {
            $gradesPage->update(['id_father_page' => $schoolAdminPage->id]);
        }

        // --- Materias ---
        $subjectsPage = Page::where('route', 'subjects.index')->first();
        if ($subjectsPage) {
            $subjectsPage->update(['id_father_page' => $schoolAdminPage->id]);
        }

        // --- Contenidos/Temas ---
        $topicsPage = Page::where('route', 'topics.index')->first();
        if ($topicsPage) {
            $topicsPage->update(['id_father_page' => $schoolAdminPage->id]);
        } else {
            $topicsPage = Page::create([
                'page_name' => 'Contenidos',
                'route' => 'topics.index',
                'id_page_type' => 2,
                'description' => 'CRUD para manejo de contenidos/temas',
                'id_father_page' => $schoolAdminPage->id,
            ]);
        }

        // --- Actividades ---
        $activitiesPage = Page::where('route', 'activities.index')->first();
        if ($activitiesPage) {
            $activitiesPage->update(['id_father_page' => $schoolAdminPage->id]);
        } else {
            $activitiesPage = Page::create([
                'page_name' => 'Actividades',
                'route' => 'activities.index',
                'id_page_type' => 2,
                'description' => 'CRUD para manejo de actividades',
                'id_father_page' => $schoolAdminPage->id,
            ]);
        }

        // --- Notas del Estudiante / Calificaciones ---
        $gradesStudentPage = Page::where('route', 'student-grades.index')->first();
        if ($gradesStudentPage) {
            $gradesStudentPage->update(['id_father_page' => $schoolAdminPage->id]);
        } else {
            $gradesStudentPage = Page::create([
                'page_name' => 'Calificaciones',
                'route' => 'student-grades.index',
                'id_page_type' => 2,
                'description' => 'Asignación de notas por estudiante y materia',
                'id_father_page' => $schoolAdminPage->id,
            ]);
        }

        // ============================================
        // 4. REPORTES (Nuevo padre)
        // ============================================
        $reportsParent = Page::where('page_name', 'Reportes')->where('id_father_page', null)->first();
        
        if (!$reportsParent) {
            $reportsParent = Page::create([
                'page_name' => 'Reportes',
                'route' => null,
                'id_page_type' => 1,
                'description' => 'Reportes del sistema',
                'id_father_page' => null,
            ]);
        }

        // --- Reporte Detallado de Notas ---
        $detailedGradesReport = Page::firstOrCreate(
            ['route' => 'reports.grades.detailed'],
            [
                'page_name' => 'Reporte Detallado de Notas',
                'id_page_type' => 2,
                'description' => 'Mostrar las notas por estudiante y por materia',
                'id_father_page' => $reportsParent->id,
            ]
        );

        // --- Reporte Consolidado de Notas ---
        $consolidatedGradesReport = Page::firstOrCreate(
            ['route' => 'reports.grades.consolidated'],
            [
                'page_name' => 'Reporte Consolidado de Notas',
                'id_page_type' => 2,
                'description' => 'Mostrar las notas por estudiante y materia consolidadas',
                'id_father_page' => $reportsParent->id,
            ]
        );

        // ============================================
        // Asignar permisos a roles
        // ============================================
        $this->assignPermissionsToPages([
            $adminPageParent, $rolesPage, $modulesPage, $pagesPage,
            $usersParent, $employeesPage, $guardiansPage, $studentsPage,
            $schoolAdminPage, $enrollmentTypesPage, $enrollmentsModule,
            $gradesPage, $subjectsPage, $topicsPage,
            $activitiesPage, $gradesStudentPage,
            $reportsParent, $detailedGradesReport, $consolidatedGradesReport
        ], $adminRole, $superAdminRole);

        $this->command->info('✓ Estructura de páginas reorganizada exitosamente');
    }

    private function assignPermissionsToPages($pages, $adminRole, $superAdminRole)
    {
        $permissions = Permission::all();
        
        foreach ($pages as $page) {
            if (!$page || !$page->route) {
                // Solo asignar permisos a páginas con ruta (páginas funcionales)
                continue;
            }
            
            $role = $adminRole ?? $superAdminRole;
            if (!$role) {
                continue;
            }
            
            foreach ($permissions as $permission) {
                RoleByPage::firstOrCreate([
                    'id_role' => $role->id,
                    'id_page' => $page->id,
                    'id_permission' => $permission->id
                ]);
            }
        }
    }
}
