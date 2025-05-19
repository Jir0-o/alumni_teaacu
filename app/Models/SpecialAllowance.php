<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpecialAllowance extends Model
{
    use HasFactory;

    protected $table = 'special_allowances';

    protected $fillable = [
        'name',
        'frequency',
        'amount'
    ];
}
