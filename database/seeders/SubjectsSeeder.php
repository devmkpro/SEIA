<?php

namespace Database\Seeders;

use App\Models\Curriculum\Curriculum;
use App\Models\Subject\Subjects;
use Illuminate\Database\Seeder;
class SubjectsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Subjects::create([
            'name' =>'artes',
            'curriculum_uuid' =>  Curriculum::first()->uuid,
            'ch' => 120,
            'ch_week' => 8,
            'description' => 'Materia de Artes',
            'modality' => 'ciencias-humanas-e-suas-tecnologias',
        ]);
    }
}
