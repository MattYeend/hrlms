<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roles')->insert([
            [
                'name' => 'Super Admin',
                'slug' => 'super-admin',
                'description' => 'Has unlimited access to all system features and settings.',
                'is_active' => true,
                'is_default' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Admin',
                'slug' => 'admin',
                'description' => 'Manages most areas of the system but with some restrictions.',
                'is_active' => true,
                'is_default' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'User',
                'slug' => 'user',
                'description' => 'Standard user role with limited permissions.',
                'is_active' => true,
                'is_default' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
