<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Activity;
use Inertia\Inertia;

class activityController extends Controller
{
    public function index(int $id)
    {
        return Inertia::render('teacher/TeacherActivity', [
            'activity' => Activity::with('exchange.users')
                ->where('exchange_id', $id)
                ->get(),
        ]);
   }

    public function create()
    {
        $validated = request()->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'latitude' => 'nullable|string|max:255',
            'longitude' => 'nullable|string|max:255',
            'type' => 'required|in:post,interest_point,guided_visit,gimcana',
            'file' => 'nullable|string|max:255',
            'exchange_id' => 'nullable|string|max:255',
            ]);

        return Inertia::render('activity/Create', [
            'activity' => Activity::get(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'latitude' => 'nullable|string|max:255',
            'longitude' => 'nullable|string|max:255',
            'type' => 'required|in:post,interest_point,guided_visit,gimcana',
            'file' => 'nullable|string|max:255',
            'exchange_id' => 'nullable|string|max:255',
        ]);

        Activity::create($validated);

        return redirect()->route('activity.index')->with('success', 'Activity created successfully.');
    }

    public function show(Activity $activity)
    {
        return Inertia::render('activity/Show', [
            'activity' => Activity::get(),
        ]);
    }

    public function edit(Activity $activity)
    {
        return Inertia::render('activity/Edit', [
            'activity' => Activity::get(),
        ]);
    }

    public function update(Request $request, Activity $activity)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'latitude' => 'nullable|string|max:255',
            'longitude' => 'nullable|string|max:255',
            'type' => 'required|in:post,interest_point,guided_visit,gimcana',
            'file' => 'nullable|string|max:255',
            'exchange_id' => 'nullable|string|max:255',
        ]);

        $activity->update($validated);

        return redirect()->route('activity.index')->with('success', 'Activity updated successfully.');
    }

    public function destroy(Activity $activity)
    {
        $activity->delete();

        return redirect()->route('activity.index')->with('success', 'Activity deleted successfully.');
    }
}