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
        $now = Carbon::now();

        $users = [
            [
                'title' => 'Mr',
                'name' => 'Matthew Yeend',
                'email' => 'superadmin@example.com',
                'email_verified_at' => $now,
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
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        $extraUsers = [
            ['Miss', 'Emma', 'Wilson', 'emma.wilson@example.com', 2, 2],
            ['Mr', 'Liam', 'Johnson', 'liam.johnson@example.com', 3, 3],
            ['Mrs', 'Sophia', 'Turner', 'sophia.turner@example.com', 3, 4],
            ['Ms', 'Olivia', 'Green', 'olivia.green@example.com', 3, 5],
            ['Mr', 'Noah', 'Walker', 'noah.walker@example.com', 3, 6],
            ['Mrs', 'Ava', 'Martin', 'ava.martin@example.com', 3, 7],
            ['Mr', 'William', 'King', 'william.king@example.com', 3, 2],
            ['Miss', 'Isabella', 'Scott', 'isabella.scott@example.com', 2, 3],
            ['Mr', 'James', 'White', 'james.white@example.com', 3, 4],
            ['Miss', 'Mia', 'Baker', 'mia.baker@example.com', 3, 5],
            ['Mr', 'Lucas', 'Reed', 'lucas.reed@example.com', 2, 6],
            ['Mrs', 'Amelia', 'Wright', 'amelia.wright@example.com', 3, 7],
        ];

        foreach ($extraUsers as $index => [$title, $first, $last, $email, $roleId, $deptId]) {
            $users[] = [
                'title' => "$title",
                'name' => "$first $last",
                'email' => $email,
                'email_verified_at' => $now,
                'password' => Hash::make('password'),
                'first_line' => '456 Example Lane',
                'second_line' => '',
                'town' => 'Townsville',
                'city' => 'Sampleton',
                'county' => 'Countyshire',
                'country' => 'UK',
                'post_code' => 'EX' . str_pad($index + 1, 4, '0', STR_PAD_LEFT),
                'full_time' => true,
                'part_time' => false,
                'role_id' => $roleId,
                'department_id' => $deptId,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        User::insert($users);
    }
}
