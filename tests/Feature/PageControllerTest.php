<?php

namespace Tests\Feature;

use App\Models\Page;
use App\Models\User;
use App\Models\Role;
use App\Models\RoleByUser;
use App\Models\RoleByPage;
use App\Models\Permission;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PageControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Crear usuario de prueba
        $this->user = User::factory()->create([
            'email' => 'test@test.com',
            'password' => bcrypt('password'),
        ]);

        // Crear role y asignarlo al usuario
        $this->role = Role::factory()->create(['rol_name' => 'Test Role']);
        RoleByUser::create([
            'id_role' => $this->role->id,
            'id_user' => $this->user->id
        ]);
    }

    /** @test */
    public function it_can_get_menu_pages_for_user()
    {
        // Crear estructura de páginas: módulo -> página -> componente
        $module = Page::factory()->create([
            'id_page_type' => 1, // módulo
            'page_name' => 'Test Module',
            'id_father_page' => null
        ]);

        $page = Page::factory()->create([
            'id_page_type' => 2, // página
            'page_name' => 'Test Page',
            'id_father_page' => $module->id
        ]);

        $component = Page::factory()->create([
            'id_page_type' => 3, // componente
            'page_name' => 'Test Component',
            'id_father_page' => $page->id
        ]);

        // Asignar permisos
        $permission = Permission::factory()->create();
        
        RoleByPage::create([
            'id_role' => $this->role->id,
            'id_page' => $page->id,
            'id_permission' => $permission->id
        ]);

        RoleByPage::create([
            'id_role' => $this->role->id,
            'id_page' => $component->id,
            'id_permission' => $permission->id
        ]);

        $controller = new \App\Http\Controllers\PageController();
        $result = $controller->getPagesToMenu($this->user->id);

        $this->assertInstanceOf(\Illuminate\Support\Collection::class, $result);
        $this->assertGreaterThan(0, $result->count());
    }

    /** @test */
    public function it_returns_empty_collection_when_user_has_no_roles()
    {
        $userWithoutRole = User::factory()->create();

        $controller = new \App\Http\Controllers\PageController();
        $result = $controller->getPagesToMenu($userWithoutRole->id);

        $this->assertEquals([], $result);
    }

    /** @test */
    public function it_filters_modules_without_allowed_pages()
    {
        // Crear módulo sin páginas permitidas
        $moduleWithoutPages = Page::factory()->create([
            'id_page_type' => 1,
            'page_name' => 'Empty Module',
            'id_father_page' => null
        ]);

        // Crear módulo con páginas permitidas
        $moduleWithPages = Page::factory()->create([
            'id_page_type' => 1,
            'page_name' => 'Full Module',
            'id_father_page' => null
        ]);

        $allowedPage = Page::factory()->create([
            'id_page_type' => 2,
            'page_name' => 'Allowed Page',
            'id_father_page' => $moduleWithPages->id
        ]);

        $permission = Permission::factory()->create();
        RoleByPage::create([
            'id_role' => $this->role->id,
            'id_page' => $allowedPage->id,
            'id_permission' => $permission->id
        ]);

        $controller = new \App\Http\Controllers\PageController();
        $result = $controller->getPagesToMenu($this->user->id);

        // Solo debe incluir el módulo con páginas permitidas
        $this->assertTrue($result->contains('page_name', 'Full Module'));
        $this->assertFalse($result->contains('page_name', 'Empty Module'));
    }

    /** @test */
    public function it_includes_sub_pages_with_components()
    {
        $module = Page::factory()->create([
            'id_page_type' => 1,
            'page_name' => 'Module',
        ]);

        $page = Page::factory()->create([
            'id_page_type' => 2,
            'page_name' => 'Page',
            'id_father_page' => $module->id
        ]);

        $component1 = Page::factory()->create([
            'id_page_type' => 3,
            'page_name' => 'Component 1',
            'id_father_page' => $page->id
        ]);

        $component2 = Page::factory()->create([
            'id_page_type' => 3,
            'page_name' => 'Component 2',
            'id_father_page' => $page->id
        ]);

        $permission = Permission::factory()->create();

        // Asignar permisos
        foreach ([$page, $component1, $component2] as $item) {
            RoleByPage::create([
                'id_role' => $this->role->id,
                'id_page' => $item->id,
                'id_permission' => $permission->id
            ]);
        }

        $controller = new \App\Http\Controllers\PageController();
        $result = $controller->getPagesToMenu($this->user->id);

        $module = $result->first();
        $this->assertNotEmpty($module->sub_pages);
        $this->assertCount(2, $module->sub_pages[0]->components);
    }

    /** @test */
    public function it_can_get_all_pages_by_modules()
    {
        // Crear estructura completa
        $module = Page::factory()->create(['id_page_type' => 1]);
        $page = Page::factory()->create([
            'id_page_type' => 2,
            'id_father_page' => $module->id
        ]);
        $component = Page::factory()->create([
            'id_page_type' => 3,
            'id_father_page' => $page->id
        ]);

        $controller = new \App\Http\Controllers\PageController();
        $result = $controller->getAllPagesByModules();

        $this->assertInstanceOf(\Illuminate\Support\Collection::class, $result);
        $this->assertGreaterThan(0, $result->count());
        
        $firstModule = $result->first();
        $this->assertIsArray($firstModule->sub_pages);
    }
}
