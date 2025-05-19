<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Union extends Model
{
    use HasFactory;
    protected $fillable = [
        'uni_name',
        'uni_is_active',
        'thana_id'
        ];
    public function thanas()
    {
        return $this->hasOne(Thana::class);
    }
    public function wards()
    {
        return $this->hasMany(Ward::class);
    }
}
