<?php

namespace App\Actions\Activities;

use App\Models\InterestPoint;
use Illuminate\Support\Facades\Storage;

class CreateInterestPoint
{
    public function execute(array $data, int $userId): InterestPoint
    {
        $interestPoint = new InterestPoint;
        $interestPoint->title = $data['title'];
        $interestPoint->description = $data['description'];
        $interestPoint->start_date = $data['start_date'];
        $interestPoint->end_date = $data['end_date'] ?? null;
        $interestPoint->latitude = $data['latitude'];
        $interestPoint->longitude = $data['longitude'];
        $interestPoint->exchange_id = $data['exchange_id'] ?? null;
        $interestPoint->type = $data['type'] ?? 'interest_point';

        if (! empty($data['file'])) {
            $path = $data['file']->store('interestpoint', 'public');
            $interestPoint->file = Storage::url($path);
        }

        $interestPoint->save();

        return $interestPoint;
    }
}
