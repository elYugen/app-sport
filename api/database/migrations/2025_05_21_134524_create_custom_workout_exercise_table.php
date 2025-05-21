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
        Schema::create('custom_workout_exercise', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('workout_id');
            $table->foreign('workout_id')->references('id')->on('custom_workouts');
            $table->unsignedBigInteger('exercise_id');
            $table->foreign('exercise_id')->references('id')->on('exercises');
            $table->integer('repetitions');
            $table->integer('sets'); // nombre de fois ou l'exo doit être fait
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('custom_workout_exercise');
    }
};
