<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function it_loads_the_login_view()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        $response->assertViewIs('users.login-view');
    }

    /** @test */
    public function it_loads_the_register_view()
    {
        $response = $this->get('/create');

        $response->assertStatus(200);
        $response->assertViewIs('users.create');
    }

    /** @test */
    public function it_loads_the_forgot_password_view()
    {
        $response = $this->get('/forgot-password');

        $response->assertStatus(200);
        $response->assertViewIs('auth.forgot-password');
    }

    /** @test */
    public function it_registers_a_new_user()
    {
        $userData = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '123456789',
            'dni' => '12345543Q',
            'sex' => 'masculino',
            'rol' => 'cliente',
            'password' => 'Password123$',
            'password_confirmation' => 'Password123$',
        ];

        $response = $this->post('/store', $userData);

        // Verifica que el usuario haya sido creado y redirigido al dashboard
        $this->assertDatabaseHas('users', ['email' => 'john@example.com']);
        $response->assertRedirect(route('users.dashboard'));
    }

    /** @test */
    public function it_fails_to_register_a_user_with_existing_email()
    {
        $user = User::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '123456789',
            'dni' => '12345543Q',
            'sex' => 'masculino',
            'rol' => 'cliente',
            'password' => 'Password123$',
            'password_confirmation' => 'Password123$',
        ]);

        $response = $this->post('/store', [
            'name' => 'John Doe',
            'email' => $user->email,
            'phone' => '123456789',
            'dni' => '12345678A',
            'sex' => 'masculino',
            'rol' => 'cliente',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertSessionHasErrors();
    }

    /** @test */
    public function it_authenticates_an_existing_user()
    {
        $user = User::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '123456789',
            'dni' => '12345543Q',
            'sex' => 'masculino',
            'rol' => 'cliente',
            'password' => bcrypt('Password123$'),
            'password_confirmation' => 'Password123$',
        ]);

        $response = $this->post('/loginUser', [
            'email' => $user->email,
            'password' => 'Password123$',
        ]);

        $response->assertRedirect(route('users.dashboard'));
        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    public function it_fails_to_authenticate_with_incorrect_credentials()
    {
        $user = User::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '123456789',
            'dni' => '12345543Q',
            'sex' => 'masculino',
            'rol' => 'cliente',
            'password' => 'Password123$',
            'password_confirmation' => 'Password123$',
        ]);

        $response = $this->post('/loginUser', [
            'email' => $user->email,
            'password' => 'wrongpassword',
        ]);

        $response->assertSessionHasErrors('general');
        $this->assertGuest();
    }

    /** @test */
    public function it_resets_password()
    {
        $user = User::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '123456789',
            'dni' => '12345543Q',
            'sex' => 'masculino',
            'rol' => 'cliente',
            'password' => 'Password123$',
            'password_confirmation' => 'Password123$',
        ]);
    
        $token = Password::createToken($user);
    
        $response = $this->post('/reset-password', [
            'email' => $user->email,
            'password' => 'Newpassword123$',
            'password_confirmation' => 'Newpassword123$',
            'token' => $token,
        ]);
    
        $response->assertRedirect(route('users.login'));
        $this->assertTrue(Hash::check('Newpassword123$', $user->fresh()->password));
    }

    /** @test */
    public function it_logs_out_the_user()
    {
        $user = User::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '123456789',
            'dni' => '12345543Q',
            'sex' => 'masculino',
            'rol' => 'cliente',
            'password' => bcrypt('Password123$'),
            'password_confirmation' => 'Password123$',
        ]);

        $user->email_verified_at = now();
        $user->save();
        Auth::login($user);

        $response = $this->post('/logout');

        $response->assertRedirect(route('users.login'));
        $this->assertGuest();
    }
}
