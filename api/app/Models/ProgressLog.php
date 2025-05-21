<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgressLog extends Model
{

    protected $table = "progress_logs";

    protected $fillable = [
        'user_id',
        'exercise_id',
        'weight_used',
        'repetitions',
        'sets',
        'notes'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
