<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role as Role;
use App\Models\Permission as Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::firstOrCreate(['name' => 'admin']);
        Role::firstOrCreate(['name' => 'secretary']);
        Role::firstOrCreate(['name' => 'director']);
        Role::firstOrCreate(['name' => 'teacher']);
        Role::firstOrCreate(['name' => 'student']);


        $adminPermissions = [
            'manage-location', 
            'manage-schools', 
            'view-any-school', 
            'create-any-school', 
            'update-any-school', 
            'manage-school-years',
            'update-any-school-year',
            'create-any-school-year',
        ];

        $secretaryPermissions = [
            'manage-students', 
            'create-any-student',
            'update-any-student',
            'delete-any-student',
            'manage-teachers', 
            'create-any-teacher',
            'update-any-teacher',
            'delete-any-teacher',
            'manage-curricula',
            'create-any-curriculum',
            'update-any-curriculum',
            'delete-any-curriculum',
            'manage.subjects',
            'create-any-subject',
            'update-any-subject',
            'delete-any-subject',
            'manage-classes', 
            'create-any-class',
            'update-any-class',
            'delete-any-class',
            'manage-rooms',
            'create-any-room',
            'update-any-room',
            'delete-any-room',
            

        ];

        $directorPermissions = [
            'manage-students', 
            'create-any-student',
            'update-any-student',
            'delete-any-student',
            'manage-classes',  
            'create-any-class',
            'update-any-class',
            'manage-teachers',
            'create-any-teacher',
            'update-any-teacher',
            'delete-any-teacher', 
            'manage-students',
            'manage-subjects',
            'manage-rooms',
            'create-any-room',
            'update-any-room',
            'delete-any-room',
        ];

        $teacherPermissions = [
            'manage-students',
        ];

        foreach ($adminPermissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        foreach ($directorPermissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        foreach ($secretaryPermissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }
        
        $admin = Role::where('name', 'admin')->first();
        $admin->givePermissionTo(Permission::all());

        $secretary = Role::where('name', 'secretary')->first();
        $secretary->givePermissionTo($secretaryPermissions);

        $director = Role::where('name', 'director')->first();
        $director->givePermissionTo($directorPermissions);

        $teacher = Role::where('name', 'teacher')->first();
        $teacher->givePermissionTo($teacherPermissions);

    }
}
