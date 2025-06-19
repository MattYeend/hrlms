<?php

namespace Database\Factories;

use App\Models\LearningMaterial;
use App\Models\User;
use App\Models\LearningMaterialUser;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LearningMaterialUser>
 */
class LearningMaterialUserFactory extends Factory // Ensure the LearningMaterialUser model is defined in App\Models
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $status = $this->faker->randomElement([
            LearningMaterialUser::STATUS_NOT_STARTED,
            LearningMaterialUser::STATUS_STARTED,
            LearningMaterialUser::STATUS_IN_PROGRESS,
            LearningMaterialUser::STATUS_COMPLETED,
        ]);
        
        $completedAt = $status === LearningMaterialUser::STATUS_NOT_STARTED 
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
