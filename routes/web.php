<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use App\Http\Controllers\ExchangeController;
use App\Http\Controllers\GuidedActivityController;
use App\Http\Controllers\AddUsersController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\ActivityController;

Route::inertia('/', 'Welcome', [
    'canRegister' => Features::enabled(Features::registration()),
])->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('schedule', [ScheduleController::class, 'index'])->name('schedule');
});

// PROFE
Route::get('exchange/{id}', [ActivityController::class, 'index'])->name('activity.index');
Route::resource('exchange.addUser', AddUsersController::class);

Route::resource('exchange', ExchangeController::class);
Route::resource('guidedactivity', GuidedActivityController::class);
Route::inertia('notifications', 'Notifications')->name('notifications');
Route::inertia('teacher', 'teacher/TeacherPanel')->name('teacher');

require __DIR__.'/settings.php';
