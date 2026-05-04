<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Locations;
use Inertia\Inertia;
use App\Models\Activity;

class GimcanaController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        $activities = Activity::all();
        $locations = Locations::all();
        return Inertia::render('Activities/CreateGimcana', ["activities" => $activities, "locations" => $locations]);
    }

    public function store(Request $request)
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
            'locations.*.statement' => ['nullable', 'string'],
            'locations.*.answer' => ['nullable', 'string'],
            'locations.*.latitude' => ['nullable', 'numeric'],
            'locations.*.longitude' => ['nullable', 'numeric'],
            'locations.*.type' => ['nullable', 'string', 'max:50'],
            'locations.*.file' => ['nullable', 'string', 'max:255'],
            'locations.*.order' => ['nullable', 'integer', 'min:1'],
        ]);

        DB::transaction(function () use ($data) {
            $gimcana = Activity::create([
                'title' => $data['title'],
                'description' => $data['description'] ?? null,
                'start_date' => $data['start_date'] ?? null,
                'end_date' => $data['end_date'] ?? null,
                'type' => 'gimcana',
            ]);

            foreach ($data['locations'] as $location) {
                $location['activity_id'] = $gimcana->id;
                Locations::create($location);
            }
        });

        session()->flash('message', 'Gimcana creada correctament');
        return to_route('gimcana.index');
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
