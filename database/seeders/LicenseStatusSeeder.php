<?php

namespace Database\Seeders;

use App\Models\LicenseStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LicenseStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LicenseStatus::insert([
            ['status' => 'AVAILABLE'],
            ['status' => 'IN USE'],
            ['status' => 'EXPIRED'],
        ]);
    }
}
