<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstituteInfo extends Model
{
    use HasFactory;
    protected $table = 'institute_infos';

    protected $fillable = [
        'to',
        'form',
        'address',
        'designation',
        'organization',
        'person_id'
    ];

    public function inst_type()
    {
        return $this->hasMany(InstType::class);
    }
}
