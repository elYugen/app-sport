<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkoutTemplates extends Model
{
    protected $table = "workout_templates";

    protected $fillable= [
        'name',
        'description',
        'level',
        'cover',
        'duration'
    ];

    // relation avec les exercices via la table pivot
    public function templateExercises()
    {
        return $this->hasMany(WorkoutTemplateExercises::class, 'template_id');
    }

    // relation many-to-many avec les exercices
    public function exercises()
    {
        return $this->belongsToMany(Exercises::class, 'workout_template_exercises', 'template_id', 'exercise_id')
                    ->withPivot('repetitions', 'sets')
                    ->withTimestamps();
    }
}
