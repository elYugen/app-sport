<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exercises extends Model
{
    protected $table = "exercises";

    protected $fillable = [
        'name',
        'description',
        'images',
        'type'
    ];

    public function templateExercises()
    {
        return $this->hasMany(WorkoutTemplateExercises::class, 'exercise_id');
    }

    public function workoutTemplates()
    {
        return $this->belongsToMany(WorkoutTemplates::class, 'workout_template_exercises', 'exercise_id', 'template_id')
                    ->withPivot('repetitions', 'sets', 'duration')
                    ->withTimestamps();
    }
    
    public function progressLogs()
    {
        return $this->hasMany(ProgressLog::class);
    }
}
