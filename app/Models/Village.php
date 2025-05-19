<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Village extends Model
{
    use HasFactory;
    protected $fillable = [
        'village_name',
        'village_is_active',
        'ward_id'
        ];
    public function wards()
    {
        return $this->hasOne(Ward::class);
    }
    public function mohollas()
    {
        return $this->hasMany(Moholla::class);
    }
}
