<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('departments')->insert([
            [
                'name' => 'Human Resources',
                'slug' => Str::slug('Human Resources'),
                'description' => 'Handles employee relations and hiring.',
                'company_id' => 1,
                'is_active' => true,
                'is_default' => true,
                'created_by' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'IT Department',
                'slug' => Str::slug('IT Department'),
                'description' => 'Manages technology and support.',
                'company_id' => 1,
                'is_active' => true,
                'is_default' => false,
                'created_by' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Finance',
                'slug' => Str::slug('Finance'),
                'description' => 'Oversees budgeting, accounting, and financial reporting.',
                'company_id' => 1,
                'is_active' => true,
                'is_default' => false,
                'created_by' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Marketing',
                'slug' => Str::slug('Marketing'),
                'description' => 'Handles advertising, branding, and promotions.',
                'company_id' => 1,
                'is_active' => true,
                'is_default' => false,
                'created_by' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Sales',
                'slug' => Str::slug('Sales'),
                'description' => 'Drives revenue through client acquisition and relationships.',
                'company_id' => 1,
                'is_active' => true,
                'is_default' => false,
                'created_by' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Customer Support',
                'slug' => Str::slug('Customer Support'),
                'description' => 'Provides assistance to customers and resolves issues.',
                'company_id' => 1,
                'is_active' => true,
                'is_default' => false,
                'created_by' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
