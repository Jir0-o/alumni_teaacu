<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OurGallery extends Model
{
    protected $fillable = [
        'title',
        'gallery_image',
        'is_active',
        'type',
    ];

}
