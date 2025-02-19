<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User; 

class LeadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = DB::table('departments')->get();

        foreach ($departments as $department) {
            $user = User::inRandomOrder()->first();

            if ($user) {
                DB::table('departments')
                    ->where('id', $department->id)
                    ->update(['lead_id' => $user->id, 'updated_at' => now()]);
            }
        }
    }
}
