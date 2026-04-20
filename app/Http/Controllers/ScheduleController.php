<?php

namespace App\Http\Controllers;

use App\Models\Exchange;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index()
    {
        $nextExchange = Exchange::with('activities')->first();

        $start = Carbon::parse($nextExchange->start_date);
        $end = Carbon::parse($nextExchange->end_date);

        $days = [];
        $current = $start->copy();

        while ($current->lte($end)) {
            $date = $current->toDateString();

            $activitiesForDay = $nextExchange->activities
                ->filter(function ($activity) use ($date) {
                    return Carbon::parse($activity->start_date)->toDateString() === $date;
                })
                ->values();

            $days[] = [
                'date' => $date,
                'day' => $current->day,
                'activities' => $activitiesForDay,
            ];

            $current->addDay();
        }

        return inertia('Schedule', [
            'exchange' => $nextExchange,
            'exchangeDays' => $days,
        ]);
    }
}