<?php

namespace Database\Seeders;

use App\Models\Locations;
use Illuminate\Database\Seeder;

class LocationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Locations::create([
            'name' => 'Teatre-Museu Dalí',
            'description' => 'Museu dedicat a Salvador Dalí, principal atracció de Figueres.',
            'latitude' => 42.2676,
            'longitude' => 2.9606,
            'activity_id' => 1,
        ]);

        Locations::create([
            'name' => 'Castell de Sant Ferran',
            'description' => 'Gran fortalesa del segle XVIII amb vistes panoràmiques.',
            'latitude' => 42.2752,
            'longitude' => 2.9553,
            'activity_id' => 1,
        ]);

        Locations::create([
            'name' => 'La Rambla de Figueres',
            'description' => 'Zona cèntrica amb botigues, bars i ambient local.',
            'latitude' => 42.2669,
            'longitude' => 2.9633,
            'activity_id' => 1,
        ]);

        Locations::create([
            'name' => 'Museu del Joguet de Catalunya',
            'description' => 'Museu del joguet amb una col·lecció històrica.',
            'latitude' => 42.2672,
            'longitude' => 2.9629,
            'activity_id' => 1,
        ]);

        Locations::create([
            'name' => 'Església de Sant Pere',
            'description' => 'Església històrica on va ser batejat Dalí.',
            'latitude' => 42.2675,
            'longitude' => 2.9612,
            'activity_id' => 1,
        ]);
    }
}
