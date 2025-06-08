<?php

namespace Database\Factories;

use App\Models\BusinessType;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LearningProvider>
 */
class LearningProviderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->unique()->company;
        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'business_type_id' => BusinessType::inRandomOrder()->first()?->id ?? BusinessType::factory(),
            'first_line' => $this->faker->streetAddress,
            'second_line' => $this->faker->optional()->secondaryAddress,
            'town' => $this->faker->city,
            'city' => $this->faker->city,
            'county' => $this->faker->state,
            'country' => $this->faker->country,
            'postcode' => $this->faker->postcode,
            'main_email_address' => $this->faker->unique()->safeEmail,
            'first_phone_number' => $this->faker->phoneNumber,
            'second_phone_number' => $this->faker->optional()->phoneNumber,
            'person_to_contact' => $this->faker->name,
            'is_archived' => false,
            'created_by' => null,
            'updated_by' => null,
            'deleted_by' => null,
        ];
    }
}
