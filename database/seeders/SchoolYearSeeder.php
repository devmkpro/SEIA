<?php

namespace Database\Seeders;

use App\Models\School\SchoolYear;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SchoolYearSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SchoolYear::create([
            'name' => '2024',
            'start_date' => '2024/01/01',
            'end_date' => '2025/01/01',
            'active' =>  true,
        ]);
    }
}
