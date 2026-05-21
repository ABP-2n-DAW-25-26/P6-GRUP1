<?php

namespace Database\Seeders;

use App\Models\Activity;
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

        $gimcanaTitles = [
            'Gimcana de Devs',
            'Castell Sforzesco',
            'Gimcana del centre historic de Mila',
            'Gimcana del barri de Brera',
            'Gimcana historica de Mitte',
            'Gimcana del riu Spree',
            'Gimcana del Marais',
            'Gimcana per l\'Ile de la Cite',
            'Gimcana del barri de Baixa',
            'Gimcana de miradors',
            'Gimcana del centre de Dublin',
            'Gimcana del riu Liffey',
        ];

        $figueresLocations = [
            [
                'name' => 'Teatre-Museu Dalí',
                'description' => 'Museu dedicat a Salvador Dalí, principal atracció de Figueres.',
                'latitude' => 42.2676,
                'longitude' => 2.9606,
                'question_type' => 'open',
                'statement' => 'Quin hook de Vue s’executa just després de muntar el component?',
                'correct_answer' => 'mounted',
            ],
            [
                'name' => 'Castell de Sant Ferran',
                'description' => 'Fortalesa del segle XVIII amb vistes panoràmiques.',
                'latitude' => 42.2752,
                'longitude' => 2.9553,
                'question_type' => 'multiple_choice',
                'statement' => 'Quin patró segueix Laravel en la seva arquitectura?',
                'answer' => "[\"MVC\",\"MVVM\",\"MVP\",\"Flux\"]",
                'correct_answer' => 'MVC',
            ],
            [
                'name' => 'La Rambla de Figueres',
                'description' => 'Zona cèntrica amb botigues, bars i ambient local.',
                'latitude' => 42.2669,
                'longitude' => 2.9633,
                'question_type' => 'true_false',
                'statement' => 'Laravel utilitza PHP com a llenguatge principal.',
                'correct_answer' => 'true',
            ],
            [
                'name' => 'Museu del Joguet de Catalunya',
                'description' => 'Museu del joguet amb una col·lecció històrica.',
                'latitude' => 42.2672,
                'longitude' => 2.9629,
                'question_type' => 'multiple_choice',
                'statement' => 'Quina eina utilitza Laravel per gestionar dependències?',
                'answer' => "[\"Composer\",\"NPM\",\"Yarn\",\"Vite\"]",
                'correct_answer' => 'Composer',
            ],
            [
                'name' => 'Església de Sant Pere',
                'description' => 'Església històrica on va ser batejat Dalí.',
                'latitude' => 42.2675,
                'longitude' => 2.9612,
                'question_type' => 'open',
                'statement' => 'Quin mètode HTTP s’utilitza habitualment per actualitzar un recurs de forma parcial en una API REST?',
                'correct_answer' => 'PATCH',
            ],
        ];

        foreach ($gimcanaTitles as $title) {
            $activity = Activity::where('title', $title)->first();

            if (!$activity) {
                continue;
            }

            $order = 1;

            foreach ($figueresLocations as $location) {
                Locations::create([
                    'name' => $location['name'],
                    'description' => $location['description'],
                    'latitude' => $location['latitude'],
                    'longitude' => $location['longitude'],
                    'question_type' => $location['question_type'],
                    'statement' => $location['statement'],
                    'answer' => $location['answer'] ?? null,
                    'correct_answer' => $location['correct_answer'],
                    'type' => 'gimcana',
                    'activity_id' => $activity->id,
                    'order' => $order,
                ]);

                $order++;
            }
        }
    }
}
