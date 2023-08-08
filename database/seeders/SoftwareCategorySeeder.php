<?php

namespace Database\Seeders;

use App\Models\SoftwareCategory;
use Illuminate\Database\Seeder;

class SoftwareCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SoftwareCategory::insert([
            ['software_category' => 'Operating System'],
            ['software_category' => 'Document Suites'],
        ]);
    }
}
