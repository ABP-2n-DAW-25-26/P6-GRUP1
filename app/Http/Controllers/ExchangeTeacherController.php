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

    public function searchAJAX(string $query, Request $request)
    {
        $exchangeId = $request->query('exchangeId');
        
        $teachersQuery = User::where('name', 'like', '%' . $query . '%')
            ->where('role', 'teacher')
            ->orderBy('name', 'asc');

        if ($exchangeId) {
            $exchange = Exchange::findOrFail($exchangeId);
            $assignedTeacherIds = $exchange->users()
                ->where('role', 'teacher')
                ->pluck('user_id')
                ->toArray();
            
            if (!empty($assignedTeacherIds)) {
                $teachersQuery->whereNotIn('id', $assignedTeacherIds);
            }
        }

        $exchangeTeachers = $teachersQuery->get();

        return response()->json([
            'teachers' => $exchangeTeachers
        ]);
    }
}
