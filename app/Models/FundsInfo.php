<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FundsInfo extends Model
{
    use HasFactory;
    protected $table = 'funds_infos';

    protected $fillable = [
        'source_id',
        'fund_name',
        'fund_type_id',
        'fund_receive_date',
        'fund_valid_till',
        'fund_amount',
        'fund_disbursed',
        'fund_available',
        'is_active',
    ];

    public function f_source()
    {
        return $this->hasMany(FSourse::class);
    }
    public function inst_type()
    {
        return $this->hasMany(FType::class);
    }
}
