<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventGallery extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'isActive',
        'reg_valid_date',
        'reg_enable',
        'reg_amount',
        'status',
        'created_by',
        ];
        
    public function registrations()
    {
        return $this->hasMany(EventRegistration::class, 'event_id');
    }
    // public function event_pics() 
    // {
    //     return $this->hasMany(EventPic::class);
    // }
}
