<?php

namespace Database\Seeders;

use App\Models\Person;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PersonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Person::create([
            'name' => 'Admin',
            'cips_membership_status' => 'admin',
            'user_id' => '1',
            'alumni_id' => 'TEAACU0001',
            'status' => 1,
        ]);

        Person::create([
            'name' => 'Member',
            'cips_membership_status' => 'member',
            'user_id' => '2',
            'alumni_id' => 'TEAACU0002',
            'status' => 1,
        ]);
        person::create([
            'name' => 'Member User',
            'cips_membership_status' => 'member',
            'user_id' => '3',
            'alumni_id' => 'TEAACU0003',
            'status' => 1,
        ]);
    }
}
