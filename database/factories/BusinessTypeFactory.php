<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BusinessType>
 */
class BusinessTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->unique()->companySuffix;
        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'short_code' => strtoupper(Str::random(4)),
            'created_by' => null,
            'updated_by' => null,
            'deleted_by' => null,
        ];
    }
}
