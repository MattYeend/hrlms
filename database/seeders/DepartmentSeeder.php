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
                'is_default' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'dept_lead' => 1,
            ],
            [
                'name' => 'IT Department',
                'slug' => Str::slug('IT Department'),
                'description' => 'Manages technology and support.',
                'is_default' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'dept_lead' => 1,
            ],
            [
                'name' => 'Finance',
                'slug' => Str::slug('Finance'),
                'description' => 'Oversees budgeting, accounting, and financial reporting.',
                'is_default' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'dept_lead' => 1,
            ],
            [
                'name' => 'Marketing',
                'slug' => Str::slug('Marketing'),
                'description' => 'Handles advertising, branding, and promotions.',
                'is_default' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'dept_lead' => 1,
            ],
            [
                'name' => 'Sales',
                'slug' => Str::slug('Sales'),
                'description' => 'Drives revenue through client acquisition and relationships.',
                'is_default' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'dept_lead' => 1,
            ],
            [
                'name' => 'Customer Support',
                'slug' => Str::slug('Customer Support'),
                'description' => 'Provides assistance to customers and resolves issues.',
                'is_default' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'dept_lead' => 1,
            ],
        ]);
    }
}
