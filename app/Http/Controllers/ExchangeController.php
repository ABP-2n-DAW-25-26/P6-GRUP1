<?php

namespace App\Http\Controllers;

use App\Models\Exchange;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Http\Requests\CreateExchangeRequest;
use App\Actions\Exchanges\CreateExchangeAction;

class ExchangeController extends Controller
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
        $exchanges = Exchange::all();

        return Inertia::render('CreateExchange', ["exchanges" => $exchanges]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateExchangeRequest $request, CreateExchangeAction $createExchange)
    {
        $exchange = new Exchange();

        $validated = $request->validated();
        $createExchange->execute($validated, auth()->id());

        Inertia::flash(['message' => 'Exchange creat correctament']);
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
