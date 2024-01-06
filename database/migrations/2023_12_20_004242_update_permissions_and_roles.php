<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Role;
use App\Models\Permission;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
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
            'manage-teachers', 
            'manage-curricula',
            'create-any-curriculum',
            'update-any-curriculum',
            'delete-any-curriculum',
            'manage.subjects',
            'create-any-subject',
            'update-any-subject',
            'delete-any-subject',
            'manage-classes', 

        ];

        $directorPermissions = [
            'manage-classes',  
            'manage-teachers', 
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


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
