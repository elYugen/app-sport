<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Measurements extends Model
{
    protected $table = "measurements";

    protected $hidden = [
        'user_id'
    ];

    protected $fillable = [
        'user_id',
        'weight',
        'waist',
        'hips',
        'chest',
        'deleted'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
