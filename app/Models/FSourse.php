<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FSourse extends Model
{
    use HasFactory;
    protected $table = 'f_sourses';

    protected $fillable = [
        'name',
    ];
    public function fund_info()
    {
        return $this->hasOne(FundsInfo::class);
    }
}
