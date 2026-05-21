<?php

namespace App\Http\Controllers;

use App\Actions\Exchanges\CreateExchangeAction;
use App\Actions\Exchanges\DuplicateExchangeAction;
use App\Http\Requests\CreateExchangeRequest;
use App\Models\Activity;
use App\Models\Exchange;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ExchangeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $now = now();

        $exchanges = Exchange::orderBy('start_date', 'asc')->get()
            ->map(fn ($e) => [
                'id' => $e->id,
                'title' => $e->title,
                'start_date' => $e->start_date ? date('j M, Y', strtotime($e->start_date)) : '—',
                'end_date' => $e->end_date ? date('j M, Y', strtotime($e->end_date)) : '—',
                'status' => match (true) {
                    $e->end_date && $now->gt($e->end_date) => 'Finalitzat',
                    $now->gte($e->start_date) => 'Actiu',
                    default => 'Pendent',
                },
            ]);

        return Inertia::render('Exchange/ExchangeList', [
            'exchangesList' => $exchanges,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Exchange $exchange)
    {
        $user = Auth::user();

        $exchange->load('users', 'activities');

        // Estructurar actividades por días
        $start = Carbon::parse($exchange->start_date)->startOfDay();
        $end = Carbon::parse($exchange->end_date)->endOfDay();

        $days = [];
        $current = $start->copy();

        while ($current->lte($end)) {
            $date = $current->toDateString();

            $activitiesForDay = $exchange->activities
                ->filter(function ($activity) use ($current) {
                    return Carbon::parse($activity->start_date)->isSameDay($current);
                })
                ->sortBy('start_date')
                ->values();

            $days[] = [
                'date' => $date,
                'day' => $current->day,
                'activities' => $activitiesForDay,
            ];

            $current->addDay();
        }

        // dd(Activity::where('exchange_id', $exchange->id)->get());
        // dd($days);
        return Inertia::render('teacher/TeacherActivity', [
            'exchangeDays' => $days,
            'exchange' => $exchange,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $exchanges = Exchange::all();

        return Inertia::render('CreateExchange', ['exchanges' => $exchanges]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateExchangeRequest $request, CreateExchangeAction $createExchange)
    {
        $exchange = new Exchange;

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
        return Inertia::render('EditExchange', [
            'exchange' => $exchange,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Exchange $exchange)
    {
        $validate = $request->validate([
            'title' => 'required|string|max:255',
            'origin' => 'nullable|string',
            'destiny' => 'nullable|string',
            'color' => 'nullable|string|max:7',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $exchange->update($validate);

        return redirect()->route('exchange.index')->with('success', 'Exchange updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Exchange $exchange)
    {
        $exchange->delete();

        return redirect()->route('exchange.index')->with('success', 'Exchange deleted successfully.');
    }

    public function duplicate(Exchange $exchange, DuplicateExchangeAction $duplicateExchange)
    {
        $user = Auth::user();

        if (! in_array($user->role, ['admin', 'teacher'], true)) {
            abort(403);
        }

        $duplicateExchange->execute($exchange, $user->id);

        return redirect()->route('exchange.index')->with('success', 'Intercanvi duplicat correctament.');
    }

    public function search($value)
    {
        if (!preg_match('/^[A-Za-z0-9\s\-àáâãäåèéêëìíîïòóôõöùúûüÀÁÈÉÍÒÓÚÜçÇ]+$/u', $value)) {
        return response()->json(['exchanges' => []]);
        }

        $exchanges = Exchange::where('title', 'LIKE', '%' . $value . '%')->get();
        return response()->json(['exchanges' => $exchanges]);
    }
}
