<?php

namespace Database\Factories;

use App\Models\Hairdresser;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Service>
 */
class ServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word(), 
            'description' => $this->faker->sentence(10), 
            'price' => $this->faker->randomFloat(2, 10, 200), 
            'hairdresser_id' => Hairdresser::factory(), 
        ];
    }
}
