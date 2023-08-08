<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Classifications;
use Illuminate\Database\Seeder;

class ClassificationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Classifications::insert([
            ['class_name' => 'INTERNAL'],
            ['class_name' => 'PUBLIC'],
        ]);
    }
}
