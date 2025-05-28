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
                // 'department_id' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        $extraUsers = [
            ['Miss', 'Emma', 'Wilson', 'emma.wilson@example.com', 2],
            ['Mr', 'Liam', 'Johnson', 'liam.johnson@example.com', 3],
            ['Mrs', 'Sophia', 'Turner', 'sophia.turner@example.com', 3],
            ['Ms', 'Olivia', 'Green', 'olivia.green@example.com', 3],
            ['Mr', 'Noah', 'Walker', 'noah.walker@example.com', 3],
            ['Mrs', 'Ava', 'Martin', 'ava.martin@example.com', 3],
            ['Mr', 'William', 'King', 'william.king@example.com', 3],
            ['Miss', 'Isabella', 'Scott', 'isabella.scott@example.com', 2],
            ['Mr', 'James', 'White', 'james.white@example.com', 3],
            ['Miss', 'Mia', 'Baker', 'mia.baker@example.com', 3],
            ['Mr', 'Lucas', 'Reed', 'lucas.reed@example.com', 2],
            ['Mrs', 'Amelia', 'Wright', 'amelia.wright@example.com', 3],
        ];

        foreach ($extraUsers as $index => [$title, $first, $last, $email, $roleId]) {
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
                // 'department_id' => $deptId,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        User::insert($users);

        $updates = [
            'superadmin@example.com' => 1,
            'emma.wilson@example.com' => 2,
            'liam.johnson@example.com' => 3,
            'sophia.turner@example.com' => 4,
            'olivia.green@example.com' => 5,
            'noah.walker@example.com' => 6,
            'ava.martin@example.com' => 7,
            'william.king@example.com' => 2, 
            'isabella.scott@example.com' => 3,
            'james.white@example.com' => 4,
            'mia.baker@example.com' => 5,
            'lucas.reed@example.com' => 6,
            'amelia.wright@example.com' => 7,
        ];
        foreach ($updates as $email => $deptId) {
            User::where('email', $email)->update(['department_id' => $deptId]);
        }

        DB::table('departments')->where('id', 1)->update(['dept_lead' => 1]);
        DB::table('departments')->where('id', 2)->update(['dept_lead' => 1]);
        DB::table('departments')->where('id', 3)->update(['dept_lead' => 1]);
        DB::table('departments')->where('id', 4)->update(['dept_lead' => 1]);
        DB::table('departments')->where('id', 5)->update(['dept_lead' => 1]);
        DB::table('departments')->where('id', 6)->update(['dept_lead' => 1]);
        DB::table('departments')->where('id', 7)->update(['dept_lead' => 1]);
    }
}
