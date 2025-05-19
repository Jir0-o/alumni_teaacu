<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FundAllotment extends Model
{
    use HasFactory;
    protected $table = 'fund_allotments';

    protected $fillable = [
        'fund_id',
        'person_id',
        'date',
        'amount',
    ];
}

