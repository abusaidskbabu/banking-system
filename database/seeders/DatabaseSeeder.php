<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Business',
            'account_type' => 'Business',
            'email' => 'Business@gmail.com',
            'password' => Hash::make('password'),
            'balance' => 0.00,
        ]);

        DB::table('users')->insert([
            'name' => 'Individual',
            'account_type' => 'Individual',
            'email' => 'Individual@gmail.com',
            'password' => Hash::make('password'),
            'balance' => 0.00,
        ]);
    }
}
