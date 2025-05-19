<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PopupNotice extends Model
{
    protected $fillable = [
        'start_date',
        'end_date',
        'image',
        'is_active',
    ];
}
