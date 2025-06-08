<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\LearningProvider;
use App\Models\BusinessType;

class LearningProviderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (BusinessType::count() === 0) {
            $this->call(BusinessTypeSeeder::class);
        }

        LearningProvider::factory()->count(10)->create();
    }
}
