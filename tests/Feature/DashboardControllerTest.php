<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Hairdresser;
use App\Models\Service;
use App\Models\Signup;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class DashboardControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_loads_the_profile_view()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get('/dashboard/profile');

        $response->assertStatus(200);
        $response->assertViewIs('dashboards.profile');
        $response->assertViewHas('user', $user);
    }

    /** @test */
    public function it_loads_the_hairdresser_view()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get('/dashboard/hairdresser');

        $response->assertStatus(200);
        $response->assertViewIs('dashboards.insert-hairdresser');
    }

    /** @test */
    public function test_show_services_returns_401_if_user_not_authenticated()
    {
        $response = $this->post('/dashboard/services', [
            'hairdresser_id' => 1,
        ], [
            'Accept' => 'application/json',
        ]);

        $response->assertStatus(401);
    }

    public function test_show_services_returns_404_if_hairdresser_not_found()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->post(route('dashboard.services', ['hairdresser_id' => 999]));

        $response->assertStatus(404)
            ->assertJson(['error' => 'Peluquería no encontrada']);
    }

    public function test_show_services_displays_view_with_hairdresser_and_services()
    {
        $user = User::factory()->create();
        $hairdresser = Hairdresser::factory()->create(['owner_id' => $user->id]);
        $services = Service::factory()->count(3)->create(['hairdresser_id' => $hairdresser->id]);

        $response = $this->actingAs($user)
            ->post(route('dashboard.services', ['hairdresser_id' => $hairdresser->id]));

        $response->assertStatus(200)
            ->assertViewIs('dashboards.services_view')
            ->assertViewHas('hairdresser', $hairdresser)
            ->assertViewHas('services', function ($viewServices) use ($services) {
                return $viewServices->count() === 3 &&
                    $viewServices->pluck('id')->toArray() === $services->pluck('id')->toArray();
            });
    }

    public function test_select_hairdresser_returns_view_with_hairdressers()
    {
        $user = User::factory()->create([
            'role' => 'propietario',
        ]);

        $hairdressers = Hairdresser::factory()->count(3)->create([
            'owner_id' => $user->id,
        ]);

        $response = $this->actingAs($user)
            ->get(route('dashboard.selectHairdresser'));

        $response->assertStatus(200)
            ->assertViewIs('dashboards.select-hairdresser')
            ->assertViewHas('hairdressers', $hairdressers);
    }

    public function test_select_hairdresser_redirects_if_user_not_authenticated()
    {
        $response = $this->get(route('dashboard.selectHairdresser'));

        $response->assertRedirect(route('users.login'));
    }

    public function test_show_hairdressers_returns_view_with_hairdressers_and_signed_up_hairdressers()
    {

        $user = User::factory()->create();

        $hairdressers = Hairdresser::factory()->count(3)->create([
            'owner_id' => $user->id,
        ]);

        Signup::factory()->create(['client_id' => $user->id, 'hairdresser_id' => $hairdressers[0]->id]);

        $response = $this->actingAs($user)
            ->get(route('dashboard.showHairdressers'));

        $response->assertStatus(200)
            ->assertViewIs('dashboards.user-signup-hairdresser')
            ->assertViewHas('hairdressers', function ($viewHairdressers) use ($hairdressers) {
                return $viewHairdressers->count() === 3 && $viewHairdressers->pluck('id')->toArray() === $hairdressers->pluck('id')->toArray();
            })
            ->assertViewHas('hairdressersSignedUp', function ($viewHairdressersSignedUp) use ($hairdressers) {
                return $viewHairdressersSignedUp->pluck('id')->toArray() === [$hairdressers[0]->id];
            });
    }

    public function test_show_hairdressers_redirects_if_user_not_authenticated()
    {
        $response = $this->get(route('dashboard.showHairdressers'));

        $response->assertRedirect(route('users.login'));
    }

    public function test_update_profile_success()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $data = [
            'name' => 'Nuevo Nombre',
            'dni' => '12345678Z',
            'phone' => '987654321',
            'password' => 'NuevaContraseña123!',
            'password_confirmation' => 'NuevaContraseña123!',
        ];

        $response = $this->postJson(route('profile.updateProfile'), $data);

        $response->assertStatus(200);
        $response->assertJson(['success' => 'Perfil actualizado correctamente']);

        $user->refresh();
        $this->assertEquals('Nuevo Nombre', $user->name);
        $this->assertEquals('12345678Z', $user->dni);
        $this->assertEquals('987654321', $user->phone);
    }

    public function test_update_profile_validation_error()
    {

        $user = User::factory()->create();

        $this->actingAs($user);

        $data = [
            'name' => 'Nuevo Nombre',
            'dni' => '12345',
            'phone' => '12345',
            'password' => 'NuevaContraseña123!',
            'password_confirmation' => 'NuevaContraseña123!',
        ];

        $response = $this->postJson(route('profile.updateProfile'), $data);

        $response->assertStatus(400);
    }

    public function test_store_hairdresser_success()
    {
        $user = User::factory()->create([
            'role' => 'propietario',
        ]);

        $this->actingAs($user);


        $data = [
            'cif' => 'A12345678',
            'name' => 'Barber Shop',
            'address' => 'Calle Falsa, 123, 28000, Madrid',
            'phone' => '612345678',
        ];

        $response = $this->postJson(route('dashboard.insertHairDresser'), $data);
        $response->assertStatus(200);
        $response->assertJson(['success' => 'Peluquería añadida correctamente']);
    }

    public function test_store_hairdresser_validation_error()
    {
        $user = User::factory()->create([
            'role' => 'propietario',
        ]);

        $this->actingAs($user);

        $data = [
            'cif' => 'INVALIDCIF',
            'name' => 'Barber Shop',
            'address' => 'Calle Falsa, 123, 28000, Madrid',
            'phone' => '12345678',
        ];

        $response = $this->postJson(route('dashboard.insertHairDresser'), $data);
        $response->assertStatus(400);
    }

    public function test_store_hairdresser_authorization_error()
    {
        $user = User::factory()->create([
            'role' => 'cliente',
        ]);

        $this->actingAs($user);

        $data = [
            'cif' => 'A12345678',
            'name' => 'Barber Shop',
            'address' => 'Calle Falsa, 123, 28000, Madrid',
            'phone' => '612345678',
        ];

        $response = $this->postJson(route('dashboard.insertHairDresser'), $data);
        $response->assertStatus(403);
    }


    public function test_create_service_success()
    {
        $user = User::factory()->create(['role' => 'propietario']);

        $this->actingAs($user);

        $hairdresser = Hairdresser::factory()->create(['owner_id' => $user->id]);

        $data = [
            'name' => 'Corte de cabello',
            'price' => 15.99,
            'description' => 'Corte de cabello masculino',
            'idHairdresser' =>  $hairdresser->id,
        ];


        $response = $this->postJson(route('dashboard.createService'), $data);

        $response->assertStatus(200);
        $response->assertJson(['success' => 'Servicio añadido correctamente']);
    }

    public function test_create_service_authorization_error()
    {
        $user = User::factory()->create(['role' => 'cliente']);

        $this->actingAs($user);

        $hairdresser = Hairdresser::factory()->create(['owner_id' => $user->id]);

        $data = [
            'name' => 'Corte de cabello',
            'price' => 15.99,
            'description' => 'Corte de cabello masculino',
            'idHairdresser' =>  $hairdresser->id,
        ];


        $response = $this->postJson(route('dashboard.createService'), $data);

        $response->assertStatus(403);
        $response->assertJson(['error' => 'No tienes permisos para realizar esta acción']);
    }

    public function test_create_service_validation_error()
    {
        $user = User::factory()->create(['role' => 'propietario']);

        $this->actingAs($user);

        $hairdresser = Hairdresser::factory()->create(['owner_id' => $user->id]);

        $data = [
            'name' => 'Corte de cabello',
            'price' => 'INVALIDPRICE',
            'description' => 'Corte de cabello masculino',
            'idHairdresser' =>  $hairdresser->id,
        ];


        $response = $this->postJson(route('dashboard.createService'), $data);

        $response->assertStatus(400);
    }

    public function test_update_service_success()
    {
        $user = User::factory()->create(['role' => 'propietario']);

        $this->actingAs($user);

        $hairdresser = Hairdresser::factory()->create(['owner_id' => $user->id]);

        $service = Service::factory()->create(['hairdresser_id' => $hairdresser->id]);

        $data = [
            'name' => 'Nuevo Corte de cabello',
            'price' => 16.85,
            'description' => 'Nuevo corte de cabello con estilo moderno',
        ];

        $response = $this->putJson(route('dashboard.updateService', ['serviceId' => $service->id]), $data);

        $response->assertStatus(200);
        $response->assertJson(['success' => 'Servicio actualizado correctamente']);

        $this->assertDatabaseHas('services', [
            'id' => $service->id,
            'name' => 'Nuevo Corte de cabello',
            'price' => 16.85,
            'description' => 'Nuevo corte de cabello con estilo moderno',
        ]);
    }

    public function test_update_service_not_found()
    {
        $user = User::factory()->create(['role' => 'propietario']);

        $this->actingAs($user);

        $data = [
            'name' => 'Nuevo Corte de cabello',
            'price' => 16.85,
            'description' => 'Nuevo corte de cabello con estilo moderno',
        ];

        $response = $this->putJson(route('dashboard.updateService', ['serviceId' => 9999]), $data);

        $response->assertStatus(404);
        $response->assertJson(['error' => 'Servicio no encontrado']);
    }

    public function test_update_service_authorization_error()
    {
        $user = User::factory()->create(['role' => 'cliente']);

        $this->actingAs($user);

        $hairdresser = Hairdresser::factory()->create(['owner_id' => $user->id]);

        $service = Service::factory()->create(['hairdresser_id' => $hairdresser->id]);

        $data = [
            'name' => 'Nuevo Corte de cabello',
            'price' => 16.85,
            'description' => 'Nuevo corte de cabello con estilo moderno',
        ];

        $response = $this->putJson(route('dashboard.updateService', ['serviceId' => $service->id]), $data);

        $response->assertStatus(403);
        $response->assertJson(['error' => 'No tienes permisos para realizar esta acción']);
    }

    public function test_update_service_validation_error()
    {
        $user = User::factory()->create(['role' => 'propietario']);

        $this->actingAs($user);

        $hairdresser = Hairdresser::factory()->create(['owner_id' => $user->id]);

        $service = Service::factory()->create(['hairdresser_id' => $hairdresser->id]);

        $data = [
            'name' => 'Nuevo Corte de cabello',
            'price' => 'INVALIDPRICE',
            'description' => 'Nuevo corte de cabello con estilo moderno',
        ];

        $response = $this->putJson(route('dashboard.updateService', ['serviceId' => $service->id]), $data);

        $response->assertStatus(400);
    }

    public function test_delete_service_success()
    {
        $user = User::factory()->create(['role' => 'propietario']);

        $this->actingAs($user);

        $hairdresser = Hairdresser::factory()->create(['owner_id' => $user->id]);

        $service = Service::factory()->create(['hairdresser_id' => $hairdresser->id]);

        $response = $this->deleteJson(route('dashboard.deleteService', ['serviceId' => $service->id]));

        $response->assertStatus(200);
        $response->assertJson(['success' => 'Servicio eliminado correctamente']);

        $this->assertDatabaseMissing('services', ['id' => $service->id]);
    }

    public function test_delete_service_not_found()
    {
        $user = User::factory()->create(['role' => 'propietario']);

        $this->actingAs($user);

        $response = $this->deleteJson(route('dashboard.deleteService', ['serviceId' => 9999]));

        $response->assertStatus(404);
        $response->assertJson(['error' => 'Servicio no encontrado']);
    }

    public function test_delete_service_authorization_error()
    {
        $user = User::factory()->create(['role' => 'cliente']);

        $this->actingAs($user);

        $hairdresser = Hairdresser::factory()->create(['owner_id' => $user->id]);

        $service = Service::factory()->create(['hairdresser_id' => $hairdresser->id]);

        $response = $this->deleteJson(route('dashboard.deleteService', ['serviceId' => $service->id]));

        $response->assertStatus(403);
        $response->assertJson(['error' => 'No tienes permisos para realizar esta acción']);
    }



    public function test_signup_hairdresser_success()
    {
        $user = User::factory()->create(['role' => 'cliente']);
        $userOwner = User::factory()->create([
            'email' => 'propietario@email.com',
            'dni' => '12345678Z',
            'role' => 'propietario',
            'id' => 2,
        ]);

        $hairdresser = Hairdresser::factory()->create(['owner_id' => $userOwner->id]);

        $response = $this->actingAs($user)->postJson(route('dashboard.signupHairdresser'), [
            'hairdresser_id' => $hairdresser->id,
        ]);

        // Verificar que la respuesta sea exitosa.
        $response->assertStatus(200);
        $response->assertJson(['success' => 'Se ha dado de alta correctamente']);

        // Verificar que el usuario se ha registrado en la tabla Signup.
        $this->assertDatabaseHas('signups', [
            'client_id' => $user->id,
            'hairdresser_id' => $hairdresser->id,
        ]);
    }


    public function test_signup_hairdresser_authorization_error()
    {

        $user = User::factory()->create(['role' => 'propietario']);

        $userOwner = User::factory()->create([
            'email' => 'propietario@email.com',
            'dni' => '12345678Z',
            'role' => 'propietario',
            'id' => 2,
        ]);

        $hairdresser = Hairdresser::factory()->create(['owner_id' => $userOwner->id]);

        $response = $this->actingAs($user)->postJson(route('dashboard.signupHairdresser'), [
            'hairdresser_id' => $hairdresser->id,
        ]);

        $response->assertStatus(403);
        $response->assertJson(['error' => 'No tienes permisos para realizar esta acción']);
    }

    public function test_signup_hairdresser_validation_error()
    {
        $user = User::factory()->create(['role' => 'cliente']);

        $response = $this->actingAs($user)->postJson(route('dashboard.signupHairdresser'), [
            'hairdresser_id' => "INVALIDHAIRDRESSERID",
        ]);

        $response->assertStatus(400);
        $response->assertJson(['error' => 'El campo hairdresser id debe ser un número entero.']);
    }

    public function test_signup_hairdresser_not_found_error()
    {
        $user = User::factory()->create(['role' => 'cliente']);

        $response = $this->actingAs($user)->postJson(route('dashboard.signupHairdresser'), [
            'hairdresser_id' => 9999,
        ]);

        $response->assertStatus(404);
        $response->assertJson(['error' => 'Peluquería no encontrada']);
    }

    public function test_signup_hairdresser_already_signed_up_error()
    {
        $user = User::factory()->create(['role' => 'cliente']);
        $userOwner = User::factory()->create([
            'email' => 'propietario@email.com',
            'dni' => '12345678Z',
            'role' => 'propietario',
            'id' => 2,
        ]);
        $hairdresser = Hairdresser::factory()->create(['owner_id' => $userOwner->id]);

        Signup::factory()->create(['client_id' => $user->id, 'hairdresser_id' => $hairdresser->id]);

        $response = $this->actingAs($user)->postJson(route('dashboard.signupHairdresser'), [
            'hairdresser_id' => $hairdresser->id,
        ]);

        $response->assertStatus(400);
        $response->assertJson(['error' => 'Ya te has dado de alta en la peluquería']);
    }
    
}
