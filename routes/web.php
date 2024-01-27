<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\ClassesController;
use App\Http\Controllers\CurriculumController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\SchoolYearController;
use App\Http\Controllers\SubjectsController;
use App\Http\Controllers\TeachersController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| A middleware 'web' possui o middleware 'CheckSchoolCookie' que é responsável por verificar se o usuário tem vinculo com a selecionada,  caso não tenha, ele é redirecionado para a página de escolha de escola e o cookie é deletado.
| 
| A middleware 'school_home' possui o middleware 'RequireSchoolHome' que obrigada o usuário a ter uma escola selecionada e com vinculo, e também leva $school_home para as views.
|
*/


Route::middleware(['auth', 'web'])->group(function () {
    Route::get('/', function () {
        return view('welcome');
    })->name('panel');
    Route::get('/perfil', [ProfileController::class, 'edit'])->name('profile.edit');

    // System -> Admin
    Route::group(['middleware' => ['role:admin']], function () {
        Route::get('/gerenciar/estados', [StateController::class, 'states'])->name('manage.states')->middleware('permission:manage-location');
        Route::get('/gerenciar/cidades', [CityController::class, 'cities'])->name('manage.cities')->middleware('permission:manage-location');
        Route::get('/gerenciar/escolas/nova', [SchoolController::class, 'create'])->name('manage.schools.create')->middleware('permission:create-any-school');
        Route::get('/gerenciar/escolas', [SchoolController::class, 'schools'])->name('manage.schools')->middleware('permission:update-any-school');
        Route::get('/gerenciar/anos-letivos', [SchoolYearController::class, 'schoolsyears'])->name('manage.school-years')->middleware('permission:update-any-school-year');
    });
});


Route::middleware(['auth', 'web', 'school_home'])->group(function () {
    // School -> Secretary
    Route::group(['middleware' => ['school.role:secretary']], function () {
        Route::get('/gerenciar/matriz-curricular', [CurriculumController::class, 'curriculum'])->name('manage.curriculum')->middleware('permission:manage-curricula');
        Route::get('/gerenciar/matriz-curricular/{curriculum:code}/editar', [CurriculumController::class, 'edit'])->name('manage.curriculum.edit')->middleware('permission:update-any-curriculum');
        Route::get('/gerenciar/matriz-curricular/{curriculum:code}/disciplinas', [SubjectsController::class, 'subjects'])->name('manage.subjects')->middleware('permission:update-any-subject');
    });

    // School -> Secretary | Director
    Route::middleware(['school.role:secretary|director'])->group(function () {
        Route::group(['middleware' => ['school_year_active']], function () {
            Route::get('/gerenciar/turmas', [ClassesController::class, 'classes'])->name('manage.classes')->middleware('permission:manage-classes');
            Route::get('/gerenciar/turmas/{class:code}/editar', [ClassesController::class, 'edit'])->name('manage.classes.edit')->middleware('permission:update-any-class');
            Route::middleware(['school_curriculum_set'])->group(function () {
                Route::get('/gerenciar/turmas/{class:code}/professores', [TeachersController::class, 'teachers'])->name('manage.classes.teachers')->middleware('permission:manage-teachers');
                Route::get('/gerenciar/turmas/{class:code}/professores/cadastrar', [TeachersController::class, 'create'])->name('manage.classes.teachers.create')->middleware('permission:create-any-teacher');
            });

            Route::middleware(['check_if_valid_teacher'])->group(function () {
                Route::get('/gerenciar/turmas/{class:code}/professores/{username}/editar', [TeachersController::class, 'edit'])->name('manage.classes.teachers.edit')->middleware('permission:update-any-teacher');
            });
        });
    });
});



require __DIR__ . '/auth.php';
