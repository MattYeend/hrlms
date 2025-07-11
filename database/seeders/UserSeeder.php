<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        $jobMap = DB::table('user_jobs')->pluck('id', 'job_title');
        $deptMap = DB::table('departments')->pluck('id', 'name');

        $users = [
            [
                'title' => 'Mr',
                'name' => 'Matthew Yeend',
                'email' => 'superadmin@example.com',
                'email_verified_at' => $now,
                'password' => Hash::make('password'),
                'slug' => Str::slug('Matthew Yeend'),
                'first_line' => '123 Admin Street',
                'second_line' => 'Suite 100',
                'town' => 'Adminville',
                'city' => 'Admin City',
                'county' => 'Adminshire',
                'country' => 'Adminland',
                'post_code' => 'AD1234',
                'full_time' => true,
                'part_time' => false,
                'is_archived' => false,
                'role_id' => 1,
                'department_id' => $deptMap['C Suite'],
                'job_id' => $jobMap['Chief Executive Officer'],
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        $extraUsers = [
            ['Miss', 'Emma', 'Wilson', 'emma.wilson@example.com', 2, 'Human Resources', 'HR Administrator'],
            ['Mr', 'Liam', 'Johnson', 'liam.johnson@example.com', 3, 'Finance', 'Accountant'],
            ['Mrs', 'Sophia', 'Turner', 'sophia.turner@example.com', 3, 'Marketing', 'Digital Marketing Manager'],
            ['Ms', 'Olivia', 'Green', 'olivia.green@example.com', 3, 'Sales', 'Sales Representative'],
            ['Mr', 'Noah', 'Walker', 'noah.walker@example.com', 3, 'IT Department', 'Data Analyst'],
            ['Mrs', 'Ava', 'Martin', 'ava.martin@example.com', 3, 'IT Department', 'Systems Administrator'],
            ['Mr', 'William', 'King', 'william.king@example.com', 3, 'Human Resources', 'Employee Relations Manager'],
            ['Miss', 'Isabella', 'Scott', 'isabella.scott@example.com', 2, 'Finance', 'Accountant'],
            ['Mr', 'James', 'White', 'james.white@example.com', 3, 'Marketing', 'SEO Specialist'],
            ['Miss', 'Mia', 'Baker', 'mia.baker@example.com', 3, 'Sales', 'Sales Director'],
            ['Mr', 'Lucas', 'Reed', 'lucas.reed@example.com', 2, 'IT Department', 'Systems Administrator'],
            ['Mrs', 'Amelia', 'Wright', 'amelia.wright@example.com', 3, 'Sales', 'Business Development Manager'],
        ];

        foreach ($extraUsers as $index => [$title, $first, $last, $email, $roleId, $deptName, $jobTitle]) {
            $users[] = [
                'title' => $title,
                'name' => "$first $last",
                'email' => $email,
                'email_verified_at' => $now,
                'password' => Hash::make('password'),
                'slug' => Str::slug("$first $last"),
                'first_line' => '456 Example Lane',
                'second_line' => '',
                'town' => 'Townsville',
                'city' => 'Sampleton',
                'county' => 'Countyshire',
                'country' => 'UK',
                'post_code' => 'EX' . str_pad($index + 1, 4, '0', STR_PAD_LEFT),
                'full_time' => true,
                'part_time' => false,
                'is_archived' => false,
                'role_id' => $roleId,
                'department_id' => $deptMap[$deptName] ?? null,
                'job_id' => $jobMap[$jobTitle] ?? null,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        User::insert($users);

        DB::table('departments')->update(['dept_lead' => 1]);
    }
}
