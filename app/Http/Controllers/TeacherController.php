<?php

namespace App\Http\Controllers;

use App\Models\Exchange;
use App\Models\User;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
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

    public function addTeacherToExchange($exchangeId, string $teacherId)
    {
        $teacher = User::where('id', $teacherId)->where('role', 'teacher')->firstOrFail();
        $exchange = Exchange::findOrFail($exchangeId);

        if($exchange->users()->where('user_id', $teacher->id)->exists()) {
            return response()->json([
                'message' => 'El profesor ya está asignado a este intercambio',
                'teacher' => $teacher,
                'exchange' => $exchange
            ], 400);
        }
        
        $exchange->users()->attach($teacher->id);

        return response()->json([
            'message' => 'Profesor agregado al intercambio exitosamente',
            'teacher' => $teacher,
            'exchange' => $exchange
        ], 200);
    }

    public function getExchangeTeachers($exchangeId)
    {
        $exchange = Exchange::findOrFail($exchangeId);
        
        $teachers = $exchange->users()
            ->where('role', 'teacher')
            ->select('users.id', 'users.name', 'users.email')
            ->get();

        return response()->json([
            'users' => $teachers
        ]);
    }

    public function removeTeacherFromExchange($exchangeId, string $teacherId)
    {
        $teacher = User::where('id', $teacherId)->where('role', 'teacher')->firstOrFail();
        $exchange = Exchange::findOrFail($exchangeId);

        if(!$exchange->users()->where('user_id', $teacher->id)->exists()) {
            return response()->json([
                'message' => 'El profesor no está asignado a este intercambio',
            ], 400);
        }
        
        $exchange->users()->detach($teacher->id);

        return response()->json([
            'message' => 'Profesor eliminado del intercambio exitosamente',
        ], 200);
    }
}
