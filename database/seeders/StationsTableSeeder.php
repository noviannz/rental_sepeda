<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StationsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('stations')->insert([
            ['station_name' => 'Station A', 'location' => 'Location A', 'capacity' => 20],
            ['station_name' => 'Station B', 'location' => 'Location B', 'capacity' => 15],
            ['station_name' => 'Station C', 'location' => 'Location C', 'capacity' => 25],
        ]);
    }
}
