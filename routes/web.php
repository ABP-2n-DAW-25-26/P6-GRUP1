<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use App\Http\Controllers\ExchangeController;
use App\Http\Controllers\GuidedActivityController;

use App\Http\Controllers\activityController;

Route::inertia('/', 'Welcome', [
    'canRegister' => Features::enabled(Features::registration()),
])->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('dashboard', 'Dashboard')->name('dashboard');
});

Route::resource('exchange', ExchangeController::class);
Route::resource('guidedactivity', GuidedActivityController::class);

// PROFE
Route::resource('professor/intercanvi/{id}', activityController::class);

require __DIR__.'/settings.php';
