<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Exchange;

class ExchangesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Exchange::create([
            'title' => 'Intercanvi Cendrassos - Itàlia 2026',
            'color' => '#10b981',
            'origin' => 'INS Cendrassos (Figueres)',
            'destiny' => 'Milà, Itàlia',
            'start_date' => now()->addDays(10)->setTime(9, 0),
            'end_date' => now()->addDays(20)->setTime(18, 0),
        ]);

        Exchange::create([
            'title' => 'Intercanvi Cendrassos - Alemanya',
            'color' => '#6366f1',
            'origin' => 'INS Cendrassos (Figueres)',
            'destiny' => 'Berlin, Alemanya',
            'start_date' => now()->addDays(30)->setTime(8, 30),
            'end_date' => now()->addDays(40)->setTime(17, 0),
        ]);

        Exchange::create([
            'title' => 'Intercanvi Lycée Victor Hugo - Cendrassos',
            'color' => '#facc15',
            'origin' => 'Lycée Victor Hugo (París, França)',
            'destiny' => 'INS Cendrassos (Figueres)',
            'start_date' => now()->addDays(50)->setTime(10, 0),
            'end_date' => now()->addDays(60)->setTime(19, 0),
        ]);
    }
}
