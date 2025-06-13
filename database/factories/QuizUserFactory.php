<?php

namespace Database\Factories;

use App\Models\Quiz;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\QuizUser>
 */
class QuizUserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $completedAt = $this->faker->optional(0.8)->dateTimeBetween('-1 year', 'now');

        $score = $completedAt ? $this->faker->randomFloat(2, 0, 100) : null;
        $passed = $score !== null ? ($score >= 50) : false;

        return [
            'quiz_id' => Quiz::inRandomOrder()->first()?->id,
            'user_id' => User::inRandomOrder()->first()?->id,
            'completed_at' => $completedAt,
            'score' => $score,
            'passed' => $passed,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
