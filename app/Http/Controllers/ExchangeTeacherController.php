<?php

namespace App\Http\Controllers;

use App\Models\Exchange;
use App\Models\User;
use Illuminate\Http\Request;

class ExchangeTeacherController extends Controller
{
    public function index(Exchange $exchange)
    {
        $teachers = $exchange->users()->where('role', 'teacher')->get();

        return inertia('teacher/TeachersList', [
            'exchange' => $exchange,
            'teachers' => $teachers,
        ]);
    }

    public function searchAJAX(Request $request)
    {
        $query = $request->query('query');
        $exchangeId = $request->query('exchangeId');
        $teachersQuery = User::where('name', 'like', '%'.$query.'%')
            ->where('role', 'teacher')
            ->orderBy('name', 'asc');
        if ($exchangeId) {
            $exchange = Exchange::findOrFail($exchangeId);
            $assignedTeacherIds = $exchange->users()
                ->where('role', 'teacher')
                ->pluck('user_id')
                ->toArray();

            if (! empty($assignedTeacherIds)) {
                $teachersQuery->whereNotIn('id', $assignedTeacherIds);
            }
        }
        $exchangeTeachers = $teachersQuery->get();

        return response()->json([
            'teachers' => $exchangeTeachers,
        ]);
    }

    public function assign(Exchange $exchange, Request $request)
    {
        $userId = $request->input('user_id');
        if ($exchange->users()->where('user_id', $userId)->exists()) {
            return response()->json([
                'message' => 'Aquest professor ja està assignat',
            ], 409);
        }
        $exchange->users()->attach($userId);

        return response()->json([
            'message' => 'Professor assignat correctament',
        ]);
    }

    public function destroy(Exchange $exchange, User $teacher)
    {
        $exchange->users()->detach($teacher->id);

        return response()->json([
            'message' => 'Professor eliminat correctament',
        ]);
    }
}
