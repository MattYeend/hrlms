<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserJobs>
 */
class UserJobFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'job_title' => fake()->jobTitle(),
            'slug' => Str::slug(fake()->jobTitle()),
            'short_code' => Str::upper(fake()->unique()->lexify('????')),
            'description' => fake()->paragraph(),
            'department_id' => 1,
            'created_by' => 1,
            'updated_by' => 1,
        ];
    }
}
