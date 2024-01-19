<?php

namespace Database\Seeders;

use App\Http\Controllers\TeachersController;
use App\Models\Classes;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\School;
use PhpParser\Builder\Class_;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
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

        $secretary = \App\Models\User::factory()->create([
            'name' => 'Test Secretary',
            'email' => 'secretary@secretary.com',
            'phone' => '99999999999',
            'password' => bcrypt('password'),
        ]);

        $teacher = \App\Models\User::factory()->create([
            'name' => 'Test Teacher',
            'email' => 'teacher@teacher.com',
            'phone' => '99999999999',
            'password' => bcrypt('password'),
        ]);

        $data = [
                'landline' => '99999999999',
                'inep' => '99999999',
                'cpf' => '99999999999',
                'district' => 'Bairro Teste',
                'birth_date' => '05/11/2002',
                'gender' => 'M',
                'rg' => '99999999999',
                'country' => 'Brasil',
                'street' => 'Rua Teste',
                'number' => '999',
                'zone' => 'U',
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
        $secretary->datauser()->create($data);
        $director->datauser()->create($data);
        $student->datauser()->create($data);
        $teacher->datauser()->create($data);

        $admin->assignRole('admin');
        $secretary->assignRole('secretary');
        $director->assignRole('director');

        $teacher->assignRole('teacher');
        (new TeachersController)->linkInClass(Classes::first()->uuid, $teacher->uuid);
        
        $student->assignRole('student');
        $director->assignRoleForSchool('director', School::first()->uuid);
        $student->assignRoleForSchool('student', School::first()->uuid);
        $secretary->assignRoleForSchool('secretary', School::first()->uuid);
        $teacher->assignRoleForSchool('teacher', School::first()->uuid);
    }
}
