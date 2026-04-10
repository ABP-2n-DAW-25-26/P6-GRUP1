<?php

namespace App\Http\Controllers;

use App\Models\Exchange;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ExchangeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $exchanges = Exchange::all();

        return Inertia::render('CreateExchange', ["exchanges" => $exchanges]);
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
        $exchange = new Exchange();

        $validated = $request->validate([
        'origin' => 'required|string|max:255',
        'destiny' => 'required|string|max:255',
        'start_date' => 'required|date',
        'end_date' => 'nullable|date|after_or_equal:start_date',
         ]);

        $exchange->origin = $validated['origin'];
        $exchange->destiny = $validated['destiny'];
        $exchange->start_date = $validated['start_date'];
        $exchange->end_date = $validated['end_date'] ?? null;

        $exchange->save();
        return to_route('exchange.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Exchange $exchange)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Exchange $exchange)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Exchange $exchange)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Exchange $exchange)
    {
        //
    }
}
