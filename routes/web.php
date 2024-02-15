<?php

use App\Http\Controllers\Location\CityController;
use App\Http\Controllers\Location\StateController;
use App\Http\Controllers\Schools\Classes\ClassesController;
use App\Http\Controllers\Schools\Curriculums\CurriculumController;
use App\Http\Controllers\Schools\SchoolController;
use App\Http\Controllers\Schools\SchoolYearController;
use App\Http\Controllers\Schools\Subjects\SubjectsController;
use App\Http\Controllers\Schools\Teachers\TeachersController;
use App\Http\Controllers\User\Notification\NotificationController;
use App\Http\Controllers\User\ProfileController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'web'])->group(function () {
    Route::get('/', function () {
        return view('welcome');
    })->name('panel');
    Route::get('/perfil', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/perfil/notificacoes', [NotificationController::class, 'page'])->name('profile.notifications');

    // System -> Admin
    Route::group(['middleware' => ['role:admin']], function () {
        Route::get('/gerenciar/estados', [StateController::class, 'states'])->name('manage.states')->middleware('permission:manage-location');
        Route::get('/gerenciar/cidades', [CityController::class, 'cities'])->name('manage.cities')->middleware('permission:manage-location');
        Route::get('/gerenciar/escolas/nova', [SchoolController::class, 'create'])->name('manage.schools.create')->middleware('permission:create-any-school');
        Route::get('/gerenciar/escolas', [SchoolController::class, 'schools'])->name('manage.schools')->middleware('permission:update-any-school');
        Route::get('/gerenciar/anos-letivos', [SchoolYearController::class, 'schoolsyears'])->name('manage.school-years')->middleware('permission:update-any-school-year');
    });
});


Route::middleware(['auth', 'web', 'checkIfSetSchoolHome'])->group(function () {
    // School -> Secretary
    Route::group(['middleware' => ['school.role:secretary']], function () {
        Route::get('/gerenciar/matriz-curricular', [CurriculumController::class, 'curriculum'])->name('manage.curriculum')->middleware('permission:manage-curricula');
        Route::get('/gerenciar/matriz-curricular/{curriculum:code}/editar', [CurriculumController::class, 'edit'])->name('manage.curriculum.edit')->middleware('permission:update-any-curriculum');
        Route::get('/gerenciar/matriz-curricular/{curriculum:code}/disciplinas', [SubjectsController::class, 'subjects'])->name('manage.subjects')->middleware('permission:update-any-subject');
    });

    // School -> Secretary | Director
    Route::middleware(['school.role:secretary|director'])->group(function () {
        Route::group(['middleware' => ['checkIfSchoolYearActive']], function () {
            Route::get('/gerenciar/turmas', [ClassesController::class, 'classes'])->name('manage.classes')->middleware('permission:manage-classes');
            Route::get('/gerenciar/turmas/{class:code}/editar', [ClassesController::class, 'edit'])->name('manage.classes.edit')->middleware('permission:update-any-class');
            Route::get('/gerenciar/turmas/{class:code}/professores/{teacher:username}/editar', [TeachersController::class, 'edit'])->name('manage.classes.teachers.edit')->middleware('permission:update-any-teacher');
            Route::middleware(['checkIfClassCurriculumSet'])->group(function () {
                Route::get('/gerenciar/turmas/{class:code}/professores', [TeachersController::class, 'teachers'])->name('manage.classes.teachers')->middleware('permission:manage-teachers');
                Route::get('/gerenciar/turmas/{class:code}/professores/cadastrar', [TeachersController::class, 'create'])->name('manage.classes.teachers.create')->middleware('permission:create-any-teacher');
            });

        });
    });
});



require __DIR__ . '/auth.php';
