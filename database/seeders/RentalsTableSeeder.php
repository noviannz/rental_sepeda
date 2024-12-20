<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RentalsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('rentals')->insert([
            ['user_id' => 2, 'bike_id' => 1, 'start_time' => now(), 'end_time' => null, 'amount_deducted' => null, 'status' => 'ongoing'],
        ]);
    }
}
