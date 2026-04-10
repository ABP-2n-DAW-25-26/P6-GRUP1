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
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->string('title',255);
            $table->string('description')->nullable();
            $table->dateTime('start_date');
            $table->dateTime('end_date')->nullable();
            $table->string('latitude',255)->nullable();
            $table->string('longitude',255)->nullable();
            $table->enum('type', ['post', 'interest_point', 'guided_visit', 'gimcana'])->default('post');
            $table->string('file')->nullable();
            $table->string('exchange_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};
