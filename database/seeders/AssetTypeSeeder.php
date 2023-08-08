<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\AssetType;
use Illuminate\Database\Seeder;

class AssetTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AssetType::insert([
            ['assetType_name' => 'Desktop'],
            ['assetType_name' => 'Laptop'],
            ['assetType_name' => 'Monitor'],
            ['assetType_name' => 'Printer'],
            ['assetType_name' => 'Headset'],
            ['assetType_name' => 'Switch'],
            ['assetType_name' => 'Firewall'],
            ['assetType_name' => 'Server'],
            ['assetType_name' => 'Router'],
            ['assetType_name' => 'APN'],
            ['assetType_name' => 'Speaker'],
            ['assetType_name' => 'Storage'],
            ['assetType_name' => 'Barcode Scanner'],
            ['assetType_name' => 'DVR'],
            ['assetType_name' => 'CCTV'],
            ['assetType_name' => 'UPS'],
            ['assetType_name' => 'POS'],
            ['assetType_name' => 'Visio'],
            ['assetType_name' => 'AntiVirus'],
            ['assetType_name' => 'Project'],
            ['assetType_name' => 'Office'],
        ]);
    }
}
