<?php

namespace App\Http\Controllers;

use App\Models\Exchange;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Http\Requests\CreateExchangeRequest;
use App\Actions\Exchanges\CreateExchangeAction;
use App\Models\Activity;
use Illuminate\Support\Facades\Auth;

class ExchangeController extends Controller
{
    /**
     * Display a listing of the resource. 
     */
    public function index()
    {
        $exchange = Exchange::query()->orderBy('start_date', 'asc')->first();

        $user = auth()->user();

        if ($user && $user->role === 'teacher' || $user->role === 'admin')
        {
            if (! $exchange) {
                return Inertia::render('teacher/TeacherActivity', [
                    'activity' => [],
                    'exchange' => null,
                ]);
            }
        }
        elseif ($user && $user->role === 'student')
        {
            if (! $exchange) {
                return Inertia::render('users/StudentActivity', [
                    'activity' => [],
                    'exchange' => null,
                ]);
            }
        }

        return to_route('exchange.show', $exchange);
    }

    /**
     * Display the specified resource.
     */
    public function show(Exchange $exchange)
    {
        $user = auth()->user();
        if ($user && $user->role === 'student')
        {
            return Inertia::render('users/StudentActivity', [
                'activity' => Activity::with('exchange.users')
                    ->where('exchange_id', $exchange->id)
                    ->get(),
                'exchange' => $exchange->load('users'),
            ]);
        }
        
        $user = Auth::user();
        if ($exchange->user_id !== $user->id && ! $exchange->users()->where('user_id', $user->id)->where('role', 'teacher')->exists()) {
             return to_route('schedule')->with('error', 'No tienes permiso para ver este intercambio');
        }
        $students = $exchange->users()->where('role', 'student')->get();
        return Inertia::render('teacher/TeacherActivity', [
            'activity' => Activity::with('exchange.users')
                ->where('exchange_id', $exchange->id)
                ->orderBy('start_date', 'asc')
                ->get(),
            'exchange' => $exchange->load('users'),
            'studentsCount' => $students->count(),
        ]);
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
     * Display a full list of all exchanges.
     */
    public function list()
    {
        $now = now();

        $exchanges = Exchange::orderBy('start_date', 'asc')->get()
            ->map(fn ($e) => [
                'id'         => $e->id,
                'title'      => $e->title,
                'start_date' => $e->start_date ? date('j M, Y', strtotime($e->start_date)) : '—',
                'end_date'   => $e->end_date   ? date('j M, Y', strtotime($e->end_date))   : '—',
                'status'     => match(true) {
                    $e->end_date && $now->gt($e->end_date)     => 'Finalitzat',
                    $now->gte($e->start_date)                   => 'Actiu',
                    default                                     => 'Pendent',
                },
            ]);

        return Inertia::render('Exchange/ExchangeList', [
            'exchanges' => $exchanges,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Exchange $exchange)
    {
        //
    }
}
