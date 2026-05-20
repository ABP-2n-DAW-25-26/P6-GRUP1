<?php

use App\Models\Exchange;
use App\Models\User;

// Unauthenticated user is redirected to login
test('Exchange list requires authentication', function () {
    $response = $this->get(route('exchange.index'));

    $response->assertRedirect(route('login'));
});

// Authenticated user can access the exchange list page
test('Authenticated user can view the exchange list', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->get(route('exchange.index'));

    $response->assertOk();
});

// Exchange is persisted to the database with correct data
test('An exchange can be created in the database', function () {
    $user = User::factory()->create();

    $exchange = Exchange::create([
        'origin'     => 'Estonia',
        'destiny'    => 'España',
        'start_date' => '2026-06-01 08:00:00',
        'end_date'   => '2026-06-10 18:00:00',
        'title'      => 'Exchange Paris',
        'color'      => '#FF5733',
        'user_id'    => $user->id,
    ]);

    expect($exchange)->toBeInstanceOf(Exchange::class);
    expect($exchange->origin)->toBe('Estonia');
    $this->assertDatabaseHas('exchanges', ['origin' => 'Estonia', 'destiny' => 'España']);
});

// Deleted exchange no longer exists in the database
test('An exchange can be deleted from the database', function () {
    $user = User::factory()->create();

    $exchange = Exchange::create([
        'origin'     => 'Estonia',
        'destiny'    => 'España',
        'start_date' => '2026-07-01 08:00:00',
        'user_id'    => $user->id,
    ]);

    $id = $exchange->id;
    $exchange->delete();

    $this->assertDatabaseMissing('exchanges', ['id' => $id]);
});
