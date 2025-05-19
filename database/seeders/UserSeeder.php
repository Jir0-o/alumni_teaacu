<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::create([
            'cips' => 'CIPS001',
            'name' => 'Admin User',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('uni1234567890'),
            'role' => 1,
        ]);
        $admin->assignRole('Admin'); 

        $member1 = User::create([
            'cips' => 'CIPS002',
            'name' => 'Member',
            'email' => 'superadmin@gmail.com',
            'password' => Hash::make('uni1234567890'),
        ]);
        $member1->assignRole('Guest'); 

        $member2 = User::create([
            'cips' => 'CIPS003',
            'name' => 'Member User',
            'email' => 'member@gmail.com',
            'password' => Hash::make('uni1234567890'),
        ]);
        $member2->assignRole('Guest');
    }
}
