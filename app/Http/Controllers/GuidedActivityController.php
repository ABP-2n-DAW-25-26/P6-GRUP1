<?php

namespace App\Http\Controllers;

use App\Actions\Activities\CreateGuidedActivityAction;
use App\Http\Requests\CreateGuidedActivityRequest;
use App\Models\Exchange;
use App\Models\Activity;
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
public function edit(Exchange $exchange, string $id)
{
    $activity = Activity::findOrFail($id);

    return Inertia::render('Activities/EditGuidedActivity', [
        'activity' => $activity,
        'exchange' => $exchange,
    ]);
}

    /**
     * Update the specified resource in storage.
     */
public function update(Request $request, Exchange $exchange, string $id)
{
    $activity = Activity::findOrFail($id);

    $data = $request->validate([
        'title' => ['required', 'string', 'max:255'],
        'description' => ['nullable', 'string'],
        'start_date' => ['nullable', 'date'],
        'end_date' => ['nullable', 'date'],
    ]);

    $activity->update($data);

    session()->flash('message', 'Activitat actualitzada correctament');

    return to_route('exchange.show', $exchange->id);
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Exchange $exchange, string $id)
    {
        $activity = Activity::where('exchange_id', $exchange->id)->findOrFail($id);
        $activity->delete();

        Inertia::flash(['message' => 'Activitat guiada eliminada correctament']);

        return to_route('exchange.show', ['exchange' => $exchange->id]);
    }
}
