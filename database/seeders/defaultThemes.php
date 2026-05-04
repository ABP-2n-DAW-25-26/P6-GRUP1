<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class defaultThemes extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $themes = [
            [
                'name' => 'Hipatia',
                'primary' => '#008680',
                'primary_dark' => '#004238',
                'secondary' => '#4B645F',
                'text' => '#2A3432',
                'text_secondary' => '#58615F',
                'background' => '#F6FAF8',
                'background_card' => '#FFFFFF',
                'default' => true,
            ],
            [
                'name' => 'Mar i Sorra',
                'primary' => '#0F5E9C',
                'primary_dark' => '#083A5B',
                'secondary' => '#F2C57C',
                'text' => '#1D2B36',
                'text_secondary' => '#4B5B66',
                'background' => '#F7F5EF',
                'background_card' => '#FFFFFF',
                'default' => true,
            ],
            [
                'name' => 'Bosc i Terra',
                'primary' => '#3B7A57',
                'primary_dark' => '#24483A',
                'secondary' => '#C26D4A',
                'text' => '#2B2F2E',
                'text_secondary' => '#5A5F5E',
                'background' => '#F4F1ED',
                'background_card' => '#FFFFFF',
                'default' => true,
            ],
        ];

        foreach ($themes as $theme) {
            \App\Models\Theme::create($theme);
        }
    }
}
