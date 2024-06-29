<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TradeLicenseApplication;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(287)->create();

        //create 5 users with 5 trade license applications each
        // User::factory(7)->create();

        TradeLicenseApplication::factory(100)->create();
    }
}
