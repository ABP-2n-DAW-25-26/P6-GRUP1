<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExchangeController;
use App\Http\Controllers\GuidedActivityController;
use App\Http\Controllers\GimcanaController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\InterestPointController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ExchangeTeacherController;
use App\Http\Controllers\ExchangeStudentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\Auth\SocialAuthController;
use App\Http\Controllers\CSVController;
use App\Http\Controllers\ThemeController;
use App\Mail\StudentCredentialsMail;
use Illuminate\Support\Facades\Mail;

Route::inertia('/', 'Home')->name('home');

// OAuth — Google (restringit a @cendrassos.net)
Route::get('/auth/gmail', [SocialAuthController::class, 'redirectToGoogle'])->name('auth.gmail');
Route::get('/auth/gmail/callback', [SocialAuthController::class, 'handleGoogleCallback'])->name('auth.gmail.callback');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('schedule', [ScheduleController::class, 'index'])->name('schedule');

    // PROFE
    Route::resource('exchange', ExchangeController::class);
    Route::get('exchanges', [ExchangeController::class, 'list'])->name('exchange.list');
    Route::resource('exchange.student', ExchangeStudentController::class);
    Route::get('/download-csv', [CSVController::class, 'downloadCsvTemplate'])->name('downloadCSV');
    Route::post('/import-csv', [CSVController::class, 'importCSV'])->name('importCSV');
    Route::resource('exchange.teacher', ExchangeTeacherController::class);
    Route::get('/teacher/search', [ExchangeTeacherController::class, 'searchAJAX'])->name('exchange.teacher.search');
    Route::post('/exchange/{exchange}/teacher/assign', [ExchangeTeacherController::class, 'assign'])->name('exchange.teacher.assign');
    Route::resource('exchange.post', PostController::class);
    Route::resource('exchange.guidedactivity', GuidedActivityController::class);
    Route::resource('exchange.gimcana', GimcanaController::class);
    Route::resource('exchange.interestpoint', InterestPointController::class);
    // Route::resource('exchange.gimcana', controlador gimcana resource::class);
    Route::resource('theme', ThemeController::class);

    Route::get('/test-mail', function () {
        Mail::to('ybakouh@cendrassos.net')->send(new StudentCredentialsMail('ybakouh@cendrassos.net', '12345678'));
        return 'Correo enviado';
    });

    // Route::get('/exchange/{exchangeId}/addTeacher/{teacherId}', [TeacherController::class, 'addTeacherToExchange'])->name('teacher.addToExchange');
    // Route::get('/exchange/{exchangeId}/teachers', [TeacherController::class, 'getExchangeTeachers'])->name('exchange.teachers');
    // Route::delete('/exchange/{exchangeId}/removeTeacher/{teacherId}', [TeacherController::class, 'removeTeacherFromExchange'])->name('teacher.removeFromExchange');
});


Route::resource('guidedactivity', GuidedActivityController::class);
Route::resource('interestpoint', InterestPointController::class);
Route::inertia('notifications', 'Notifications')->name('notifications');
Route::inertia('teacher', 'teacher/TeacherPanel')->name('teacher');
Route::resource('admin', AdminController::class);

require __DIR__ . '/settings.php';
