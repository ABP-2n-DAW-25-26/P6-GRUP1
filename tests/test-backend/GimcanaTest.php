<?php

use App\Models\Activity;
use App\Models\Exchange;
use App\Models\User;

test('teacher can delete a gimcana', function () {
    $teacher = User::factory()->create(['role' => 'teacher']);
    $exchange = Exchange::factory()->create();

    $gimcana = Activity::factory()->create([
        'exchange_id' => $exchange->id,
        'type' => 'gimcana',
    ]);

    $response = $this->actingAs($teacher)
        ->delete(route('exchange.gimcana.destroy', [
            'exchange' => $exchange->id,
            'id' => $gimcana->id,
        ]));

    $response->assertRedirect(route('exchange.show', $exchange->id));
    $this->assertDatabaseMissing('activities', ['id' => $gimcana->id]);
});

test('deleting a gimcana also deletes its locations', function () {
    $teacher = User::factory()->create(['role' => 'teacher']);
    $exchange = Exchange::factory()->create();

    $gimcana = Activity::factory()->create([
        'exchange_id' => $exchange->id,
        'type' => 'gimcana',
    ]);

    \App\Models\Locations::factory()->create(['activity_id' => $gimcana->id]);

    $this->actingAs($teacher)
        ->delete(route('exchange.gimcana.destroy', [
            'exchange' => $exchange->id,
            'id' => $gimcana->id,
        ]));

    $this->assertDatabaseMissing('locations', ['activity_id' => $gimcana->id]);
});