<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Exchange;
use App\Models\Locations;
use Inertia\Inertia;
use App\Models\Activity;
use App\Models\Theme;

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
        return Inertia::render('Activities/CreateGimcana', ["activities" => $activities, "locations" => $locations, "themes" => $themes, "exchange" => $exchange]);
    }

public function store(Request $request, Exchange $exchange)
{
    $data = $request->validate([
        'title' => ['required', 'string', 'max:255'],
        'description' => ['nullable', 'string'],
        'start_date' => ['nullable', 'date'],
        'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
        'theme_id' => ['nullable', 'exists:themes,id'],
        'type' => ['required', 'string', 'max:50'],
        'locations' => ['required', 'array', 'min:1'],
        'locations.*.name' => ['required', 'string', 'max:255'],
        'locations.*.description' => ['nullable', 'string'],
        'locations.*.statement' => ['required', 'string'],
        'locations.*.question_type' => ['required', Rule::in(['open', 'multiple_choice', 'true_false'])],
        'locations.*.correct_answer' => ['required_if:locations.*.question_type,multiple_choice,true_false', 'string'],
        'locations.*.answers' => ['required_if:locations.*.question_type,multiple_choice', 'array', 'min:2'],
        'locations.*.answers.*' => ['required_if:locations.*.question_type,multiple_choice', 'string', 'max:255'],
        'locations.*.latitude' => ['nullable', 'numeric'],
        'locations.*.longitude' => ['nullable', 'numeric'],
        'locations.*.type' => ['nullable', 'string', 'max:50'],
        'locations.*.file' => ['nullable', 'string', 'max:255'],
        'locations.*.order' => ['nullable', 'integer', 'min:1'],
    ]);

    $gimcana = Activity::create([
        'title' => $data['title'],
        'description' => $data['description'] ?? null,
        'start_date' => $data['start_date'] ?? null,
        'end_date' => $data['end_date'] ?? null,
        'theme_id' => $data['theme_id'] ?? null,
        'exchange_id' => $exchange->id,
        'type' => 'gimcana',
    ]);

    foreach ($data['locations'] as $location) {

        $newLocation = $location;

        if (($location['question_type'] ?? null) === 'multiple_choice') {
            $newLocation['answer'] = json_encode($location['answers'] ?? []);
        }

        unset($newLocation['answers']);

        $newLocation['activity_id'] = $gimcana->id;
        $newLocation['type'] = 'gimcana';

        Locations::create($newLocation);
    }

    session()->flash('message', 'Gimcana creada correctament');
    return to_route('exchange.show', ['exchange' => $exchange->id]);
}

    public function show(string $id)
    {
        $locations = Locations::where('activity_id', $id)->get();
        return Inertia::render('Activities/ShowGimcana', ["locations" => $locations]);
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        $gimcana = Activity::findOrFail($id);
        $gimcana->delete();
        
        Inertia::flash(['message' => 'Gimcana eliminada correctament']);
        return to_route('gimcana.index');
    }
    
}
