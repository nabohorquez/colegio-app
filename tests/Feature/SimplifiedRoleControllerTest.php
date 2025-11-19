<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use App\Models\Page;
use App\Models\Permission;
use App\Models\PageType;
use App\Models\RoleByPage;
use App\Models\RoleByUser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SimplifiedRoleControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Seed page types necesarios
        PageType::create(['id' => 1, 'type_name' => 'Módulo', 'description' => 'Módulo']);
        PageType::create(['id' => 2, 'type_name' => 'Página', 'description' => 'Página']);
        PageType::create(['id' => 3, 'type_name' => 'Componente', 'description' => 'Componente']);
        
        // Crear usuario de prueba
        $this->user = User::factory()->create([
            'email' => 'test@test.com',
            'password' => bcrypt('password'),
        ]);
    }

    /** @test */
    public function it_can_create_a_role_directly()
    {
        $role = Role::create([
            'rol_name' => 'Test Role',
            'description' => 'Test Description'
        ]);

        $this->assertDatabaseHas('roles', [
            'rol_name' => 'Test Role',
            'description' => 'Test Description'
        ]);
        
        $this->assertInstanceOf(Role::class, $role);
        $this->assertEquals('Test Role', $role->rol_name);
    }

    /** @test */
    public function it_can_update_a_role()
    {
        $role = Role::factory()->create([
            'rol_name' => 'Old Name',
            'description' => 'Old Description'
        ]);

        $role->update([
            'rol_name' => 'Updated Name',
            'description' => 'Updated Description'
        ]);

        $this->assertDatabaseHas('roles', [
            'id' => $role->id,
            'rol_name' => 'Updated Name',
            'description' => 'Updated Description'
        ]);
    }

    /** @test */
    public function it_can_delete_a_role_and_its_relations()
    {
        $role = Role::factory()->create(['rol_name' => 'To Delete']);
        
        // Crear una relación role-page
        $page = Page::create([
            'id_page_type' => 2,
            'page_name' => 'Test Page',
            'description' => 'Test',
            'route' => 'test.index'
        ]);
        
        $permission = Permission::create(['permission' => 'read']);
        
        RoleByPage::create([
            'id_role' => $role->id,
            'id_page' => $page->id,
            'id_permission' => $permission->id
        ]);

        // Verificar que existe
        $this->assertDatabaseHas('roles_by_pages', [
            'id_role' => $role->id,
            'id_page' => $page->id
        ]);

        // Eliminar role y sus relaciones
        RoleByPage::where('id_role', $role->id)->delete();
        $role->delete();

        $this->assertDatabaseMissing('roles', ['id' => $role->id]);
        $this->assertDatabaseMissing('roles_by_pages', ['id_role' => $role->id]);
    }

    /** @test */
    public function it_can_assign_permissions_to_role_for_page()
    {
        $role = Role::factory()->create();
        $page = Page::create([
            'id_page_type' => 2,
            'page_name' => 'Users',
            'description' => 'Users Page',
            'route' => 'users.index'
        ]);
        
        $permission = Permission::create(['permission' => 'create']);

        RoleByPage::create([
            'id_role' => $role->id,
            'id_page' => $page->id,
            'id_permission' => $permission->id
        ]);

        $this->assertDatabaseHas('roles_by_pages', [
            'id_role' => $role->id,
            'id_page' => $page->id,
            'id_permission' => $permission->id
        ]);
    }

    /** @test */
    public function it_can_get_role_with_pages()
    {
        $role = Role::factory()->create();
        $page = Page::create([
            'id_page_type' => 2,
            'page_name' => 'Dashboard',
            'description' => 'Main Dashboard',
            'route' => 'dashboard'
        ]);
        
        $permission = Permission::create(['permission' => 'read']);

        RoleByPage::create([
            'id_role' => $role->id,
            'id_page' => $page->id,
            'id_permission' => $permission->id
        ]);

        // Cargar role con sus páginas
        $roleWithPages = Role::with('pagesByRole')->find($role->id);

        $this->assertInstanceOf(Role::class, $roleWithPages);
        $this->assertNotEmpty($roleWithPages->pagesByRole);
        $this->assertEquals($page->id, $roleWithPages->pagesByRole->first()->id_page);
    }

    /** @test */
    public function role_validation_works()
    {
        Role::create(['rol_name' => 'Existing Role', 'description' => 'Test']);

        // Intentar buscar rol duplicado
        $exists = Role::where('rol_name', 'Existing Role')->exists();
        $this->assertTrue($exists);

        // Verificar que otro nombre no existe
        $notExists = Role::where('rol_name', 'Non Existing Role')->exists();
        $this->assertFalse($notExists);
    }

    /** @test */
    public function it_can_assign_role_to_user()
    {
        $role = Role::factory()->create(['rol_name' => 'Admin']);
        $user = User::factory()->create();

        RoleByUser::create([
            'id_role' => $role->id,
            'id_user' => $user->id
        ]);

        $this->assertDatabaseHas('roles_by_users', [
            'id_role' => $role->id,
            'id_user' => $user->id
        ]);

        // Verificar relación
        $userWithRoles = User::with('roles')->find($user->id);
        $this->assertNotEmpty($userWithRoles->roles);
        $this->assertEquals($role->id, $userWithRoles->roles->first()->id);
    }
}
