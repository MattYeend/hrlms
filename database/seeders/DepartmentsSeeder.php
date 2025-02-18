<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class DepartmentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $departments = [
            ['name' => 'C Suite', 'lead_id' => null, 'created_by' => null, 'updated_by' => null, 'deleted_by' => null, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Human Resources', 'lead_id' => null, 'created_by' => null, 'updated_by' => null, 'deleted_by' => null, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Finance', 'lead_id' => null, 'created_by' => null, 'updated_by' => null, 'deleted_by' => null, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Accounting', 'lead_id' => null, 'created_by' => null, 'updated_by' => null, 'deleted_by' => null, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Marketing', 'lead_id' => null, 'created_by' => null, 'updated_by' => null, 'deleted_by' => null, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Sales', 'lead_id' => null, 'created_by' => null, 'updated_by' => null, 'deleted_by' => null, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Customer Service', 'lead_id' => null, 'created_by' => null, 'updated_by' => null, 'deleted_by' => null, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Information Technology', 'lead_id' => null, 'created_by' => null, 'updated_by' => null, 'deleted_by' => null, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Operations', 'lead_id' => null, 'created_by' => null, 'updated_by' => null, 'deleted_by' => null, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Research And Development', 'lead_id' => null, 'created_by' => null, 'updated_by' => null, 'deleted_by' => null, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Legal', 'lead_id' => null, 'created_by' => null, 'updated_by' => null, 'deleted_by' => null, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Public Relations', 'lead_id' => null, 'created_by' => null, 'updated_by' => null, 'deleted_by' => null, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Purchasing', 'lead_id' => null, 'created_by' => null, 'updated_by' => null, 'deleted_by' => null, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Quality Assurance', 'lead_id' => null, 'created_by' => null, 'updated_by' => null, 'deleted_by' => null, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Compliance', 'lead_id' => null, 'created_by' => null, 'updated_by' => null, 'deleted_by' => null, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Facilities Management', 'lead_id' => null, 'created_by' => null, 'updated_by' => null, 'deleted_by' => null, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Product Management', 'lead_id' => null, 'created_by' => null, 'updated_by' => null, 'deleted_by' => null, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Project Management', 'lead_id' => null, 'created_by' => null, 'updated_by' => null, 'deleted_by' => null, 'created_at' => now(), 'updated_at' => now()]
        ];

        // Insert the departments
        DB::table('departments')->insert($departments);
    }
}
