<?php

use App\Http\Controllers\Location\CityController;
use App\Http\Controllers\Location\StateController;
use App\Http\Controllers\Schools\Classes\ClassesController;
use App\Http\Controllers\Schools\Curriculums\CurriculumController;
use App\Http\Controllers\Schools\Rooms\RoomsController;
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
    Route::get('/perfil/notificacoes', [NotificationController::class, 'index'])->name('profile.notifications');

    // System -> Admin
    Route::prefix('gerenciar')->middleware(['role:admin'])->name('manage.')->group(function () {
        Route::get('/estados', [StateController::class, 'states'])->name('states')->middleware('permission:manage-location');
        Route::get('/cidades', [CityController::class, 'cities'])->name('cities')->middleware('permission:manage-location');
        Route::get('/escolas/nova', [SchoolController::class, 'create'])->name('schools.create')->middleware('permission:create-any-school');
        Route::get('/escolas', [SchoolController::class, 'schools'])->name('schools')->middleware('permission:update-any-school');
        Route::get('/anos-letivos', [SchoolYearController::class, 'schoolsyears'])->name('school-years')->middleware('permission:update-any-school-year');
    });
});

Route::middleware(['auth', 'web', 'checkIfSetSchoolHome'])->group(function () {
    // School -> Secretary
    Route::prefix('gerenciar')->middleware(['school.role:secretary'])->name('manage.')->group(function () {
        Route::get('/matriz-curricular', [CurriculumController::class, 'curriculum'])->name('curriculum')->middleware('permission:manage-curricula');
        Route::get('/matriz-curricular/{curriculum:code}/editar', [CurriculumController::class, 'edit'])->name('curriculum.edit')->middleware('permission:update-any-curriculum');
        Route::get('/matriz-curricular/{curriculum:code}/disciplinas', [SubjectsController::class, 'subjects'])->name('subjects')->middleware('permission:update-any-subject');
    });

    // School -> Secretary | Director
    Route::middleware(['school.role:secretary|director'])->prefix('gerenciar')->name('manage.')->group(function () {
        Route::middleware(['checkIfSchoolYearActive'])->group(function () {
            Route::get('/turmas', [ClassesController::class, 'classes'])->name('classes')->middleware('permission:manage-classes');
            Route::get('/turmas/{class:code}/editar', [ClassesController::class, 'edit'])->name('classes.edit')->middleware('permission:update-any-class');
            Route::get('/turmas/{class:code}/professores/{teacher:username}/editar', [TeachersController::class, 'edit'])->name('classes.teachers.edit')->middleware('permission:update-any-teacher');
            Route::middleware(['checkIfClassCurriculumSet'])->group(function () {
                Route::get('/turmas/{class:code}/professores', [TeachersController::class, 'teachers'])->name('classes.teachers')->middleware('permission:manage-teachers');
                Route::get('/turmas/{class:code}/professores/cadastrar', [TeachersController::class, 'create'])->name('classes.teachers.create')->middleware('permission:create-any-teacher');
            });
        });

        Route::prefix('salas')->middleware(['checkIfSchoolYearActive'])->name('rooms.')->group(function () {
            Route::get('/', [RoomsController::class, 'index'])->name('index')->middleware('permission:manage-rooms');
        });

    });


});

require __DIR__ . '/auth.php';
