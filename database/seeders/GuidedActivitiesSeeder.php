<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\GuidedActivity;

class GuidedActivitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        GuidedActivity::create([
            'title' => 'Ruta daliniana pel centre de Figueres',
            'description' => 'Descobreix els espais més emblemàtics de Figueres relacionats amb Salvador Dalí, recorrent els carrers del centre històric i la seva influència artística.',
            'start_date' => now()->addDays(2)->setTime(10, 0),
            'end_date' => now()->addDays(2)->setTime(12, 0),
        ]);

        GuidedActivity::create([
            'title' => 'Visita al Teatre-Museu Dalí',
            'description' => 'Una experiència immersiva dins del món surrealista de Dalí al seu museu més icònic, amb explicacions guiades sobre les seves obres més importants.',
            'start_date' => now()->addDays(4)->setTime(11, 0),
            'end_date' => now()->addDays(4)->setTime(13, 0),
        ]);

        GuidedActivity::create([
            'title' => 'Passeig cultural pel castell de Sant Ferran',
            'description' => 'Explora una de les fortaleses més grans d’Europa i descobreix la història militar i patrimonial de Figueres amb una visita guiada.',
            'start_date' => now()->addDays(7)->setTime(16, 0),
            'end_date' => now()->addDays(7)->setTime(18, 0),
        ]);
        GuidedActivity::create([
            'title' => 'Punt d’interès: Parc Güell',
            'description' => 'Visita lliure a un dels parcs més icònics de Barcelona amb vistes espectaculars.',
            'start_date' => now()->addDays(7)->setTime(16, 0),
            'end_date' => now()->addDays(7)->setTime(18, 0),
            'latitude' => '41.4145',
            'longitude' => '2.1527',
            'file' => 'https://media-cdn.tripadvisor.com/media/attractions-splice-spp-674x446/0a/c8/c9/f2.jpg',
        ]);
    }
}
