<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MemberCategory extends Model
{
    protected $fillable = ['name', 'is_active'];

    public function subcategories()
    {
        return $this->hasMany(MemberSubcategory::class);
    }
}