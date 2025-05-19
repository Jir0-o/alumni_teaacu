<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employment extends Model
{
        protected $fillable = [
        'user_id', 'organization', 'designation', 'department', 'duration',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
