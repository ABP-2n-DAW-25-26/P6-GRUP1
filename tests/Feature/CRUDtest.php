<?php

use App\Models\Exchange;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

describe('User CRUD Operations', function () {
    test('can create a user', function () {
        $userData = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => bcrypt('password123'),
        ];

        $user = User::create($userData);

        expect($user)->toBeInstanceOf(User::class);
        expect($user->name)->toBe('John Doe');
        expect($user->email)->toBe('john@example.com');
        expect($user->id)->not->toBeNull();
    });

    test('can read a user', function () {
        $user = User::factory()->create([
            'name' => 'Jane Smith',
            'email' => 'jane@example.com',
        ]);

        $retrievedUser = User::find($user->id);

        expect($retrievedUser)->not->toBeNull();
        expect($retrievedUser->name)->toBe('Jane Smith');
        expect($retrievedUser->email)->toBe('jane@example.com');
    });

    test('can update a user', function () {
        $user = User::factory()->create([
            'name' => 'Original Name',
            'email' => 'original@example.com',
        ]);

        $user->update([
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
        ]);

        expect($user->name)->toBe('Updated Name');
        expect($user->email)->toBe('updated@example.com');
    });

    test('can delete a user', function () {
        $user = User::factory()->create();
        $userId = $user->id;

        $user->delete();

        expect(User::find($userId))->toBeNull();
    });

    test('can retrieve all users', function () {
        User::factory()->count(3)->create();

        $users = User::all();

        expect($users)->toHaveCount(3);
    });

    test('user has exchanges relationship', function () {
        $user = User::factory()->create();
        Exchange::factory()->count(2)->create(['user_id' => $user->id]);

        expect($user->exchanges)->toHaveCount(2);
    });
});
