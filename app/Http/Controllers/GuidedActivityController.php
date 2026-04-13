<?php

namespace App\Http\Controllers;

use App\Models\GuidedActivity;
use Illuminate\Http\Request;
use Inertia\Inertia;

class GuidedActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $guidedActivity = GuidedActivity::all();

        return Inertia::render('CreateGuidedActivity', ["guidedActivity" => $guidedActivity]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(GuidedActivity $guidedActivity)
    {
        //
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
