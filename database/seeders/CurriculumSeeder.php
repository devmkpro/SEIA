<?php

namespace Database\Seeders;

use App\Models\Curriculum\Curriculum;
use App\Models\School\School;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CurriculumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Curriculum::create([
            'school_uuid' => School::first()->uuid,
            'series' => 'educ_med_3',
            'modality' => 'medio',
            'weekly_hours' => 15,
            'total_hours' => 200,
            'start_time' => '07:00',
            'end_time' => '11:00',
            'default_time_class' => 45,
            'turn' =>'morning',
        ]);
    }
}
