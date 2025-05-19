<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FType extends Model
{
    use HasFactory;
    protected $table = 'f_types';

    protected $fillable = [
        'f_type_name',
    ];
    public function fundsInfo()
    {
        return $this->hasOne(FundsInfo::class);
    }
}
