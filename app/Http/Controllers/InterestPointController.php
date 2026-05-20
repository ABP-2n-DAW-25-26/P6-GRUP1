<?php

namespace App\Http\Controllers;

use App\Actions\Activities\CreateInterestPoint;
use App\Http\Requests\CreateInterestPointRequest;
use App\Models\Exchange;
use App\Models\Activity;
use App\Models\InterestPoint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

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
    public function create(Exchange $exchange)
    {
        $interestPoint = InterestPoint::all();

        return Inertia::render('Activities/CreateInterestPoint', [
            'interestPoint' => $interestPoint,
            'exchangeId' => $exchange->id,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateInterestPointRequest $request, Exchange $exchange, CreateInterestPoint $createinterestPoint)
    {
        $interestPoint = new InterestPoint;

        $validated = $request->validated();
        $validated['exchange_id'] = $exchange->id;
        $validated['type'] = 'interest_point';
        $createinterestPoint->execute($validated, Auth::id());
        // dd($request->all());
        Inertia::flash(['message' => 'Interestpoint creat correctament']);

        return to_route('exchange.show', ['exchange' => $exchange->id]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Exchange $exchange, string $id)
    {
        $activity = Activity::where('id', $id)->where('exchange_id', $exchange->id)->firstOrFail();

        return Inertia::render('Activities/InterestPointView', ['activity' => $activity]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Exchange $exchange, string $id)
    {
        $activity = Activity::where('id', $id)->where('exchange_id', $exchange->id)->firstOrFail();

         return Inertia::render('Activities/EditInterestPoint', ['activity' => $activity,]);
    }

    public function update(Request $request, Exchange $exchange, string $id)
    {
        $activity = Activity::where('id', $id)->where('exchange_id', $exchange->id)->firstOrFail();

        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date'],
            'latitude' => ['nullable', 'numeric'],
            'longitude' => ['nullable', 'numeric'],
        ]);

        $activity->update($data);

        session()->flash('message', 'Punt d’interès actualitzat correctament');

        return to_route('exchange.show', $activity->exchange_id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Exchange $exchange, int $id)
    {
        $interestPoint = InterestPoint::findOrFail($id);
        $deleted = $interestPoint->delete();
        if ($deleted) {
            Inertia::flash(['message' => 'Punt d\'interès eliminat correctament']);
        }

        return to_route('exchange.show', ['exchange' => $interestPoint->exchange_id]);
    }
}

// }    public function destroy(Exchange $exchange, Post $post)
//     {
//         $deleted = $post->delete();
//         if($deleted) {
//             Inertia::flash(['message' => 'Post eliminat correctament']);
//         }
//         return to_route('exchange.show', ['exchange' => $post->exchange_id]);
//     }
