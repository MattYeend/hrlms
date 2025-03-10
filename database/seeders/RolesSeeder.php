<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roles')->insert([
            [
                'name' => 'Super Admin', 
                'created_by' => null, 
                'updated_by' => null, 
                'deleted_by' => null, 
                'created_at' => now(), 
                'updated_at' => now()
            ],
            [
                'name' => 'Admin', 
                'created_by' => null, 
                'updated_by' => null, 
                'deleted_by' => null, 
                'created_at' => now(), 
                'updated_at' => now()
            ],
            [
                'name' => 'User', 
                'created_by' => null, 
                'updated_by' => null, 
                'deleted_by' => null, 
                'created_at' => now(), 
                'updated_at' => now()
            ],
        ]);
    }
}
