<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Company>
 */
class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'slug' => Str::slug($this->faker->name),
            'first_line' => $this->faker->streetAddress,
            'second_line' => $this->faker->secondaryAddress,
            'town' => $this->faker->city,
            'city' => $this->faker->city,
            'county' => $this->faker->state,
            'country' => $this->faker->country,
            'postcode' => $this->faker->postcode,
            'phone' => $this->faker->phoneNumber,
            'email' => $this->faker->companyEmail,
            'is_default' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
