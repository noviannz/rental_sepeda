<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Wallet;

class WalletsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
        public function run()
    {
        Wallet::create([
            'user_id' => 1, // ID admin atau user
            'balance' => 100000,
            'last_updated' => now(),
        ]);

        Wallet::create([
            'user_id' => 2, // ID user kedua
            'balance' => 50000,
            'last_updated' => now(),
        ]);
    }
    }
