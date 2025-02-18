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
            'title' => $this->faker->title,
            'first_name' => $this->faker->firstName,
            'middle_name' => $this->faker->randomElement([null, $this->faker->firstName]),
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'phone_number' => $this->faker->phoneNumber,
            'salary' => $this->faker->numberBetween(30000, 120000),
            'first_line' => $this->faker->streetAddress,
            'second_line' => $this->faker->optional()->secondaryAddress,
            'town' => $this->faker->city,
            'city' => $this->faker->city,
            'county' => $this->faker->state,
            'country' => $this->faker->country,
            'post_code' => $this->faker->postcode,
            'full_or_part' => $this->faker->randomElement(['Full-time', 'Part-time']),
            'region' => $this->faker->randomElement(['North America', 'Europe', 'Asia']),
            'timezone' => $this->faker->timezone,
            'start_date' => $this->faker->date,
            'end_date' => $this->faker->optional()->date,
            'office_based' => $this->faker->randomElement([1, 0]),
            'remote_based' => $this->faker->randomElement([1, 0]),
            'hybrid_based' => $this->faker->randomElement([1, 0]),
            'is_live' => true,
            'created_by' => null,
            'remember_token' => Str::random(10),
            'department_id' => $this->faker->randomElement([2, 17]),
            'job_title_id' => $this->faker->randomElement([2, 52]),
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
