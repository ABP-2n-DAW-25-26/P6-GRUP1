<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\SocialAuthController;
use App\Http\Controllers\CSVController;
use App\Http\Controllers\ExchangeController;
use App\Http\Controllers\ExchangeStudentController;
use App\Http\Controllers\ExchangeTeacherController;
use App\Http\Controllers\GimcanaController;
use App\Http\Controllers\GuidedActivityController;
use App\Http\Controllers\InterestPointController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\ThemeController;
use App\Http\Controllers\TranslationController;
use Illuminate\Support\Facades\Route;

Route::inertia('/', 'Home')->name('home');
Route::inertia('/privacy', 'Privacy')->name('privacy');

// OAuth — Google (restringit a @cendrassos.net)
Route::get('/auth/gmail', [SocialAuthController::class, 'redirectToGoogle'])->name('auth.gmail');
Route::get('/auth/gmail/callback', [SocialAuthController::class, 'handleGoogleCallback'])->name('auth.gmail.callback');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('schedule', [ScheduleController::class, 'index'])->name('schedule');

    Route::resource('exchange', ExchangeController::class);
    Route::resource('exchange.student', ExchangeStudentController::class);
    Route::get('/download-csv', [CSVController::class, 'downloadCsvTemplate'])->name('downloadCSV');
    Route::post('/import-csv', [CSVController::class, 'importCSV'])->name('importCSV');
    Route::get('/teacher/search', [ExchangeTeacherController::class, 'searchAJAX'])->name('exchange.teacher.search');
    Route::get('/exchange/{exchange}/teacher/assign', [ExchangeTeacherController::class, 'assign'])->name('exchange.teacher.assign');
    Route::get('/exchange/{exchange}/teacher/delete', [ExchangeTeacherController::class, 'delete'])->name('exchange.teacher.delete');
    Route::resource('exchange.teacher', ExchangeTeacherController::class);
    Route::resource('exchange.post', PostController::class);
    Route::resource('exchange.guidedactivity', GuidedActivityController::class);
    Route::resource('exchange.gimcana', GimcanaController::class);
    Route::resource('exchange.interestpoint', InterestPointController::class);
    Route::get('theme/search', [ThemeController::class, 'search'])->name('theme.search');
    Route::resource('theme', ThemeController::class);

    Route::get('notifications', [NotificationController::class, 'index'])->name('notifications');
    Route::post('notifications/{notification}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.readAll');
});
Route::inertia('teacher', 'teacher/TeacherPanel')->name('teacher');
Route::resource('admin', AdminController::class);

Route::post('/api/translate', [TranslationController::class, 'translatePage']);

require __DIR__.'/settings.php';
