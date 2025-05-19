<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Family extends Model
{
    use HasFactory;
    protected $fillable = [
        'fam_name',
        'fam_is_active',
        'hold_id'
        ];
    public function holdings()
    {
        return $this->hasOne(Holding::class);
    }
    public function people()
    {
        return $this->hasMany(Person::class);
    }
}
