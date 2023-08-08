<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'account_type' => 'MAIN'
        ]);

        $this->call(AssetTypeSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(ClassificationsSeeder::class);
        $this->call(ManufacturerSeeder::class);
        $this->call(DepartmentsSeeder::class);
        $this->call(StatusTypeSeeder::class);
        $this->call(UserRolesSeeder::class);
        $this->call(SoftwareCategorySeeder::class);
        $this->call(DisposalMethodSeeder::class);
        $this->call(LicenseStatusSeeder::class);
        $this->call(UserPermissionSeeder::class);
    }
}
