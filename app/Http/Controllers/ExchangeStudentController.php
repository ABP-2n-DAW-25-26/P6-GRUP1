<?php

namespace App\Http\Controllers;

use App\Models\Exchange;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ExchangeStudentController extends Controller
{
    public function index(Exchange $exchange)
    {
        $students = $exchange->users()->where('role', 'student')->get();
        return inertia('teacher/StudentsList', [
            'exchange' => $exchange,
            'students' => $students,
        ]);
    }
}
