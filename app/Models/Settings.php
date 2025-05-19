<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'address',
        'powered_by',
        'email',
        'contact_number',
        'app_url',
        'logo_path',
        'divisionId',
        'districtId',
        'thanaId',
        'unionId'
        ];
}
