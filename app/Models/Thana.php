<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Thana extends Model
{
    use HasFactory;
    
    protected $fillable = [
    'thana_name',
    'thana_is_active',
    'dis_id'
    ];
    public function districts()
    {
        return $this->hasOne(District::class);
    }
    public function unions()
    {
        return $this->hasMany(Union::class);
    }
}
