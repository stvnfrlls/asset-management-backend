<?php

namespace Database\Seeders;

use App\Models\DisposalMethod;
use Illuminate\Database\Seeder;

class DisposalMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DisposalMethod::insert([
            ['method' => 'Inciniration'],
            ['method' => 'Shredding'],
            ['method' => 'Formatting'],
            ['method' => 'Trade'],
            ['method' => 'Others'],
        ]);
    }
}
