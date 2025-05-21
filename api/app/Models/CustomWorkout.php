<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomWorkout extends Model
{
    protected $table = "custom_workouts";

    protected $fillable = [
        'user_id',
        'name',
        'description'
    ];

    // relation avec les exercices via la table pivot
    public function workoutExercises()
    {
        return $this->hasMany(CustomWorkoutExercises::class, 'workout_id');
    }

    // relation many-to-many avec les exercices
    public function exercises()
    {
        return $this->belongsToMany(Exercises::class, 'custom_workout_exercises', 'workout_id', 'exercise_id')
                    ->withPivot('repetitions', 'sets')
                    ->withTimestamps();
    }
}
