<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MachineLogsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('machine_logs')->insert([
            ['bike_id' => 1, 'station_id' => 1, 'log_time' => now(), 'event' => 'rental_started'],
            ['bike_id' => 2, 'station_id' => 2, 'log_time' => now(), 'event' => 'returned'],
        ]);
    }
}
