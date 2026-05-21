<?php

namespace App\Actions\Exchanges;

use App\Models\Exchange;
use App\Models\Locations;
use Illuminate\Support\Facades\DB;

class DuplicateExchangeAction
{
    public function execute(Exchange $exchange, int $userId): Exchange
    {
        return DB::transaction(function () use ($exchange, $userId) {
            $newExchange = $exchange->replicate();
            $newExchange->title = $exchange->title.' (còpia)';
            $newExchange->user_id = $userId;
            $newExchange->save();

            $newExchange->users()->sync($exchange->users()->pluck('users.id')->all());

            $exchange->load('activities.images');

            foreach ($exchange->activities as $activity) {
                $newActivity = $activity->replicate();
                $newActivity->exchange_id = $newExchange->id;
                $newActivity->save();

                foreach ($activity->images as $image) {
                    $newImage = $image->replicate();
                    $newImage->activity_id = $newActivity->id;
                    $newImage->save();
                }

                if ($activity->type === 'guided_visit') {
                    $locations = Locations::where('activity_id', $activity->id)->get();
                    foreach ($locations as $location) {
                        $newLocation = $location->replicate();
                        $newLocation->activity_id = $newActivity->id;
                        $newLocation->save();
                    }
                }
            }

            return $newExchange;
        });
    }
}
