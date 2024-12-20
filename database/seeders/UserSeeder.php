<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Seeder sesuai dengan ERD dengan plain_token untuk API
        DB::table('users')->insert([
            'id' => 1,
            'name' => 'Administrator',
            'email' => 'admin@melon.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'plain_token' => Str::random(60),
        ]);

        DB::table('users')->insert([
            'id' => 2,
            'name' => 'Administrator',
            'email' => 'admin@apel.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'plain_token' => Str::random(60),
        ]);

        DB::table('users')->insert([
            'id' => 3,
            'name' => 'User',
            'email' => 'user1@melon.com',
            'password' => Hash::make('admin123'),
            'role' => 'user',
            'plain_token' => Str::random(60),
        ]);
    }
}
