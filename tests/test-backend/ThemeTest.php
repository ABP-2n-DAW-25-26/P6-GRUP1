<?php

use App\Models\Theme;
use App\Models\User;

function createTheme(array $overrides = []): Theme
{
	return Theme::forceCreate(array_merge([
		'name' => 'Default Theme',
		'primary' => '#111111',
		'primary_dark' => '#222222',
		'secondary' => '#333333',
		'text' => '#444444',
		'text_secondary' => '#555555',
		'background' => '#666666',
		'background_card' => '#777777',
	], $overrides));
}

// Unauthenticated user is redirected to login
test('theme list requires authentication', function () {
	$response = $this->get(route('theme.index'));

	$response->assertRedirect(route('login'));
});

// Authenticated user can access the theme list page
test('authenticated user can view theme list', function () {
	$user = User::factory()->create();

	$response = $this->actingAs($user)
		->get(route('theme.index'));

	$response->assertOk();
	$response->assertInertia(fn ($page) => $page
		->component('Themes')
		->has('theme')
	);
});

// Theme is persisted to the database with correct data
test('theme can be created', function () {
	$user = User::factory()->create();

	$response = $this->actingAs($user)
		->post(route('theme.store'), [
			'name' => 'Ocean',
			'primary' => '#0a4d68',
			'primary_dark' => '#073648',
			'secondary' => '#05bfdb',
			'text' => '#0b0b0b',
			'text_secondary' => '#4b4b4b',
			'background' => '#f5f7fa',
			'background_card' => '#ffffff',
		]);

	$response->assertRedirect(route('theme.index'));
	$this->assertDatabaseHas('themes', ['name' => 'Ocean']);
});

// Theme creation validates required fields
test('theme creation validates required fields', function () {
	$user = User::factory()->create();

	$response = $this->actingAs($user)
		->post(route('theme.store'), [
			'name' => '',
			'primary' => '',
			'primary_dark' => '',
			'secondary' => '',
			'text' => '',
			'text_secondary' => '',
			'background' => '',
			'background_card' => '',
		]);

	$response->assertSessionHasErrors([
		'name',
		'primary',
		'primary_dark',
		'secondary',
		'text',
		'text_secondary',
		'background',
		'background_card',
	]);
});

// Theme can be updated with new values
test('theme can be updated', function () {
	$user = User::factory()->create();
	$theme = createTheme(['name' => 'Sunset']);

	$response = $this->actingAs($user)
		->put(route('theme.update', $theme->id), [
			'name' => 'Sunrise',
			'primary' => '#112233',
			'primary_dark' => '#223344',
			'secondary' => '#334455',
			'text' => '#445566',
			'text_secondary' => '#556677',
			'background' => '#667788',
			'background_card' => '#778899',
		]);

	$response->assertRedirect(route('theme.index'));
	$this->assertDatabaseHas('themes', ['id' => $theme->id, 'name' => 'Sunrise']);
});
