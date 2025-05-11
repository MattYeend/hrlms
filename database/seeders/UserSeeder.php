<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::insert([
            [
                'title' => 'Mr',
                'name' => 'Matthew Yeend',
                'email' => 'superadmin@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password'), 
                'first_line' => '123 Admin Street',
                'second_line' => 'Suite 100',
                'town' => 'Adminville',
                'city' => 'Admin City',
                'county' => 'Adminshire',
                'country' => 'Adminland',
                'post_code' => 'AD1234',
                'full_time' => true,
                'part_time' => false,
                'role_id' => 1, 
                'department_id' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
