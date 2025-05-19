<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    use HasFactory;
    protected $table = 'people';
    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'id',
        'user_id',
        'f_name',
        'm_name',
        'present_address',
        'permanent_address',
        'dob',
        'nid',
        'cips_membership_status',
        'religion',
        'marital_status',
        'nationality',
        'number_of_child',
        'career_type',
        'service_type',
        'member_sub_subcategory_id',
        'gender',
        'skill_description',
        'career_objective',
        'short_biography',
        'profileImage',
        'mobile_no',
        'status',
        'alumni_id',
        'alt_mobile_no',
        'profileImage',
        'is_active',
    ];
    public function families()
    {
        return $this->hasMany(FamilyMember::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
