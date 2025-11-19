<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_shows_login_form()
    {
        $response = $this->get(route('login'));

        $response->assertStatus(200);
        $response->assertViewIs('auth.login');
    }

    /** @test */
    public function it_can_login_with_valid_credentials()
    {
        $user = User::factory()->create([
            'email' => 'test@test.com',
            'password' => Hash::make('password123'),
        ]);

        $response = $this->post(route('login.post'), [
            'email' => 'test@test.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect('dashboard');
        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    public function it_cannot_login_with_invalid_credentials()
    {
        User::factory()->create([
            'email' => 'test@test.com',
            'password' => Hash::make('password123'),
        ]);

        $response = $this->post(route('login.post'), [
            'email' => 'test@test.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    /** @test */
    public function it_requires_email_and_password()
    {
        $response = $this->post(route('login.post'), []);

        $response->assertSessionHasErrors(['email', 'password']);
    }

    /** @test */
    public function it_can_logout()
    {
        $user = User::factory()->create();

        $this->actingAs($user);
        $this->assertAuthenticated();

        $response = $this->post(route('logout'));

        $response->assertRedirect('/login');
        $this->assertGuest();
    }

    /** @test */
    public function it_validates_email_format()
    {
        $response = $this->post(route('login.post'), [
            'email' => 'invalid-email',
            'password' => 'password123',
        ]);

        $response->assertSessionHasErrors('email');
    }
}
