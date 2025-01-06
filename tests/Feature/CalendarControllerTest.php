<?php

namespace Tests\Feature;

use App\Models\Hairdresser;
use App\Models\Service;
use App\Models\Signup;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class CalendarControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_find_signup_redirects_to_login_if_user_is_not_authenticated()
    {
        $response = $this->get(route('dashboard.selectSignup'));
        $response->assertRedirect(route('users.login'));
    }

    public function test_display_hairdressers_for_authenticated_client()
    {
        $client = User::factory()->create(['role' => 'cliente']);
        $userOwner = User::factory()->create([
            'email' => 'propietario@email.com',
            'dni' => '12345678Z',
            'role' => 'propietario',
            'id' => 2,
        ]);

        $this->actingAs($client);

        $hairdresser1 = Hairdresser::factory()->create(['name' => 'Peluqueria 1', 'cif' => '12345678Z', 'owner_id' => $userOwner->id, 'id' => 1]);
        $hairdresser2 = Hairdresser::factory()->create(['name' => 'Peluqueria 2', 'cif' => '12345678K', 'owner_id' => $userOwner->id, 'id' => 2]);

        Signup::factory()->create(['client_id' => $client->id, 'hairdresser_id' => $hairdresser1->id]);
        Signup::factory()->create(['client_id' => $client->id, 'hairdresser_id' => $hairdresser2->id]);

        $response = $this->get(route('dashboard.selectSignup'));

        $response->assertViewIs('dashboards.select-signup');
        $response->assertViewHas('hairdressers', function ($viewHairdressers) use ($hairdresser1, $hairdresser2) {
            return collect($viewHairdressers)->pluck('id')->sort()->values()->all() ===
                collect([$hairdresser1, $hairdresser2])->pluck('id')->sort()->values()->all();
        });
    }

    public function test_display_hairdressers_for_owners()
    {
        $owner = User::factory()->create(['role' => 'propietario']);

        $this->actingAs($owner);

        Hairdresser::factory()->create(['name' => 'Peluqueria 1', 'cif' => '12345678Z', 'owner_id' => $owner->id, 'id' => 1]);
        Hairdresser::factory()->create(['name' => 'Peluqueria 2', 'cif' => '12345678K', 'owner_id' => $owner->id, 'id' => 2]);
        Hairdresser::factory()->create(['name' => 'Peluqueria 3', 'cif' => '12345678L', 'owner_id' => $owner->id, 'id' => 3]);

        $hairdressers = Hairdresser::where('owner_id', $owner->id)->get();

        $response = $this->get(route('dashboard.selectSignup'));
        $response->assertStatus(200);
        $response->assertViewIs('dashboards.select-signup');
        $response->assertViewHas('hairdressers', $hairdressers);
    }

    public function test_show_calendar_with_valid_hairdresser_id()
    {
        $authUser = User::factory()->create(['role' => 'propietario']);
        $this->actingAs($authUser);
        $hairdresser = Hairdresser::factory()->create();
        $services = Service::factory()->count(3)->create(['hairdresser_id' => $hairdresser->id]);
        $clients = User::factory()->count(3)->create();
        $hairdresser->clients()->attach($clients);

        $response = $this->post(route('dashboard.showCalendar'), ['hairdresser_id' => $hairdresser->id]);

        $response->assertStatus(200);
        $response->assertViewIs('dashboards.calendar');
        $response->assertViewHas('services', $services);
        $response->assertViewHas('hairdresser', $hairdresser);
        $response->assertViewHas('clients', $clients);
    }

    public function test_show_calendar_with_invalid_hairdresser_id()
    {
        $authUser = User::factory()->create(['role' => 'propietario']);
        $this->actingAs($authUser);
        $hairdresser = Hairdresser::factory()->create();
        Service::factory()->count(3)->create(['hairdresser_id' => $hairdresser->id]);
        $clients = User::factory()->count(3)->create();
        $hairdresser->clients()->attach($clients);

        $response = $this->post(route('dashboard.showCalendar'), ['hairdresser_id' => "INVALID_ID"]);

        $response->assertStatus(400);
        $response->assertJson(['error' => 'Error al mostrar el calendario']);
    }

    public function test_show_calendar_hairdresser_not_found()
    {
        $authUser = User::factory()->create(['role' => 'propietario']);
        $this->actingAs($authUser);
        $hairdresser = Hairdresser::factory()->create();
        $services = Service::factory()->count(3)->create(['hairdresser_id' => $hairdresser->id]);
        $clients = User::factory()->count(3)->create();
        $hairdresser->clients()->attach($clients);

        $response = $this->post(route('dashboard.showCalendar'), ['hairdresser_id' => 8]);

        $response->assertStatus(404);
        $response->assertJson(['error' => 'Peluquería no encontrada']);
    }
}
