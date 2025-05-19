<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'cipsMemberId',
        'designation',
        'committee_id',
        'committee_type',
        'priority',
    ];

    public function committee()
    {
        return $this->belongsTo(Committee::class);
    }
}
