<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Define permissions
        $permissions = [
            'Can access frontend',
            'Can access dashboard',
            'Can access profile',
            'Can access create event',
            'Can access view registration',
            'Can access create notice',
            'Can access research & publication',
        ];

        // Create permissions
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Define roles with specific permissions
        $roles = [
            'Guest' => [
                'Can access profile',
            ],
            'Admin' => [
                'Can access frontend',
                'Can access dashboard',
                'Can access profile',
                'Can access create event',
                'Can access view registration',
                'Can access create notice',
                'Can access research & publication',
            ],
            'Member' => [
                'Can access profile',
            ],
        ];

        // Create roles and assign permissions
        foreach ($roles as $roleName => $rolePermissions) {
            $role = Role::firstOrCreate(['name' => $roleName]);
            $role->syncPermissions($rolePermissions);
        }
    }
}
