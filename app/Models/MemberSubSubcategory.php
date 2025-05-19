<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MemberSubSubcategory extends Model
{
    protected $fillable = ['name', 'member_subcategory_id', 'is_active'];

    public function subcategory()
    {
        return $this->belongsTo(MemberSubcategory::class);
    }
}