<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LanguageProficiency extends Model
{
    protected $fillable = [
        'user_id',
        'language',
        'speaking',
        'writing',
        'reading',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

