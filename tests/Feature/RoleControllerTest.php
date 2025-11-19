<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use App\Models\Page;
use App\Models\Permission;
use App\Models\RoleByPage;
use App\Models\RoleByUser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RoleControllerTest extends TestCase
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
    }

    /** @test */
    public function it_can_list_all_roles()
    {
        // Crear algunos roles de prueba
        Role::factory()->count(3)->create();

        $response = $this->actingAs($this->user)
            ->get(route('roles.index'));

        $response->assertStatus(200);
        $response->assertViewIs('roles.index');
        $response->assertViewHas('roles');
    }

    /** @test */
    public function it_can_show_role_by_id()
    {
        $role = Role::factory()->create([
            'rol_name' => 'Test Role',
            'description' => 'Test Description'
        ]);

        $response = $this->actingAs($this->user)
            ->get(route('roles.getById', $role->id));

        $response->assertStatus(200);
        $response->assertViewIs('roles.form');
        $response->assertViewHas('role');
        $response->assertSee('Test Role');
    }

    /** @test */
    public function it_can_create_a_new_role()
    {
        $roleData = [
            'rol_name' => 'New Role',
            'description' => 'New Role Description',
            'permissions' => []
        ];

        $response = $this->actingAs($this->user)
            ->post(route('roles.create'), $roleData);

        $response->assertRedirect(route('roles.index'));
        $response->assertSessionHas('success', 'Rol creado.');
        
        $this->assertDatabaseHas('roles', [
            'rol_name' => 'New Role',
            'description' => 'New Role Description'
        ]);
    }

    /** @test */
    public function it_cannot_create_duplicate_role()
    {
        Role::factory()->create(['rol_name' => 'Existing Role']);

        $roleData = [
            'rol_name' => 'Existing Role',
            'description' => 'Duplicate Description'
        ];

        $response = $this->actingAs($this->user)
            ->post(route('roles.create'), $roleData);

        $response->assertRedirect(route('roles.index'));
        $response->assertSessionHas('error', 'El rol ya existe.');
    }

    /** @test */
    public function it_can_update_an_existing_role()
    {
        $role = Role::factory()->create([
            'rol_name' => 'Old Name',
            'description' => 'Old Description'
        ]);

        $updateData = [
            'rol_name' => 'Updated Name',
            'description' => 'Updated Description'
        ];

        $response = $this->actingAs($this->user)
            ->put(route('roles.update', $role->id), $updateData);

        $response->assertRedirect(route('roles.index', $role->id));
        $response->assertSessionHas('success', 'Rol actualizado.');
        
        $this->assertDatabaseHas('roles', [
            'id' => $role->id,
            'rol_name' => 'Updated Name',
            'description' => 'Updated Description'
        ]);
    }

    /** @test */
    public function it_can_delete_a_role()
    {
        $role = Role::factory()->create(['rol_name' => 'To Delete']);

        $response = $this->actingAs($this->user)
            ->delete(route('roles.delete', $role->id));

        $response->assertRedirect(route('roles.index'));
        $response->assertSessionHas('success', 'Rol eliminado.');
        
        $this->assertDatabaseMissing('roles', ['id' => $role->id]);
    }

    /** @test */
    public function it_throws_exception_when_role_not_found()
    {
        $this->withoutExceptionHandling();
        $this->expectException(\Symfony\Component\HttpKernel\Exception\NotFoundHttpException::class);

        $this->actingAs($this->user)
            ->get(route('roles.getById', 999));
    }

    /** @test */
    public function it_requires_rol_name_when_creating()
    {
        $roleData = [
            'description' => 'Missing name'
        ];

        $response = $this->actingAs($this->user)
            ->post(route('roles.create'), $roleData);

        $response->assertSessionHasErrors(['rol_name']);
    }

    /** @test */
    public function it_can_get_permissions_by_role_and_page()
    {
        // Crear estructuras necesarias
        $role = Role::factory()->create();
        $user = User::factory()->create();
        $page = Page::factory()->create(['route' => 'users.index']);
        $permission = Permission::factory()->create();

        // Asignar role a user
        RoleByUser::create([
            'id_role' => $role->id,
            'id_user' => $user->id
        ]);

        // Asignar permiso a role+page
        RoleByPage::create([
            'id_role' => $role->id,
            'id_page' => $page->id,
            'id_permission' => $permission->id
        ]);

        $controller = new \App\Http\Controllers\RoleController();
        $result = $controller->getPermissionsPageByRoleId($user->id, 'users');

        $this->assertNotEmpty($result);
        $this->assertIsArray($result);
    }
}
