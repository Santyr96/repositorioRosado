<?php

namespace Database\Factories;

use App\Models\Hairdresser;
use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Appointment>
 */
class AppointmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
{
    return [
        'client_id' => User::factory(),
        'unregistered_client' => $this->faker->optional()->name(),
        'service_id' => Service::factory(),
        'hairdresser_id' => Hairdresser::factory(),
        'start' => $this->faker->dateTimeBetween('now', '+1 month'),
        'end' => function (array $attributes) {
            $start = $attributes['start']->format('Y-m-d H:i:s');
            return date('Y-m-d H:i:s', strtotime('+1 hour', strtotime($start)));
        },
        'status' => $this->faker->randomElement(['pendiente', 'confirmado', 'cancelado']),
    ];
}

}
