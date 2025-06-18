<?php

namespace Database\Factories;

use App\Models\LearningMaterial;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LearningMaterialUser>
 */
class LearningMaterialUserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $completedAt = $this->faker->optional(0.8)->dateTimeBetween('-1 year', 'now');

        return [
            'learning_material_id' => LearningMaterial::inRandomOrder()->first()?->id,
            'user_id' => User::inRandomOrder()->first()?->id,
            'completed_at' => $completedAt,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
