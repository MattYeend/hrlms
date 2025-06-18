<?php

namespace Database\Factories;

use App\Models\LearningMaterial;
use App\Models\LearningMaterialUser;
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
        $status = $this->faker->randomElement([
            LearningMaterialUser::NOT_STARTED,
            LearningMaterialUser::STARTED,
            LearningMaterialUser::IN_PROGRESS,
            LearningMaterialUser::COMPLETED,
        ]);
        
        $completedAt = $status === LearningMaterialUser::NOT_STARTED 
            ? null 
            : $this->faker->dateTimeBetween('-1 year', 'now');
        
        return [
            'learning_material_id' => LearningMaterial::inRandomOrder()->first()?->id,
            'user_id' => User::inRandomOrder()->first()?->id,
            'status' => $status,
            'completed_at' => $completedAt,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
