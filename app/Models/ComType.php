<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComType extends Model
{
    use HasFactory;
    protected $table = 'com_types';
    protected $fillable = [
        'type_name',
    ];

    public function committee()
    {
        return $this->hasOne(Committee::class);
    }
}
