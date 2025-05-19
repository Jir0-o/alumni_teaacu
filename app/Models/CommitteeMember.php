<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommitteeMember extends Model
{
    use HasFactory;
    protected $table = 'committee_members';

    protected $fillable = [
        'com_id',
        'members_name',
        'members_position',
    ];

    public function committee()
    {
        return $this->hasOne(Committee::class);
    }

}
