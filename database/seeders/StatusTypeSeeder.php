<?php

namespace Database\Seeders;

use App\Models\StatusType;
use Illuminate\Database\Seeder;

class StatusTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        StatusType::insert([
            ['status_name' => 'Available'],
            ['status_name' => 'LGU Use'],
            ['status_name' => 'In use'],
            ['status_name' => 'Defective'],
            ['status_name' => 'Retired Asset'],
            ['status_name' => 'Disposed'],
            ['status_name' => 'For PQ'],
            ['status_name' => 'Retained'],
            ['status_name' => 'OJT'],
        ]);
    }
}
