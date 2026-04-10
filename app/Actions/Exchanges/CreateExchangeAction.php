<?php

namespace App\Actions\Exchanges;

use App\Models\Exchange;
use Illuminate\Support\Facades\Storage;

class CreateExchangeAction
{
    public function execute(array $data, int $userId):Exchange
    {
        $exchange = new Exchange();
        $exchange->origin = $data['origin'];
        $exchange->destiny = $data['destiny'];
        $exchange->start_date = $data['start_date'];
        $exchange->end_date = $data['end_date'] ?? null;

        $exchange->save();

        return $exchange;
    }
}