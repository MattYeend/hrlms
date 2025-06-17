<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\LearningMaterial;
use App\Models\LearningProvider;

class LearningMaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (LearningProvider::count() === 0) {
            $this->call(LearningProviderSeeder::class);
        }

        LearningMaterial::factory()->count(10)->create();
    }
}
