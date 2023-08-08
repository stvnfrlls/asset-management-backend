<?php

namespace Database\Seeders;

use App\Models\Departments;
use Illuminate\Database\Seeder;

class DepartmentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Departments::insert([
            ['dept_name' => 'IT - Technical'],
            ['dept_name' => 'City Operations'],
            ['dept_name' => 'Admin and Procurement'],
            ['dept_name' => 'Finance and Accounting'],
            ['dept_name' => 'Records Management'],
            ['dept_name' => 'HR'],
            ['dept_name' => 'Back Office'],
            ['dept_name' => 'Executive'],
            ['dept_name' => 'IT - Dev'],
            ['dept_name' => 'IT - Engineering'],
            ['dept_name' => 'Legal and Compliance'],
            ['dept_name' => 'Marketing'],
            ['dept_name' => 'President'],
        ]);
    }
}
