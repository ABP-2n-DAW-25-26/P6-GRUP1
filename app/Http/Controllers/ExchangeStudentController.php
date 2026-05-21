<?php

namespace App\Http\Controllers;

use App\Models\Exchange;
use App\Models\User;

class ExchangeStudentController extends Controller
{
    public function index(Exchange $exchange)
    {
        $exchange->load([
            'users:id,role'
        ]);

        $students = $exchange->users()
            ->where('role', 'student')
            ->get();

        return inertia('teacher/StudentsList', [
            'exchange' => $exchange,
            'students' => $students,
        ]);
    }

    public function destroy(Exchange $exchange, User $student)
    {
        $exchange->users()->detach($student->id);

        return response()->json([
            'message' => 'Estudiant eliminat correctament',
        ]);
    }
}
