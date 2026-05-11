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
        Schema::create('translation_caches', function (Blueprint $table) {
            $table->id();
            $table->string('lang', 10);
            $table->string('url');
            $table->string('original', 500);
            $table->text('translated');
            $table->timestamps();
            $table->unique(['lang', 'url', 'original'], 'translation_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('translation_caches');
    }
};
