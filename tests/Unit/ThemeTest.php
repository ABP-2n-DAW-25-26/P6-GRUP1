<?php

use App\Models\Theme;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

pest()->extend(TestCase::class)->use(RefreshDatabase::class)->in(__DIR__);

// Theme can be created and saved
it('creates a theme', function () {
    $theme = new Theme();
    $theme->name = 'Aurora';
    $theme->primary = '#111111';
    $theme->primary_dark = '#222222';
    $theme->secondary = '#333333';
    $theme->text = '#444444';
    $theme->text_secondary = '#555555';
    $theme->background = '#666666';
    $theme->background_card = '#777777';
    $theme->save();

    expect($theme->id)->toBeGreaterThan(0);
});

// Theme stores the name value
it('stores a theme name', function () {
    $theme = new Theme();
    $theme->name = 'Solar';
    $theme->primary = '#101010';
    $theme->primary_dark = '#202020';
    $theme->secondary = '#303030';
    $theme->text = '#404040';
    $theme->text_secondary = '#505050';
    $theme->background = '#606060';
    $theme->background_card = '#707070';
    $theme->save();

    expect($theme->name)->toBe('Solar');
});

// Theme stores color values
it('stores color palette values', function () {
    $theme = new Theme();
    $theme->name = 'Deep Sea';
    $theme->primary = '#0a4d68';
    $theme->primary_dark = '#073648';
    $theme->secondary = '#05bfdb';
    $theme->text = '#0b0b0b';
    $theme->text_secondary = '#4b4b4b';
    $theme->background = '#f5f7fa';
    $theme->background_card = '#ffffff';
    $theme->save();

    expect($theme->primary)->toBe('#0a4d68');
    expect($theme->background_card)->toBe('#ffffff');
});