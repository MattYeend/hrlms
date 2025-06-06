<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Blog>
 */
class BlogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->name(),
            'slug' => Str::slug(fake()->unique()->name()),
            'content' => fake()->paragraph(),
            'approved' => 1,
            'approved_by' => 1,
            'approved_at' => now(),
            'created_by' => 1,
            'created_at' => now(),
            'updated_by' => 1,
            'updated_at' => now(),
        ];
    }
}
