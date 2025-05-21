<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomWorkoutExercises extends Model
{
    protected $table = "custom_workout_exercises";

    protected $fillable= [
        'workout_id',
        'exercise_id',
        'repetitions',
        'sets',
    ];

    public function workout()
    {
        return $this->belongsTo(CustomWorkout::class, 'workout_id');
    }

    public function exercise()
    {
        return $this->belongsTo(Exercises::class, 'exercise_id');
    }
}
