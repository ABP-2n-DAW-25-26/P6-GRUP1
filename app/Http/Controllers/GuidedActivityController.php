<?php

namespace App\Http\Controllers;

use App\Models\GuidedActivity;
use App\Models\Locations;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Http\Requests\CreateGuidedActivityRequest;
use App\Actions\Activities\CreateGuidedActivityAction;

class GuidedActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $guidedActivity = GuidedActivity::all();

        return Inertia::render('Activities/CreateGuidedActivity', ["guidedActivity" => $guidedActivity]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateGuidedActivityRequest $request, CreateGuidedActivityAction $createGuidedActivity)
    {
        $guidedActivity = new GuidedActivity();

        $validated = $request->validated();
        $createGuidedActivity->execute($validated, auth()->id());

        Inertia::flash(['message' => 'Activitat guiada creada correctament']);
        return to_route('guidedactivity.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(GuidedActivity $guidedactivity)
    {
        $guidedactivity = GuidedActivity::with('locations')->findOrFail($guidedactivity->id);
        return Inertia::render('Activities/ShowGuidedActivity', ["guidedactivity" => $guidedactivity]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GuidedActivity $guidedActivity)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, GuidedActivity $guidedActivity)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GuidedActivity $guidedActivity)
    {
        //
    }
}
