<?php

namespace Database\Factories;

use App\Models\Department;
use App\Models\LearningProvider;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LearningMaterial>
 */
class LearningMaterialFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = $this->faker->unique()->name;
        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'key_objectives' => $this->faker->paragraph(), 
            'description' => $this->faker->paragraph(),
            'file_path' => $this->faker->optional()->filePath(),
            'url' => $this->faker->optional()->url(),
            'learning_provider_id' => LearningProvider::inRandomOrder()->first()?->id ?? LearningProvider::factory(),
            'department_id' => Department::inRandomOrder()->first()?->id ?? Department::factory(),
            'is_archived' => false,
            'created_by' => null,
            'updated_by' => null,
            'deleted_by' => null,
        ];
    }
}
