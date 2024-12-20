<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('payments')->insert([
            ['rental_id' => 1, 'payment_time' => now(), 'amount' => 20000, 'payment_type' => 'credit_card', 'status' => 'completed'],
        ]);
    }
}
