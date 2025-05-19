<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserAccomplishment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'title',
        'issued_on',
        'url',
        'description',
        'files',
    ];

    protected $casts = [
        'files' => 'array',
        'issued_on' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
