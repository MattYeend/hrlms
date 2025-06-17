<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            RoleSeeder::class,
            DepartmentSeeder::class,
            UserJobSeeder::class,
            UserSeeder::class,
            BlogSeeder::class,
            BusinessTypeSeeder::class,
            LearningProviderSeeder::class,
            QuizSeeder::class,
            QuizUserSeeder::class,
            LearningMaterialSeeder::class,
            // Add other seeders here
        ]);
    }
}
