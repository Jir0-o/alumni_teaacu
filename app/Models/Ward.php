<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ward extends Model
{
    use HasFactory;
    protected $fillable = [
        'ward_name',
        'ward_is_active',
        'uni_id'
        ];
    public function unions()
    {
        return $this->hasOne(Union::class);
    }
    public function villages()
    {
        return $this->hasMany(Village::class);
    }
}
