<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $this->faker->unique(true);
        return [
            'name' => 'John Doe',  
            'email' => $this->faker->unique()->safeEmail,  
            'phone' => '123456789',  
            'dni' => $this->faker->unique()->numerify('#########'),  
            'sex' => 'masculino',  
            'role' => 'cliente',  
            'password' => bcrypt('Password123$'),  
            'email_verified_at' => now(),  
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
