<?php

namespace Database\Factories;

use App\Models\Hairdresser;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Signup>
 */
class SignupFactory extends Factory
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
            'hairdresser_id' => Hairdresser::factory(), 
        ];
    }
}
