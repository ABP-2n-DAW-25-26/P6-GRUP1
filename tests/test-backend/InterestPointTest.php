<?php

use App\Models\Activity;
use App\Models\Exchange;
use App\Models\User;

test('teacher can delete an interest point', function () {
    $teacher = User::factory()->create(['role' => 'teacher']);
    $exchange = Exchange::factory()->create();

    $activity = Activity::factory()->create([
        'exchange_id' => $exchange->id,
        'type' => 'interest_point',
    ]);

    $response = $this->actingAs($teacher)
        ->delete(route('exchange.interestpoint.destroy', [
            'exchange' => $exchange->id,
            'id' => $activity->id,
        ]));

    $response->assertRedirect(route('exchange.show', $exchange->id));
    $this->assertDatabaseMissing('activities', ['id' => $activity->id]);
});

test('interest point update validates coordinates', function () {
    $teacher = User::factory()->create(['role' => 'teacher']);
    $exchange = Exchange::factory()->create();
    $activity = Activity::factory()->create([
        'exchange_id' => $exchange->id,
        'type' => 'interest_point',
    ]);

    $response = $this->actingAs($teacher)
        ->put(route('exchange.interestpoint.update', [
            'exchange' => $exchange->id,
            'id' => $activity->id,
        ]), [
            'title' => 'Updated',
            'latitude' => 'not-a-number',
            'longitude' => 'not-a-number',
        ]);

    $response->assertSessionHasErrors(['latitude', 'longitude']);
});

test('interest point can be updated', function () {
    $teacher = User::factory()->create(['role' => 'teacher']);
    $exchange = Exchange::factory()->create();
    $activity = Activity::factory()->create([
        'exchange_id' => $exchange->id,
        'type' => 'interest_point',
    ]);

    $this->actingAs($teacher)
        ->put(route('exchange.interestpoint.update', [
            'exchange' => $exchange->id,
            'id' => $activity->id,
        ]), [
            'title' => 'Nou títol',
            'latitude' => '41.3851',
            'longitude' => '2.1734',
        ]);

    $this->assertDatabaseHas('activities', [
        'id' => $activity->id,
        'title' => 'Nou títol',
    ]);
});