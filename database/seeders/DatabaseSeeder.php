<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            ExchangesSeeder::class,
            ActivitiesSeeder::class,
            LocationsSeeder::class,
            defaultThemes::class,
        ]);
    }
}
