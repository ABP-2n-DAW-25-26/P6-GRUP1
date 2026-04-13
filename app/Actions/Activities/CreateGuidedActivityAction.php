<?php

namespace App\Actions\Activities;

use App\Models\GuidedActivity;
use Illuminate\Support\Facades\Storage;

class CreateGuidedActivityAction
{
    public function execute(array $data, int $userId):GuidedActivity
    {
        $guidedActivity = new GuidedActivity();
        $guidedActivity->title = $data['title']; 
        $guidedActivity->description = $data['description']; 
        $guidedActivity->start_date = $data['start_date'];
        $guidedActivity->end_date = $data['end_date'] ?? null;
        
        $guidedActivity->save();

        return $guidedActivity;
    }
}