<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Hairdresser>
 */
class HairdresserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'cif' => $this->faker->unique()->regexify('[A-Z]{1}[0-9]{8}'), 
            'name' => $this->faker->company, 
            'address' => $this->faker->address, 
            'phone' => $this->faker->unique()->numerify('9########'), 
            'owner_id' => User::factory(), 
        ];
    }
}
