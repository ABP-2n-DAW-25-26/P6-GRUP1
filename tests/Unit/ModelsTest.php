<?php

use App\Models\Activity;
use App\Models\Exchange;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

pest()->extend(TestCase::class)->use(RefreshDatabase::class)->in(__DIR__);

test('user can be created', function () {
    $user = User::factory()->create();
    expect($user->id)->toBeGreaterThan(0);
});

test('user has an email', function () {
    $user = User::factory()->create(['email' => 'test@example.com']);
    expect($user->email)->toBe('test@example.com');
});

test('user has a role assigned', function () {
    $user = User::factory()->create(['role' => 'teacher']);
    expect($user->role)->toBe('teacher');
});

test('exchange can be created', function () {
    $exchange = new Exchange([
        'origin' => 'Barcelona',
        'destiny' => 'Paris',
        'title' => 'Test Exchange',
        'color' => '#FF5733',
        'start_date' => now(),
        'end_date' => now()->addDays(7),
        'user_id' => 1,
    ]);
    $exchange->save();
    expect($exchange->id)->toBeGreaterThan(0);
});

test('exchange has a title', function () {
    $exchange = new Exchange([
        'origin' => 'Barcelona',
        'destiny' => 'Paris',
        'title' => 'My Exchange',
        'color' => '#FF5733',
        'start_date' => now(),
        'end_date' => now()->addDays(7),
        'user_id' => 1,
    ]);
    $exchange->save();
    expect($exchange->title)->toBe('My Exchange');
});

test('exchange belongs to a user', function () {
    $user = User::factory()->create();
    $exchange = new Exchange([
        'origin' => 'Barcelona',
        'destiny' => 'Paris',
        'title' => 'User Exchange',
        'color' => '#FF5733',
        'start_date' => now(),
        'end_date' => now()->addDays(7),
        'user_id' => $user->id,
    ]);
    $exchange->save();
    expect($exchange->user_id)->toBe($user->id);
});

test('exchange has origin and destination cities', function () {
    $exchange = new Exchange([
        'origin' => 'Barcelona',
        'destiny' => 'Paris',
        'title' => 'Cities Exchange',
        'color' => '#FF5733',
        'start_date' => now(),
        'end_date' => now()->addDays(7),
        'user_id' => 1,
    ]);
    $exchange->save();
    expect($exchange->origin)->toBe('Barcelona');
    expect($exchange->destiny)->toBe('Paris');
});

test('activity can be created', function () {
    $activity = new Activity([
        'title' => 'Test Activity',
        'description' => 'Test Description',
        'start_date' => now(),
        'end_date' => now()->addHours(2),
        'type' => 'post',
        'exchange_id' => 1,
    ]);
    $activity->save();
    expect($activity->id)->toBeGreaterThan(0);
});

test('activity has a title', function () {
    $activity = new Activity([
        'title' => 'Activity One',
        'description' => 'Test',
        'start_date' => now(),
        'end_date' => now()->addHours(2),
        'type' => 'post',
        'exchange_id' => 1,
    ]);
    $activity->save();
    expect($activity->title)->toBe('Activity One');
});

test('activity belongs to an exchange', function () {
    $user = User::factory()->create();
    $exchange = new Exchange([
        'origin' => 'Barcelona',
        'destiny' => 'Paris',
        'title' => 'Activity Exchange',
        'color' => '#FF5733',
        'start_date' => now(),
        'end_date' => now()->addDays(7),
        'user_id' => $user->id,
    ]);
    $exchange->save();

    $activity = new Activity([
        'title' => 'Activity Two',
        'description' => 'Test',
        'start_date' => now(),
        'end_date' => now()->addHours(2),
        'type' => 'post',
        'exchange_id' => $exchange->id,
    ]);
    $activity->save();
    expect($activity->exchange_id)->toBe($exchange->id);
});

test('activity has a type classification', function () {
    $activity = new Activity([
        'title' => 'Post Activity',
        'description' => 'Test',
        'start_date' => now(),
        'end_date' => now()->addHours(2),
        'type' => 'post',
        'exchange_id' => 1,
    ]);
    $activity->save();
    expect($activity->type)->toBe('post');
});
