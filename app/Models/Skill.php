<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'learned_by',
    ];

    protected $casts = [
        'learned_by' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

