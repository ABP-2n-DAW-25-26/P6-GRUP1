<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Activity;
use App\Models\Exchange;
use Carbon\Carbon;

class ActivitiesSeeder extends Seeder
{
    public function run(): void
    {
        /** =========================
         * ITALIA (3 actividades)
         * ========================= */
        $italy = Exchange::find(1);
        $startItaly = Carbon::parse($italy->start_date);

        Activity::create([
            'title' => 'Visita al Duomo de Milà',
            'description' => 'Descobreix la catedral més emblemàtica de Milà.',
            'exchange_id' => 1,
            'start_date' => $startItaly->copy()->addDays(-1)->setTime(10, 0),
            'end_date' => $startItaly->copy()->addDays(1)->setTime(12, 0),
        ]);

        Activity::create([
            'title' => 'Galeria Vittorio Emanuele II',
            'description' => 'Passeig per una galeria històrica i comercial.',
            'exchange_id' => 1,
            'start_date' => $startItaly->copy()->addDays(0)->setTime(11, 0),
            'end_date' => $startItaly->copy()->addDays(3)->setTime(13, 0),
        ]);

        Activity::create([
            'title' => 'Castell Sforzesco',
            'description' => 'Explora aquest castell i els seus museus.',
            'exchange_id' => 1,
            'start_date' => $startItaly->copy()->addDays(2)->setTime(16, 0),
            'end_date' => $startItaly->copy()->addDays(5)->setTime(18, 0),
        ]);

        Activity::create([
            'title' => 'Navigli al capvespre',
            'description' => 'Passeig pels canals de Milà amb ambient nocturn.',
            'exchange_id' => 1,
            'start_date' => $startItaly->copy()->addDays(-1)->setTime(18, 0),
            'end_date' => $startItaly->copy()->addDays(-1)->setTime(20, 0),
        ]);

        Activity::create([
            'title' => 'Museu del Novecento',
            'description' => 'Art modern italià amb vistes al Duomo.',
            'exchange_id' => 1,
            'start_date' => $startItaly->copy()->addDays(0)->setTime(14, 0),
            'end_date' => $startItaly->copy()->addDays(0)->setTime(16, 0),
        ]);

        Activity::create([
            'title' => 'Brera i Pinacoteca',
            'description' => 'Barri bohemi i galeria d’art clàssic.',
            'exchange_id' => 1,
            'start_date' => $startItaly->copy()->addDays(0)->setTime(17, 0),
            'end_date' => $startItaly->copy()->addDays(0)->setTime(19, 0),
        ]);

        Activity::create([
            'title' => 'Parc Sempione',
            'description' => 'Relax al parc més gran de Milà.',
            'exchange_id' => 1,
            'start_date' => $startItaly->copy()->addDays(1)->setTime(10, 0),
            'end_date' => $startItaly->copy()->addDays(1)->setTime(12, 0),
        ]);

        Activity::create([
            'title' => 'Cenacolo Vinciano',
            'description' => 'Veure "L’Últim Sopar" de Leonardo da Vinci.',
            'exchange_id' => 1,
            'start_date' => $startItaly->copy()->addDays(1)->setTime(15, 0),
            'end_date' => $startItaly->copy()->addDays(1)->setTime(17, 0),
        ]);

        Activity::create([
            'title' => 'Shopping a Corso Buenos Aires',
            'description' => 'Una de les principals avingudes comercials de Milà.',
            'exchange_id' => 1,
            'start_date' => $startItaly->copy()->addDays(3)->setTime(16, 0),
            'end_date' => $startItaly->copy()->addDays(3)->setTime(18, 0),
        ]);

        Activity::create([
            'title' => 'Arribada i instal·lació',
            'description' => 'Arribada a Milà i acomodació a l’allotjament.',
            'exchange_id' => 1,
            'start_date' => $startItaly->copy()->addDays(-1)->setTime(8, 0),
            'end_date' => $startItaly->copy()->addDays(-1)->setTime(9, 30),
        ]);

        Activity::create([
            'title' => 'Esmorzar italià',
            'description' => 'Primer contacte amb la gastronomia local.',
            'exchange_id' => 1,
            'start_date' => $startItaly->copy()->addDays(0)->setTime(9, 0),
            'end_date' => $startItaly->copy()->addDays(0)->setTime(10, 0),
        ]);

        Activity::create([
            'title' => 'Visita a l’Universitat de Milà',
            'description' => 'Intercanvi cultural amb estudiants locals.',
            'exchange_id' => 1,
            'start_date' => $startItaly->copy()->addDays(1)->setTime(9, 0),
            'end_date' => $startItaly->copy()->addDays(1)->setTime(13, 0),
        ]);

        Activity::create([
            'title' => 'Temps lliure',
            'description' => 'Exploració lliure de la ciutat.',
            'exchange_id' => 1,
            'start_date' => $startItaly->copy()->addDays(3)->setTime(10, 0),
            'end_date' => $startItaly->copy()->addDays(3)->setTime(13, 0),
        ]);

        Activity::create([
            'title' => 'Sopar de grup',
            'description' => 'Sopar conjunt per compartir l’experiència.',
            'exchange_id' => 1,
            'start_date' => $startItaly->copy()->addDays(3)->setTime(20, 0),
            'end_date' => $startItaly->copy()->addDays(3)->setTime(22, 0),
        ]);

        Activity::create([
            'title' => 'Tornada a casa',
            'description' => 'Sortida cap a Figueres.',
            'exchange_id' => 1,
            'start_date' => $startItaly->copy()->addDays(4)->setTime(9, 0),
            'end_date' => $startItaly->copy()->addDays(4)->setTime(14, 0),
        ]);


        /** =========================
         * ALEMANIA (3 actividades)
         * ========================= */
        $germany = Exchange::find(2);
        $startGermany = Carbon::parse($germany->start_date);

        Activity::create([
            'title' => 'Mur de Berlín',
            'description' => 'Història i recorregut pel mur.',
            'exchange_id' => 2,
            'start_date' => $startGermany->copy()->addDays(1)->setTime(10, 0),
            'end_date' => $startGermany->copy()->addDays(1)->setTime(12, 0),
        ]);

        Activity::create([
            'title' => 'Reichstag',
            'description' => 'Visita al parlament alemany.',
            'exchange_id' => 2,
            'start_date' => $startGermany->copy()->addDays(3)->setTime(11, 0),
            'end_date' => $startGermany->copy()->addDays(3)->setTime(13, 0),
        ]);

        Activity::create([
            'title' => 'Porta de Brandenburg',
            'description' => 'Símbol icònic de Berlín.',
            'exchange_id' => 2,
            'start_date' => $startGermany->copy()->addDays(5)->setTime(16, 0),
            'end_date' => $startGermany->copy()->addDays(5)->setTime(18, 0),
        ]);


        /** =========================
         * FRANCIA (5 actividades en 1 semana)
         * ========================= */
        $france = Exchange::find(3);
        $startFrance = Carbon::parse($france->start_date);

        Activity::create([
            'title' => 'Torre Eiffel',
            'description' => 'Visita guiada al monument més famós.',
            'exchange_id' => 3,
            'start_date' => $startFrance->copy()->addDays(0)->setTime(10, 0),
            'end_date' => $startFrance->copy()->addDays(0)->setTime(12, 0),
        ]);

        Activity::create([
            'title' => 'Passeig pel Sena',
            'description' => 'Ruta en vaixell per París.',
            'exchange_id' => 3,
            'start_date' => $startFrance->copy()->addDays(1)->setTime(11, 0),
            'end_date' => $startFrance->copy()->addDays(1)->setTime(13, 0),
        ]);

        Activity::create([
            'title' => 'Museu del Louvre',
            'description' => 'Exploració artística guiada.',
            'exchange_id' => 3,
            'start_date' => $startFrance->copy()->addDays(2)->setTime(10, 0),
            'end_date' => $startFrance->copy()->addDays(2)->setTime(13, 0),
        ]);

        Activity::create([
            'title' => 'Montmartre',
            'description' => 'Barri bohemi i cultural.',
            'exchange_id' => 3,
            'start_date' => $startFrance->copy()->addDays(3)->setTime(16, 0),
            'end_date' => $startFrance->copy()->addDays(3)->setTime(18, 0),
        ]);

        Activity::create([
            'title' => 'Versalles',
            'description' => 'Excursió al palau.',
            'exchange_id' => 3,
            'start_date' => $startFrance->copy()->addDays(4)->setTime(9, 0),
            'end_date' => $startFrance->copy()->addDays(4)->setTime(14, 0),
        ]);
    }
}
