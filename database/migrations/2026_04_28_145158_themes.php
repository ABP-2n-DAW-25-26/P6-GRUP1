<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('themes', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('primary', 7);
            $table->string('primary_dark', 7);
            $table->string('secondary', 7);
            $table->string('text', 7);
            $table->string('text_secondary', 7);
            $table->string('background', 7);
            $table->string('background_card', 7);
            $table->boolean('default')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('themes');

    }
};
