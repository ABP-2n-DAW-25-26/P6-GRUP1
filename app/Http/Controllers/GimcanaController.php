<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateGimcana;
use App\Models\Activity;
use App\Models\Exchange;
use App\Models\Locations;
use App\Models\Theme;
use Illuminate\Http\Request;
use Inertia\Inertia;

class GimcanaController extends Controller
{
    public function index()
    {
        //
    }

    public function create(Exchange $exchange)
    {
        $activities = Activity::all();
        $locations = Locations::all();
        $themes = Theme::all();

        return Inertia::render('Activities/CreateGimcana', ['activities' => $activities, 'locations' => $locations, 'themes' => $themes, 'exchange' => $exchange]);
    }

    public function store(CreateGimcana $request, Exchange $exchange)
    {
        $data = $request->validated();

        $gimcana = Activity::create([
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'start_date' => $data['start_date'] ?? null,
            'end_date' => $data['end_date'] ?? null,
            'theme_id' => $data['theme_id'] ?? null,
            'exchange_id' => $exchange->id,
            'type' => 'gimcana',
        ]);

        foreach ($data['locations'] as $index => $location) {
            $answers = null;

            if (($location['question_type'] ?? null) === 'multiple_choice') {
                $answers = json_encode($location['answers'] ?? []);
            }

            Locations::create([
                'name' => $location['name'],
                'description' => $location['description'] ?? null,
                'statement' => $location['statement'] ?? null,
                'question_type' => $location['question_type'] ?? null,
                'answer' => $answers,
                'correct_answer' => $location['correct_answer'] ?? null,
                'latitude' => $location['latitude'] ?? null,
                'longitude' => $location['longitude'] ?? null,
                'type' => 'gimcana',
                'activity_id' => $gimcana->id,
                'order' => $location['order'] ?? ($index + 1),
            ]);
        }

        session()->flash('message', 'Gimcana creada correctament');

        return to_route('exchange.show', ['exchange' => $exchange->id]);
    }

    public function show(Exchange $exchange, string $gimcana)
    {
        $activity = Activity::where('exchange_id', $exchange->id)
            ->where('type', 'gimcana')
            ->findOrFail($gimcana);

        $locations = Locations::where('activity_id', $activity->id)
            ->orderBy('order')
            ->orderBy('id')
            ->get();

        return Inertia::render('Activities/ShowGimcana', [
            'gimcana' => $activity,
            'locations' => $locations,
        ]);
    }

    public function edit(Exchange $exchange, string $id)
    {
        $activity = Activity::where('exchange_id', $exchange->id)->where('type', 'gimcana')->findOrFail($id);

        $locations = Locations::where('activity_id', $activity->id)->orderBy('order')->orderBy('id')->get();

        $themes = Theme::all();

        return Inertia::render('Activities/EditGimcana', [
            'gimcana' => $activity,
            'locations' => $locations,
            'themes' => $themes,
            'exchange' => $exchange,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Exchange $exchange, string $id)
    {
        $activity = Activity::where('exchange_id', $exchange->id)->where('type', 'gimcana')->findOrFail($id);

        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date'],
            'theme_id' => ['nullable', 'integer'],
            'locations' => ['required', 'array'],
        ]);

        $activity->update([
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'start_date' => $data['start_date'] ?? null,
            'end_date' => $data['end_date'] ?? null,
            'theme_id' => $data['theme_id'] ?? null,
        ]);

        Locations::where('activity_id', $activity->id)->delete();

        foreach ($data['locations'] as $index => $location) {
            $answers = null;

            if (($location['question_type'] ?? null) === 'multiple_choice') {
                $answers = json_encode($location['answers'] ?? []);
            }

            Locations::create([
                'name' => $location['name'],
                'description' => $location['description'] ?? null,
                'statement' => $location['statement'] ?? null,
                'question_type' => $location['question_type'] ?? null,
                'answer' => $answers,
                'correct_answer' => $location['correct_answer'] ?? null,
                'latitude' => $location['latitude'] ?? null,
                'longitude' => $location['longitude'] ?? null,
                'type' => 'gimcana',
                'activity_id' => $activity->id,
                'order' => $location['order'] ?? ($index + 1),
            ]);
        }

        session()->flash('message', 'Gimcana actualitzada correctament');

        return to_route('exchange.show', ['exchange' => $exchange->id]);
    }

    public function destroy(string $id)
    {
        $gimcana = Activity::findOrFail($id);
        $gimcana->delete();

        Inertia::flash(['message' => 'Gimcana eliminada correctament']);

        return to_route('gimcana.index');
    }
}
