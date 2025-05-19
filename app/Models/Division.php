<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    use HasFactory;

    protected $fillable = [
        'div_name',
        'div_is_active'
    ];

    public function districts()
    {
        return $this->hasMany(District::class);
    }
}
