<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superAdminRoleId = DB::table('roles')->where('name', 'Super Admin')->first()->id;
        $adminRoleId = DB::table('roles')->where('name', 'Admin')->first()->id;
        $userRoleId = DB::table('roles')->where('name', 'User')->first()->id;

        User::create([
            'title' => 'Mr',
            'first_name' => 'John',
            'middle_name' => 'A',
            'last_name' => 'Doe',
            'email' => 'superadmin@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'phone_number' => '1234567890',
            'profile_picture' => null,
            'cv_path' => null,
            'cover_letter_path' => null,
            'salary' => 100000,
            'first_line' => '123 Main St',
            'second_line' => 'Apt 4B',
            'town' => 'Springfield',
            'city' => 'New York',
            'county' => 'New York County',
            'country' => 'USA',
            'post_code' => '10001',
            'full_or_part' => 'Full-time',
            'region' => 'North America',
            'timezone' => 'America/New_York',
            'start_date' => now(),
            'end_date' => null,
            'office_based' => 1,
            'remote_based' => 0,
            'hybrid_based' => 0,
            'is_live' => true,
            'role_id' => $superAdminRoleId,
            'department_id' => 1,
            'job_title_id' => 1,
            'created_by' => null,
            'updated_by' => null,
            'deleted_by' => null,
            'remember_token' => Str::random(10),
        ]);

        User::factory()->count(5)->create([
            'role_id' => $adminRoleId,
            'department_id' => 2,
            'job_title_id' => 2,
        ]);

        User::factory()->count(50)->create([
            'role_id' => $userRoleId,
        ]);
    }
}
