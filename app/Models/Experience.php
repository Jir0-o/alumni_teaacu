<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    use HasFactory;
    protected $fillable = [
        'institute_name',
        'position',
        'joined_year',
        'retirement_year',
        'person_id',
    ];
}
