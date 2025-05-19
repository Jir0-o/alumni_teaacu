<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstType extends Model
{
    use HasFactory;
    protected $table = 'inst_types';

    protected $fillable = [
        'name',
    ];

    public function institute_info()
    {
        return $this->hasOne(InstituteInfo::class);
    }
}
