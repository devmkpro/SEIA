<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\School;
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
        ]);

        $admin = \App\Models\User::factory()->create([
            'name' => 'Test Admin',
            'email' => 'admin@admin.com',
            'phone' => '99999999999',
            'password' => bcrypt('password'),
        ]);

        $director = \App\Models\User::factory()->create([
            'name' => 'Test director',
            'email' => 'director@director.com',
            'phone' => '99999999999',
            'password' => bcrypt('password'),
        ]);

        $student = \App\Models\User::factory()->create([
            'name' => 'Test student',
            'email' => 'student@student.com',
            'phone' => '99999999999',
            'password' => bcrypt('password'),
        ]);

        $data = [
                'landline' => '99999999999',
                'inep' => '99999999',
                'cpf' => '99999999999',
                'district' => 'Bairro Teste',
                'birth_date' => '05/11/2002',
                'gender' => 'Masculino',
                'rg' => '99999999999',
                'country' => 'Brasil',
                'street' => 'Rua Teste',
                'number' => '999',
                'state' => 'Bairro Teste',
                'zone' => 'urbana',
                'city' => 'Cidade Teste',
                'city_birth' => 'Cidade Teste',
                'state' => 'Estado Teste',
                'state_birth' => 'Estado Teste',
                'zip_code' => '99999999',
                'mother_name' => 'Mãe Teste',
                'father_name' => 'Pai Teste',
                'cpf_responsible' => '99999999999',
                'deficiency' => false,
                'observation' => 'Observação Teste',
        ];
        
        $admin->datauser()->create($data);
        $student->datauser()->create($data);
        $director->datauser()->create($data);

        $admin->assignRole('admin');
        $director->assignRole('director');
        $student->assignRole('student');
        $director->assignRoleForSchool('director', School::first()->uuid);
        $student->assignRoleForSchool('student', School::first()->uuid);





    }
}
