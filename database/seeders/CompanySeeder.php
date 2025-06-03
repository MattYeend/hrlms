<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Faker\Factory as Faker;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $now = Carbon::now();
        $companies = [];

        for ($i = 0; $i < 5; $i++) {
            $name = $faker->company;

            $companies[] = [
                'name' => $name,
                'slug' => Str::slug($name),
                'first_line' => $faker->streetAddress,
                'second_line' => $faker->secondaryAddress,
                'town' => $faker->city,
                'city' => $faker->city,
                'county' => $faker->state,
                'country' => $faker->country,
                'postcode' => $faker->postcode,
                'phone' => $faker->phoneNumber,
                'email' => $faker->companyEmail,
                'is_default' => false,
                'is_archived' => false,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        DB::table('companies')->insert($companies);
    }
}
