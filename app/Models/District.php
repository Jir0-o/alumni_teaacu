<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use HasFactory;

    protected $fillable = [
        'dis_name',
        'dis_is_active',
        'div_id'
    ];

    public function divisions()
    {
        return $this->hasOne(Division::class);
    }
    public function thanas()
    {
        return $this->hasMany(Thana::class);
    }
}
