<?php

use App\Models\Activity;
use App\Models\Exchange;
use App\Models\User;

test('teacher can delete a guided activity', function () {
    $teacher = User::factory()->create(['role' => 'teacher']);
    $exchange = Exchange::factory()->create();
    $exchange->users()->attach($teacher->id, ['role' => 'teacher']);

    $activity = Activity::factory()->create([
        'exchange_id' => $exchange->id,
        'type' => 'guided_visit',
    ]);

    $response = $this->actingAs($teacher)
        ->delete(route('exchange.guidedactivity.destroy', [
            'exchange' => $exchange->id,
            'id' => $activity->id,
        ]));

    $response->assertRedirect(route('exchange.show', $exchange->id));
    $this->assertDatabaseMissing('activities', ['id' => $activity->id]);
});

test('guest cannot delete a guided activity', function () {
    $exchange = Exchange::factory()->create();
    $activity = Activity::factory()->create([
        'exchange_id' => $exchange->id,
        'type' => 'guided_visit',
    ]);

    $this->delete(route('exchange.guidedactivity.destroy', [
        'exchange' => $exchange->id,
        'id' => $activity->id,
    ]))->assertRedirect(route('login'));

    $this->assertDatabaseHas('activities', ['id' => $activity->id]);
});

test('cannot delete guided activity from another exchange', function () {
    $teacher = User::factory()->create(['role' => 'teacher']);
    $exchange = Exchange::factory()->create();
    $otherExchange = Exchange::factory()->create();

    $activity = Activity::factory()->create([
        'exchange_id' => $otherExchange->id,
        'type' => 'guided_visit',
    ]);

    $this->actingAs($teacher)
        ->delete(route('exchange.guidedactivity.destroy', [
            'exchange' => $exchange->id,
            'id' => $activity->id,
        ]))->assertNotFound();

    $this->assertDatabaseHas('activities', ['id' => $activity->id]);
});

test('edit guided activity returns correct view', function () {
    $teacher = User::factory()->create(['role' => 'teacher']);
    $exchange = Exchange::factory()->create();
    $activity = Activity::factory()->create([
        'exchange_id' => $exchange->id,
        'type' => 'guided_visit',
    ]);

    $response = $this->actingAs($teacher)
        ->get(route('exchange.guidedactivity.edit', [
            'exchange' => $exchange->id,
            'id' => $activity->id,
        ]));

    $response->assertOk();
    $response->assertInertia(fn ($page) => $page
        ->component('Activities/EditGuidedActivity')
        ->has('activity')
        ->has('exchange')
    );
});