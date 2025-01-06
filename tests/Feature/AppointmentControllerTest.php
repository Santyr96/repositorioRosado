<?php

namespace Tests\Feature;

use App\Models\Appointment;
use App\Models\Hairdresser;
use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\App;
use Tests\TestCase;

class AppointmentControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_appointments_clients_appointments(){
        $user = User::factory()->create(['role' => 'cliente']);
        $this->actingAs($user);

        $hairdresser = Hairdresser::factory()->create();

        Appointment::factory()->count(2)->create(['client_id' => $user->id, 'hairdresser_id' => $hairdresser->id, 'unregistered_client' => null, 'status'=> 'pendiente']);

        $response = $this->getJson(route('dashboard.showAppointments', ['hairdresserId' => $hairdresser->id]));
        $response->assertStatus(200);
        $response->assertJsonCount(2);

    }

    public function test_index_appointments_clients_appointments_and_other_clients(){
        $user = User::factory()->create(['role' => 'cliente']);
        $otherClient = User::factory()->create(['role' => 'cliente']);
        $this->actingAs($user);

        $hairdresser = Hairdresser::factory()->create();

        Appointment::factory()->count(2)->create(['client_id' => $user->id, 'hairdresser_id' => $hairdresser->id, 'unregistered_client' => null, 'status'=> 'pendiente']);
        Appointment::factory()->count(2)->create(['client_id' => $otherClient->id, 'hairdresser_id' => $hairdresser->id, 'unregistered_client' => null, 'status'=> 'pendiente']);
        Appointment::factory()->count(2)->create(['client_id' => null, 'hairdresser_id' => $hairdresser->id, 'unregistered_client' => 'Antonio Serrano', 'status'=> 'pendiente']);

        $response = $this->getJson(route('dashboard.showAppointments', ['hairdresserId' => $hairdresser->id]));
        $response->assertStatus(200);
        $response->assertJsonCount(6);
    }

    public function test_index_appointments_owner_appointments(){
        $user = User::factory()->create(['role' => 'propietario']);
        $this->actingAs($user);

        $hairdresser = Hairdresser::factory()->create(['owner_id' => $user->id]);

        Appointment::factory()->count(2)->create(['client_id' => null, 'hairdresser_id' => $hairdresser->id, 'unregistered_client' => 'Antonio Serrano', 'status'=> 'pendiente']);

        $response = $this->getJson(route('dashboard.showAppointments', ['hairdresserId' => $hairdresser->id]));
        $response->assertStatus(200);
        $response->assertJsonCount(2);
    }

    public function test_create_appointment_success(){
        $user = User::factory()->create(['role' => 'cliente']);
        $this->actingAs($user);

        $hairdresser = Hairdresser::factory()->create();
        $service = Service::factory()->create(['hairdresser_id' => $hairdresser->id]);

        $response = $this->postJson(route('dashboard.storeAppointment'), [
            'hairdresser_id' => $hairdresser->id,
            'service' => $service->id,
            'start' => now()->addDays(1)->toDateTimeString(),
            'end' => now()->addDays(1)->addHour()->toDateTimeString(),
            'status' => 'pendiente',
            'unregistered_client' => null,
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('appointments', [
            'client_id' => $user->id,
            'hairdresser_id' => $hairdresser->id,
            'service_id' => $service->id,
            'start' => now()->addDays(1)->toDateTimeString(),
            'end' => now()->addDays(1)->addHour()->toDateTimeString(),
            'status' => 'pendiente',
        ]);
    }

    public function test_create_appointment_error_time_taken(){
        $user = User::factory()->create(['role' => 'cliente']);
        $this->actingAs($user);

        $hairdresser = Hairdresser::factory()->create();
        $service = Service::factory()->create(['hairdresser_id' => $hairdresser->id]);

        Appointment::factory()->create([
            'client_id' => $user->id,
            'hairdresser_id' => $hairdresser->id,
            'service_id' => $service->id,
            'start' => now()->addDays(1)->toDateTimeString(),
            'end' => now()->addDays(1)->addHour()->toDateTimeString(),
            'status' => 'pendiente',
        ]);

        $response = $this->postJson(route('dashboard.storeAppointment'), [
            'hairdresser_id' => $hairdresser->id,
            'service' => $service->id,
            'start' => now()->addDays(1)->toDateTimeString(),
            'end' => now()->addDays(1)->addHour()->toDateTimeString(),
            'status' => 'pendiente',
            'unregistered_client' => null,
        ]);

        $response->assertStatus(400);
        $response->assertJson(['error' => 'Ya existe una cita en ese horario']);
    }

    public function test_create_appointment_validation_error(){
        $user = User::factory()->create(['role' => 'cliente']);
        $this->actingAs($user);

        $hairdresser = Hairdresser::factory()->create();
        $service = Service::factory()->create(['hairdresser_id' => $hairdresser->id]);

        $response = $this->postJson(route('dashboard.storeAppointment'), [
            'hairdresser_id' => $hairdresser->id,
            'service' => $service->id,
            'start' => now()->addDays(1)->toDateTimeString(),
            'end' => now()->addDays(1)->toDateTimeString(),
            'status' => 'pending',
            'unregistered_client' => null,
        ]);

        $response->assertStatus(400);
        $response->assertJson(['error' => 'Ha ocurrido en la validación de los datos']);
    }

    public function test_update_appointment_success(){
        $user = User::factory()->create(['role' => 'propietario']);
        $this->actingAs($user);

        $hairdresser = Hairdresser::factory()->create();
        $service = Service::factory()->create(['hairdresser_id' => $hairdresser->id]);

        $appointment = Appointment::factory()->create([
            'client_id' => $user->id,
            'hairdresser_id' => $hairdresser->id,
            'service_id' => $service->id,
            'start' => now()->addDays(1)->toDateTimeString(),
            'end' => now()->addDays(1)->addHour()->toDateTimeString(),
            'status' => 'pendiente',
        ]);

        $response = $this->postJson(route('dashboard.updateAppointment'), [
            'id_appointment' => $appointment->id,
            'service' => $service->id, 
            'start' => now()->addDays(2)->toDateTimeString(),
            'end' => now()->addDays(2)->addHour()->toDateTimeString(),
            'status' => 'confirmado',
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('appointments', [
            'id' => $appointment->id,
            'start' => now()->addDays(2)->toDateTimeString(),
            'end' => now()->addDays(2)->addHour()->toDateTimeString(),
            'status' => 'confirmado',
        ]);
    }

    public function test_update_appointment_validation_error(){
        $user = User::factory()->create(['role' => 'propietario']);
        $this->actingAs($user);

        $hairdresser = Hairdresser::factory()->create();
        $service = Service::factory()->create(['hairdresser_id' => $hairdresser->id]);

        $appointment = Appointment::factory()->create([
            'client_id' => $user->id,
            'hairdresser_id' => $hairdresser->id,
            'service_id' => $service->id,
            'start' => now()->addDays(1)->toDateTimeString(),
            'end' => now()->addDays(1)->addHour()->toDateTimeString(),
            'status' => 'pendiente',
        ]);

        $response = $this->postJson(route('dashboard.updateAppointment'), [
            'id_appointment' => $appointment->id,
            'service' => $service->id, 
            'start' => now()->addDays(2)->toDateTimeString(),
            'end' => 12324,
            'status' => 'confirmado',
        ]);

        $response->assertStatus(400);
        $response->assertJson(['error' => 'Ha ocurrido un error en la validación de los datos']);
    }

    public function test_delete_appointment_success(){
        $user = User::factory()->create(['role' => 'propietario']);
        $this->actingAs($user);

        $hairdresser = Hairdresser::factory()->create();
        $service = Service::factory()->create(['hairdresser_id' => $hairdresser->id]);

        $appointment = Appointment::factory()->create([
            'client_id' => $user->id,
            'hairdresser_id' => $hairdresser->id,
            'service_id' => $service->id,
            'start' => now()->addDays(1)->toDateTimeString(),
            'end' => now()->addDays(1)->addHour()->toDateTimeString(),
            'status' => 'pendiente',
        ]);

        $response = $this->deleteJson(route('dashboard.deleteAppointment'), ['id_appointment' => $appointment->id]);

        $response->assertStatus(200);
        $this->assertDatabaseMissing('appointments', ['id' => $appointment->id]);
    }

    public function test_delete_appointment_not_found(){
        $user = User::factory()->create(['role' => 'propietario']);
        $this->actingAs($user);

        $response = $this->deleteJson(route('dashboard.deleteAppointment'), ['id_appointment' => 1]);

        $response->assertStatus(404);
        $response->assertJson(['error' => 'Cita no encontrada']);
    }
}
