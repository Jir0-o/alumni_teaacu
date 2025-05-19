<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeadershipMessage extends Model
{
    protected $fillable = [
        'vc_message', 'vc_image',
        'president_message', 'president_image',
        'advisor_message', 'advisor_image',
    ];
}
