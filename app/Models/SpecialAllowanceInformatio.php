<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpecialAllowanceInformatio extends Model
{
    use HasFactory;
    protected $table = 'special_allowance_informatios';

    protected $fillable = [
        'person_id',
        'allowance_name',
        'frequency',
        'amount'
    ];
}
