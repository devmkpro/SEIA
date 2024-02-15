<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\School\School;
use App\Models\School\SchoolYear;
use App\Models\Classes\Classes;




class ClassesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Classes::create([
            'name' => '9º ano A',
            'turn' => 'morning',
            'monday' => true,
            'modality' => 'regular',
            'tuesday' => true,
            'wednesday' => true,
            'thursday' => true,
            'friday' => true,
            'saturday' => false,
            'sunday' => false,
            'max_students' => 30,
            'start_time' => '07:00:00',
            'end_time' => '12:00:00',
            'schools_uuid' => School::first()->uuid,
            'school_years_uuid' => SchoolYear::first()->uuid,
        ]);
    
    }
}
