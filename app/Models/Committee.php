<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Committee extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'from',
        'isActive',
        'to',
    ];

    public function members()
    {
        return $this->hasMany(Member::class);
    }
}
