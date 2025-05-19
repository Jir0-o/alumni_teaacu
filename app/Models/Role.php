<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Role as SpatieRole;
use Spatie\Permission\Traits\HasRoles;

class Role extends SpatieRole
{
    use HasRoles, HasFactory;

    protected $fillable = ['name', 'guard_name'];

    
    public function RoleHasPermission()
    {
        return $this->hasMany(RoleHasPermission::class);
    }
}
