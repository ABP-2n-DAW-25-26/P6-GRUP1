<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\Exchange;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ActivitiesSeeder extends Seeder
{
    public function run(): void
    {
        /** =========================
         * ITALIA
         * ========================= */
        $italy = Exchange::find(1);
        $startItaly = Carbon::parse($italy->start_date);

        Activity::insert([
            [
                'title' => 'Arribada i instal·lació',
                'description' => 'Arribada a Milà i acomodació a l’allotjament.',
                'type' => 'post',
                'exchange_id' => 1,
                'user_id' => '1',
                'start_date' => $startItaly->copy()->addDays(0)->setTime(8, 0),
                'end_date' => $startItaly->copy()->addDays(0)->setTime(9, 30),
            ],
            [
                'title' => 'Esmorzar italià',
                'description' => 'Primer contacte amb la gastronomia local.',
                'type' => 'post',
                'exchange_id' => 1,
                'user_id' => '1',
                'start_date' => $startItaly->copy()->addDays(0)->setTime(9, 30),
                'end_date' => $startItaly->copy()->addDays(0)->setTime(10, 30),
            ],
            [
                'title' => 'Visita al Duomo de Milà',
                'description' => 'Descobreix la catedral més emblemàtica de Milà.',
                'type' => 'post',
                'exchange_id' => 1,
                'user_id' => '1',
                'start_date' => $startItaly->copy()->addDays(0)->setTime(11, 0),
                'end_date' => $startItaly->copy()->addDays(0)->setTime(13, 0),
            ],
            [
                'title' => 'Galeria Vittorio Emanuele II',
                'description' => 'Passeig per una galeria històrica i comercial.',
                'type' => 'post',
                'exchange_id' => 1,
                'user_id' => '2',
                'start_date' => $startItaly->copy()->addDays(1)->setTime(10, 0),
                'end_date' => $startItaly->copy()->addDays(1)->setTime(12, 0),
            ],
            [
                'title' => 'Museu del Novecento',
                'description' => 'Art modern italià amb vistes al Duomo.',
                'type' => 'post',
                'exchange_id' => 1,
                'user_id' => '3',
                'start_date' => $startItaly->copy()->addDays(1)->setTime(14, 0),
                'end_date' => $startItaly->copy()->addDays(1)->setTime(16, 0),
            ],
            [
                'title' => 'Brera i Pinacoteca',
                'description' => 'Barri bohemi i galeria d’art clàssic.',
                'type' => 'interest_point',
                'exchange_id' => 1,
                'user_id' => '1',
                'start_date' => $startItaly->copy()->addDays(1)->setTime(17, 0),
                'end_date' => $startItaly->copy()->addDays(1)->setTime(19, 0),
            ],
            [
                'title' => 'Parc Sempione',
                'description' => 'Relax al parc més gran de Milà.',
                'type' => 'guided_visit',
                'exchange_id' => 1,
                'user_id' => '2',
                'start_date' => $startItaly->copy()->addDays(2)->setTime(10, 0),
                'end_date' => $startItaly->copy()->addDays(2)->setTime(12, 0),
            ],
            [
                'title' => 'Castell Sforzesco',
                'description' => 'Explora aquest castell i els seus museus.',
                'type' => 'gimcana',
                'exchange_id' => 1,
                'user_id' => '1',
                'start_date' => $startItaly->copy()->addDays(2)->setTime(16, 0),
                'end_date' => $startItaly->copy()->addDays(2)->setTime(18, 0),
            ],
            [
                'title' => 'Visita a l’Universitat de Milà',
                'description' => 'Intercanvi cultural amb estudiants locals.',
                'type' => 'post',
                'exchange_id' => 1,
                'user_id' => '2',
                'start_date' => $startItaly->copy()->addDays(3)->setTime(10, 0),
                'end_date' => $startItaly->copy()->addDays(3)->setTime(13, 0),
            ],
            [
                'title' => 'Temps lliure',
                'description' => 'Exploració lliure de la ciutat.',
                'type' => 'post',
                'exchange_id' => 1,
                'user_id' => '3',
                'start_date' => $startItaly->copy()->addDays(3)->setTime(16, 0),
                'end_date' => $startItaly->copy()->addDays(3)->setTime(18, 0),
            ],
            [
                'title' => 'Sopar de grup',
                'description' => 'Sopar conjunt per compartir l’experiència.',
                'type' => 'post',
                'exchange_id' => 1,
                'user_id' => '1',
                'start_date' => $startItaly->copy()->addDays(3)->setTime(20, 0),
                'end_date' => $startItaly->copy()->addDays(3)->setTime(22, 0),
            ],
            [
                'title' => 'Cenacolo Vinciano',
                'description' => 'Veure "L’Últim Sopar" de Leonardo da Vinci.',
                'type' => 'post',
                'exchange_id' => 1,
                'user_id' => '1',
                'start_date' => $startItaly->copy()->addDays(4)->setTime(10, 0),
                'end_date' => $startItaly->copy()->addDays(4)->setTime(12, 0),
            ],
            [
                'title' => 'Shopping a Corso Buenos Aires',
                'description' => 'Una de les principals avingudes comercials de Milà.',
                'type' => 'post',
                'exchange_id' => 1,
                'user_id' => '1',
                'start_date' => $startItaly->copy()->addDays(5)->setTime(10, 0),
                'end_date' => $startItaly->copy()->addDays(5)->setTime(12, 0),
            ],
            [
                'title' => 'Tornada a casa',
                'description' => 'Sortida cap a Figueres.',
                'type' => 'post',
                'exchange_id' => 1,
                'user_id' => '1',
                'start_date' => $startItaly->copy()->addDays(5)->setTime(14, 0),
                'end_date' => $startItaly->copy()->addDays(5)->setTime(18, 0),
            ],
        ]);

        /** =========================
         * ALEMANIA
         * ========================= */
        $germany = Exchange::find(2);
        $startGermany = Carbon::parse($germany->start_date);

        Activity::insert([
            [
                'title' => 'Mur de Berlín',
                'description' => 'Història i recorregut pel mur.',
                'type' => 'post',
                'exchange_id' => 2,
                'user_id' => '1',
                'start_date' => $startGermany->copy()->addDays(1)->setTime(10, 0),
                'end_date' => $startGermany->copy()->addDays(1)->setTime(12, 0),
            ],
            [
                'title' => 'Reichstag',
                'description' => 'Visita al parlament alemany.',
                'type' => 'post',
                'exchange_id' => 2,
                'user_id' => '1',
                'start_date' => $startGermany->copy()->addDays(3)->setTime(11, 0),
                'end_date' => $startGermany->copy()->addDays(3)->setTime(13, 0),
            ],
            [
                'title' => 'Porta de Brandenburg',
                'description' => 'Símbol icònic de Berlín.',
                'type' => 'post',
                'exchange_id' => 2,
                'user_id' => '1',
                'start_date' => $startGermany->copy()->addDays(5)->setTime(16, 0),
                'end_date' => $startGermany->copy()->addDays(5)->setTime(18, 0),
            ],
        ]);

        /** =========================
         * FRANCIA
         * ========================= */
        $france = Exchange::find(3);
        $startFrance = Carbon::parse($france->start_date);

        Activity::insert([
            [
                'title' => 'Torre Eiffel',
                'description' => 'Visita guiada al monument més famós.',
                'type' => 'post',
                'exchange_id' => 3,
                'user_id' => '1',
                'start_date' => $startFrance->copy()->addDays(0)->setTime(10, 0),
                'end_date' => $startFrance->copy()->addDays(0)->setTime(12, 0),
            ],
            [
                'title' => 'Passeig pel Sena',
                'description' => 'Ruta en vaixell per París.',
                'type' => 'post',
                'exchange_id' => 3,
                'user_id' => '1',
                'start_date' => $startFrance->copy()->addDays(1)->setTime(11, 0),
                'end_date' => $startFrance->copy()->addDays(1)->setTime(13, 0),
            ],
            [
                'title' => 'Museu del Louvre',
                'description' => 'Exploració artística guiada.',
                'type' => 'post',
                'exchange_id' => 3,
                'user_id' => '1',
                'start_date' => $startFrance->copy()->addDays(2)->setTime(10, 0),
                'end_date' => $startFrance->copy()->addDays(2)->setTime(13, 0),
            ],
            [
                'title' => 'Montmartre',
                'description' => 'Barri bohemi i cultural.',
                'type' => 'post',
                'exchange_id' => 3,
                'user_id' => '1',
                'start_date' => $startFrance->copy()->addDays(3)->setTime(16, 0),
                'end_date' => $startFrance->copy()->addDays(3)->setTime(18, 0),
            ],
            [
                'title' => 'Versalles',
                'description' => 'Excursió al palau.',
                'type' => 'post',
                'exchange_id' => 3,
                'user_id' => '1',
                'start_date' => $startFrance->copy()->addDays(4)->setTime(9, 0),
                'end_date' => $startFrance->copy()->addDays(4)->setTime(14, 0),
            ],
        ]);
    }
}
