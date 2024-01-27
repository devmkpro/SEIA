<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\SchoolYear;
use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            StateSeeder::class,
            CitySeeder::class,
            SchoolSeeder::class,
            SchoolYearSeeder::class,
            RoomsSeeder::class,
            ClassesSeeder::class,
            UserSeeder::class,
            CurriculumSeeder::class,
            SubjectsSeeder::class,
        ]);
    }
}
