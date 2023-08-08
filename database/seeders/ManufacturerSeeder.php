<?php

namespace Database\Seeders;

use App\Models\Manufacturer;
use Illuminate\Database\Seeder;

class ManufacturerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Manufacturer::insert([
            ['manufacturer_name' => 'Dell'],
            ['manufacturer_name' => 'Lenovo'],
            ['manufacturer_name' => 'HIP'],
            ['manufacturer_name' => 'ASUS'],
            ['manufacturer_name' => 'AOC'],
            ['manufacturer_name' => 'NVision'],
            ['manufacturer_name' => 'Acer'],
            ['manufacturer_name' => 'Epson'],
            ['manufacturer_name' => 'ViewPlus'],
            ['manufacturer_name' => 'HP'],
            ['manufacturer_name' => 'N-Vision'],
            ['manufacturer_name' => 'Samsung'],
            ['manufacturer_name' => 'Edifier'],
            ['manufacturer_name' => 'Cisco'],
            ['manufacturer_name' => 'Fortinet'],
            ['manufacturer_name' => 'Micro-Star International Co., Ltd'],
            ['manufacturer_name' => 'Apple'],
            ['manufacturer_name' => 'Trendsonic'],
            ['manufacturer_name' => 'Philips'],
            ['manufacturer_name' => 'Jabra'],
            ['manufacturer_name' => 'Linksys'],
            ['manufacturer_name' => 'TP Link'],
            ['manufacturer_name' => 'Meraki'],
            ['manufacturer_name' => 'Anker'],
            ['manufacturer_name' => 'Globe'],
            ['manufacturer_name' => 'Smart'],
            ['manufacturer_name' => 'HKC'],
            ['manufacturer_name' => 'Fortigate'],
            ['manufacturer_name' => 'Synology'],
            ['manufacturer_name' => 'Neutron Odyssey'],
            ['manufacturer_name' => 'Polaroid'],
            ['manufacturer_name' => 'Seagate'],
            ['manufacturer_name' => 'Dahua'],
            ['manufacturer_name' => 'Vertiv'],
            ['manufacturer_name' => 'Generic'],
            ['manufacturer_name' => 'Microsoft'],
            ['manufacturer_name' => 'Sophos'],
        ]);
    }
}
