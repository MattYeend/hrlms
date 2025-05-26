<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();

        DB::table('companies')->insert([
            [
                'name' => $name = $faker->company,
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
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);
    }
}
