<?php

namespace App\Http\Controllers;

use App\Actions\Activities\CreateGuidedActivityAction;
use App\Http\Requests\CreateGuidedActivityRequest;
use App\Models\Exchange;
use App\Models\GuidedActivity;
use App\Models\Locations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

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
    public function create(Exchange $exchange)
    {
        return Inertia::render('Activities/CreateGuidedActivity', ['exchangeId' => $exchange->id]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateGuidedActivityRequest $request, CreateGuidedActivityAction $createGuidedActivity)
    {
        $validated = $request->validated();
        $guidedActivity = $createGuidedActivity->execute($validated, Auth::id(), $validated['exchange_id']);

        Inertia::flash(['message' => 'Activitat guiada creada correctament']);

        return to_route('guidedactivity.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(GuidedActivity $guidedActivity)
    {
        // dd($guidedActivity);
        // $guidedactivity = GuidedActivity::with('locations')->findOrFail($id);
        return Inertia::render('Activities/ShowGuidedActivity', ['guidedactivity' => $guidedActivity]);
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
