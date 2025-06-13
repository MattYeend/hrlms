<?php

namespace Database\Factories;

use App\Models\Quiz;
use App\Models\User;
use App\Models\LearningProvider;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Quiz>
 */
class QuizFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = $this->faker->sentence(4);
        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'description' => $this->faker->paragraph,
            'pass_percentage' => $this->faker->randomFloat(2, 50, 100),
            'learning_provider_id' => LearningProvider::inRandomOrder()->first()?->id,
            'is_archived' => $this->faker->boolean(10), // 10% archived
            'created_by' => User::inRandomOrder()->first()?->id,
            'updated_by' => User::inRandomOrder()->first()?->id,
            'deleted_by' => null,
            'restored_by' => null,
            'restored_at' => null,
        ];
    }
}
