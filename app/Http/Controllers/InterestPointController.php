<?php

namespace App\Http\Controllers;

use App\Models\InterestPoint;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Http\Requests\CreateInterestPointRequest;
use App\Actions\Exchanges\CreateInterestPointAction;

class InterestPointController extends Controller
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
        $interestPoint = InterestPoint::all();

        return Inertia::render('Activities/CreateInterestPoint', ["interestPoint" => $interestPoint]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateInterestPointRequest $request, CreateInterestPointAction $createinterestPoint)
    {
        $interestPoint = new InterestPoint();

        $validated = $request->validated();
        $createinterestPoint->execute($validated, auth()->id());

        Inertia::flash(['message' => 'Interestpoint creat correctament']);
        return to_route('interestpoint.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(InterestPoint $interestPoint)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(InterestPoint $interestPoint)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, InterestPoint $interestPoint)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InterestPoint $interestPoint)
    {
        //
    }
}
