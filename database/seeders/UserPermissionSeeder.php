<?php

namespace Database\Seeders;

use App\Models\UserPermission;
use Illuminate\Database\Seeder;

class UserPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UserPermission::insert([
            'user_id' => 1, // Replace with the desired user ID
            'asset_create' => '1',
            'asset_update' => '1',
            'asset_transfer' => '1',
            'asset_device' => '1',
            'asset_dispose' => '1',
            'asset_download' => '1',
            'license_create' => '1',
            'license_update' => '1',
            'license_delete' => '1',
            'asset_upload' => '1',
            'view_logs' => '1',
            'dev_tools' => '1',
            'dashboard' => '1',
        ]);
    }
}
