<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Exchange;
use Carbon\Carbon;

class ExchangesSeeder extends Seeder
{
    public function run(): void
    {
        Exchange::create([
            'title' => 'Intercanvi Cendrassos - Itàlia 2026',
            'user_id' => 1,
            'color' => '#10b981',
            'origin' => 'INS Cendrassos (Figueres)',
            'destiny' => 'Milà, Itàlia',
            'start_date' => Carbon::now()->addDays(10)->setTime(9, 0),
            'end_date' => Carbon::now()->addDays(17)->setTime(18, 0),
        ]);

        Exchange::create([
            'title' => 'Intercanvi Cendrassos - Alemanya',
            'user_id' => 1,
            'color' => '#6366f1',
            'origin' => 'INS Cendrassos (Figueres)',
            'destiny' => 'Berlin, Alemanya',
            'start_date' => Carbon::now()->addDays(30)->setTime(8, 30),
            'end_date' => Carbon::now()->addDays(36)->setTime(17, 0),
        ]);

        Exchange::create([
            'title' => 'Intercanvi Lycée Victor Hugo - Cendrassos',
            'user_id' => 1,
            'color' => '#facc15',
            'origin' => 'Lycée Victor Hugo (París, França)',
            'destiny' => 'INS Cendrassos (Figueres)',
            'start_date' => Carbon::now()->addDays(50)->setTime(10, 0),
            'end_date' => Carbon::now()->addDays(58)->setTime(19, 0),
        ]);
    }
}
