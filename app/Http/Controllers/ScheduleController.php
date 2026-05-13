<?php

namespace App\Http\Controllers;

use App\Models\Exchange;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ScheduleController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $nextExchange = Exchange::where('user_id', $user->id)
            ->orWhereHas('users', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->with('activities.user', 'user')
            ->orderBy('start_date', 'asc')
            ->first();

        if (! $nextExchange) {
            return inertia('Schedule', [
                'exchange' => null,
                'exchangeDays' => [],
            ]);
        }

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
                ->sortBy('start_date')
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
