<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExchangeController;
use App\Http\Controllers\GuidedActivityController;
use App\Http\Controllers\AddUsersController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\Auth\SocialAuthController;

Route::inertia('/', 'Home')->name('home');

// OAuth — Google (restringit a @cendrassos.net)
Route::get('/auth/gmail', [SocialAuthController::class, 'redirectToGoogle'])->name('auth.gmail');
Route::get('/auth/gmail/callback', [SocialAuthController::class, 'handleGoogleCallback'])->name('auth.gmail.callback');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('schedule', [ScheduleController::class, 'index'])->name('schedule');
    
    // PROFE
    Route::resource('exchange', ExchangeController::class);
    Route::get('exchanges', [ExchangeController::class, 'list'])->name('exchange.list');
    Route::resource('exchange.addUser', AddUsersController::class);
    Route::resource('exchange.post', PostController::class);
    Route::resource('exchange.guidedactivity', GuidedActivityController::class);
});


Route::inertia('notifications', 'Notifications')->name('notifications');
Route::inertia('teacher', 'teacher/TeacherPanel')->name('teacher');

require __DIR__.'/settings.php';
