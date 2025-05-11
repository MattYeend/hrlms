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
        return [
            'title' => fake()->title(),
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'first_line' => fake()->streetAddress(),
            'second_line' => fake()->optional()->secondaryAddress(),
            'town' => fake()->city(),
            'city' => fake()->city(),
            'county' => fake()->state(),
            'country' => fake()->country(),
            'post_code' => fake()->postcode(),
            'full_time' => fake()->boolean(70),
            'part_time' => fake()->boolean(30),
            'role_id' => 1,
            'department_id' => 1,
            'created_by' => 1,
            'updated_by' => 1,
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
