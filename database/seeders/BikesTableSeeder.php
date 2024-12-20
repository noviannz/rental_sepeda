<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BikesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('bikes')->insert([
            ['bike_code' => 'BK001', 'status' => 'available', 'location' => 'Station A'],
            ['bike_code' => 'BK002', 'status' => 'available', 'location' => 'Station B'],
            ['bike_code' => 'BK003', 'status' => 'maintenance', 'location' => 'Station C'],
        ]);
    }
}
