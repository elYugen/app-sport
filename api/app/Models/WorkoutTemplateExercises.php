<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkoutTemplateExercises extends Model
{
    protected $table = "workout_template_exercises";

    protected $fillable= [
        'template_id',
        'exercise_id',
        'repetitions',
        'sets',
    ];

    public function template()
    {
        return $this->belongsTo(WorkoutTemplates::class, 'template_id');
    }

    public function exercise()
    {
        return $this->belongsTo(Exercises::class, 'exercise_id');
    }
}
