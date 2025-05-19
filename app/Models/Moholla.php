<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Moholla extends Model
{
    use HasFactory;
    protected $fillable = [
        'moholla_name',
        'moholla_is_active',
        'village_id'
        ];
    public function villages()
    {
        return $this->hasOne(Village::class);
    }
    public function holdings()
    {
        return $this->hasMany(Holding::class);
    }
}
