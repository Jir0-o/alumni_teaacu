<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MemberCategory;
use App\Models\MemberSubcategory;
use App\Models\MemberSubSubcategory;

class MemberDirectorySeeder extends Seeder
{
    public function run()
    {
        // Top Level: Entrepreneur
        MemberCategory::create(['name' => 'Entrepreneur']);

        // Top Level: Service
        $service = MemberCategory::create(['name' => 'Service']);

        // Second Level under Service
        $apparel = MemberSubcategory::create(['name' => 'Apparel/Garments Industry', 'member_category_id' => $service->id]);
        $fabrics = MemberSubcategory::create(['name' => 'Fabrics Industry', 'member_category_id' => $service->id]);
        $wet = MemberSubcategory::create(['name' => 'Wet Processing', 'member_category_id' => $service->id]);
        $spinning = MemberSubcategory::create(['name' => 'Spinning Industry', 'member_category_id' => $service->id]);
        $othersService = MemberSubcategory::create(['name' => 'Others', 'member_category_id' => $service->id]);

        // Third Level: Apparel/Garments Industry
        MemberSubSubcategory::insert([
            ['name' => 'Merchandising', 'member_subcategory_id' => $apparel->id],
            ['name' => 'IE', 'member_subcategory_id' => $apparel->id],
            ['name' => 'Fashion Design', 'member_subcategory_id' => $apparel->id],
            ['name' => 'Others', 'member_subcategory_id' => $apparel->id],
        ]);

        // Third Level: Fabrics Industry
        MemberSubSubcategory::insert([
            ['name' => 'Denim', 'member_subcategory_id' => $fabrics->id],
            ['name' => 'Waving', 'member_subcategory_id' => $fabrics->id],
            ['name' => 'Knitting', 'member_subcategory_id' => $fabrics->id],
            ['name' => 'Others', 'member_subcategory_id' => $fabrics->id],
        ]);

        // Third Level: Wet Processing
        MemberSubSubcategory::insert([
            ['name' => 'Washing', 'member_subcategory_id' => $wet->id],
            ['name' => 'Dye Production', 'member_subcategory_id' => $wet->id],
            ['name' => 'LAB', 'member_subcategory_id' => $wet->id],
            ['name' => 'Others', 'member_subcategory_id' => $wet->id],
        ]);

        // Third Level: Spinning Industry
        MemberSubSubcategory::insert([
            ['name' => 'Spinning', 'member_subcategory_id' => $spinning->id],
            ['name' => 'Others', 'member_subcategory_id' => $spinning->id],
        ]);

        // Third Level: Others (under Service)
        MemberSubSubcategory::insert([
            ['name' => 'Govt', 'member_subcategory_id' => $othersService->id],
            ['name' => 'Govt. Service', 'member_subcategory_id' => $othersService->id],
            ['name' => 'Educational Institute', 'member_subcategory_id' => $othersService->id],
            ['name' => 'Marketing', 'member_subcategory_id' => $othersService->id],
            ['name' => 'Others', 'member_subcategory_id' => $othersService->id],
        ]);
    }
}
