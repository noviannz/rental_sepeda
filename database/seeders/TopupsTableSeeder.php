<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TopupsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('topups')->insert([
            ['user_id' => 1, 'topup_amount' => 50000, 'topup_time' => now(), 'status' => 'completed'],
            ['user_id' => 2, 'topup_amount' => 30000, 'topup_time' => now(), 'status' => 'completed'],
        ]);
    }
}
