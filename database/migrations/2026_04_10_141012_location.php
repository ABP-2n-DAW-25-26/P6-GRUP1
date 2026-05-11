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
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->string('name',255);
            $table->string('latitude',255)->nullable();
            $table->string('longitude',255)->nullable();
            $table->enum('question_type', ['open', 'multiple_choice', 'true_false', 'photo'])->nullable();
            $table->string('statement')->nullable();
            $table->string('answer')->nullable();
            $table->string('correct_answer')->nullable();
            $table->string('file')->nullable();
            $table->integer('order')->nullable();
            $table->enum('type', ['post', 'interest_point', 'guided_visit', 'gimcana'])->default('post');
            $table->string('activity_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('locations');
    }
};
