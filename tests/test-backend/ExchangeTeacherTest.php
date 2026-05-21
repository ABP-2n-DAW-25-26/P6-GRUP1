<?php

use App\Models\Exchange;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

// The endpoint should return all teachers linked to a given exchange
test('It retrieves teachers associated with an exchange', function () {
    $exchange = Exchange::factory()->create();

    $teacherA = User::factory()->create(['role' => 'teacher']);
    $teacherB = User::factory()->create(['role' => 'teacher']);

    $exchange->users()->attach([$teacherA->id, $teacherB->id]);

    $response = $this->get(route('exchange-teacher.index', $exchange));

    $response->assertOk();

    $response->assertInertia(fn ($page) =>
        $page->component('teacher/TeachersList')
            ->has('teachers', 2)
    );
});

// The search should only return users with role "teacher" matching the input text
test('Search only returns teachers that match the query string', function () {
    User::factory()->create(['name' => 'Anna Smith', 'role' => 'teacher']);
    User::factory()->create(['name' => 'John Doe', 'role' => 'teacher']);
    User::factory()->create(['name' => 'Student Example', 'role' => 'student']);

    $response = $this->getJson(route('exchange-teacher.searchAJAX', [
        'query' => 'Anna'
    ]));

    $response->assertOk()
        ->assertJsonCount(1, 'teachers')
        ->assertJsonFragment(['name' => 'Anna Smith']);
});

// If an exchange is provided, already assigned teachers should not appear in results
test('Search excludes teachers already linked to the exchange', function () {
    $exchange = Exchange::factory()->create();

    $teacher = User::factory()->create(['role' => 'teacher']);
    $exchange->users()->attach($teacher->id);

    $response = $this->getJson(route('exchange-teacher.searchAJAX', [
        'query' => '',
        'exchangeId' => $exchange->id
    ]));

    $response->assertOk();

    $response->assertJsonMissing([
        'id' => $teacher->id
    ]);
});


// The request should fail when no user_id is provided
test('It returns an error when user_id is missing', function () {
    $exchange = Exchange::factory()->create();

    $response = $this->postJson(route('exchange-teacher.store', $exchange), []);

    $response->assertStatus(422);
});

// A teacher can be assigned through the assign endpoint using query parameters
test('It assigns a teacher successfully via assign endpoint', function () {
    $exchange = Exchange::factory()->create();
    $teacher = User::factory()->create(['role' => 'teacher']);

    $response = $this->getJson(route('exchange-teacher.assign', [
        'exchange' => $exchange->id,
        'user_id' => $teacher->id,
    ]));

    $response->assertOk();

    $this->assertDatabaseHas('exchange_user', [
        'exchange_id' => $exchange->id,
        'user_id' => $teacher->id,
    ]);
});