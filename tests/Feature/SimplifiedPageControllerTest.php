<?php

namespace Tests\Feature;

use App\Models\Page;
use App\Models\User;
use App\Models\Role;
use App\Models\PageType;
use App\Models\RoleByUser;
use App\Models\RoleByPage;
use App\Models\Permission;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SimplifiedPageControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Seed page types necesarios
        PageType::create(['id' => 1, 'type_name' => 'Módulo', 'description' => 'Módulo']);
        PageType::create(['id' => 2, 'type_name' => 'Página', 'description' => 'Página']);
        PageType::create(['id' => 3, 'type_name' => 'Componente', 'description' => 'Componente']);
        
        // Crear usuario y role
        $this->user = User::factory()->create([
            'email' => 'test@test.com',
            'password' => bcrypt('password'),
        ]);

        $this->role = Role::factory()->create(['rol_name' => 'Test Role']);
        RoleByUser::create([
            'id_role' => $this->role->id,
            'id_user' => $this->user->id
        ]);
    }

    /** @test */
    public function it_can_create_page_hierarchy()
    {
        $module = Page::create([
            'id_page_type' => 1,
            'page_name' => 'Test Module',
            'description' => 'Test',
            'route' => 'module',
            'id_father_page' => null
        ]);

        $page = Page::create([
            'id_page_type' => 2,
            'page_name' => 'Test Page',
            'description' => 'Test',
            'route' => 'page.index',
            'id_father_page' => $module->id
        ]);

        $component = Page::create([
            'id_page_type' => 3,
            'page_name' => 'Test Component',
            'description' => 'Test',
            'route' => 'component.index',
            'id_father_page' => $page->id
        ]);

        $this->assertDatabaseHas('pages', ['id' => $module->id, 'id_page_type' => 1]);
        $this->assertDatabaseHas('pages', ['id' => $page->id, 'id_father_page' => $module->id]);
        $this->assertDatabaseHas('pages', ['id' => $component->id, 'id_father_page' => $page->id]);
    }

    /** @test */
    public function it_can_get_modules()
    {
        Page::create([
            'id_page_type' => 1,
            'page_name' => 'Module 1',
            'description' => 'Test',
            'route' => 'module1'
        ]);

        Page::create([
            'id_page_type' => 1,
            'page_name' => 'Module 2',
            'description' => 'Test',
            'route' => 'module2'
        ]);

        $modules = Page::where('id_page_type', 1)->get();

        $this->assertCount(2, $modules);
    }

    /** @test */
    public function it_can_filter_pages_by_role()
    {
        $page = Page::create([
            'id_page_type' => 2,
            'page_name' => 'Allowed Page',
            'description' => 'Test',
            'route' => 'allowed.index'
        ]);

        $permission = Permission::create(['permission' => 'read']);

        RoleByPage::create([
            'id_role' => $this->role->id,
            'id_page' => $page->id,
            'id_permission' => $permission->id
        ]);

        $allowedPages = Page::whereHas('roles', function ($q) {
            $q->where('roles.id', $this->role->id);
        })->get();

        $this->assertCount(1, $allowedPages);
        $this->assertEquals('Allowed Page', $allowedPages->first()->page_name);
    }

    /** @test */
    public function it_can_build_menu_structure()
    {
        // Crear estructura completa
        $module = Page::create([
            'id_page_type' => 1,
            'page_name' => 'Admin',
            'description' => 'Admin Module',
            'route' => 'admin'
        ]);

        $page1 = Page::create([
            'id_page_type' => 2,
            'page_name' => 'Users',
            'description' => 'Users Page',
            'route' => 'users.index',
            'id_father_page' => $module->id
        ]);

        $page2 = Page::create([
            'id_page_type' => 2,
            'page_name' => 'Roles',
            'description' => 'Roles Page',
            'route' => 'roles.index',
            'id_father_page' => $module->id
        ]);

        $component = Page::create([
            'id_page_type' => 3,
            'page_name' => 'Create User',
            'description' => 'Create component',
            'route' => 'users.create',
            'id_father_page' => $page1->id
        ]);

        // Asignar permisos
        $permission = Permission::create(['permission' => 'read']);

        foreach ([$page1, $page2, $component] as $item) {
            RoleByPage::create([
                'id_role' => $this->role->id,
                'id_page' => $item->id,
                'id_permission' => $permission->id
            ]);
        }

        // Obtener estructura
        $modules = Page::where('id_page_type', 1)->get();
        $allowedPages = Page::whereIn('id_page_type', [2, 3])
            ->whereHas('roles', function ($q) {
                $q->where('roles.id', $this->role->id);
            })
            ->get();

        $pages = $allowedPages->where('id_page_type', 2);
        $components = $allowedPages->where('id_page_type', 3);

        // Verificar estructura
        $this->assertCount(1, $modules);
        $this->assertCount(2, $pages);
        $this->assertCount(1, $components);

        // Verificar relaciones
        $pagesForModule = $pages->where('id_father_page', $module->id);
        $this->assertCount(2, $pagesForModule);

        $componentsForPage = $components->where('id_father_page', $page1->id);
        $this->assertCount(1, $componentsForPage);
    }

    /** @test */
    public function page_relations_work_correctly()
    {
        $module = Page::create([
            'id_page_type' => 1,
            'page_name' => 'Module',
            'description' => 'Test',
            'route' => 'module'
        ]);

        $page = Page::create([
            'id_page_type' => 2,
            'page_name' => 'Page',
            'description' => 'Test',
            'route' => 'page.index',
            'id_father_page' => $module->id
        ]);

        // Verificar relación subPages
        $moduleWithSubPages = Page::with('subPages')->find($module->id);
        $this->assertNotNull($moduleWithSubPages->subPages);
    }
}
