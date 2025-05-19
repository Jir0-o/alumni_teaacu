<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MemberSubcategory extends Model
{
    protected $fillable = ['name', 'member_category_id', 'is_active'];

    public function category()
    {
        return $this->belongsTo(MemberCategory::class);
    }

    public function subSubcategories()
    {
        return $this->hasMany(MemberSubSubcategory::class);
    }
}