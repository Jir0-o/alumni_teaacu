<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Holding extends Model
{
    use HasFactory;
    protected $fillable = [
        'hold_name',
        'hold_is_active',
        'moholla_id'
        ];
    public function mohollas()
    {
        return $this->hasOne(Moholla::class);
    }
    public function families()
    {
        return $this->hasMany(Family::class);
    }
}
