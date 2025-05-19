<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventRegistration extends Model
{
    protected $table = 'event_registration';
    protected $primaryKey = 'reg_id';
	public $timestamps = false;
    use HasFactory;
    protected $fillable = [
        'title',
        'isActive'
        ];
        
    public function gallery()
    {
        return $this->belongsTo(EventGallery::class);
    }
    // public function event_pics()
    // {
    //     return $this->hasMany(EventPic::class);
    // }
}
