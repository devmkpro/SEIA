<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DataUserController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\CurriculumController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\SchoolYearController;
use App\Http\Controllers\SubjectsController;
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
    Route::get('/', function () {return view('welcome');})->name('panel');
    Route::get('/perfil', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::patch('/data-user', [DataUserController::class, 'update'])->name('data-user.update');
    Route::post('/set-school-home', [SchoolController::class, 'setHome'])->name('set-school-home');

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
    Route::delete('/delete-school-home', [SchoolController::class, 'deleteHome'])->name('delete-school-home');

    // School -> Secretary
    Route::group(['middleware' => ['school.role:secretary']], function () {
        Route::get('/gerenciar/matriz-curricular', [CurriculumController::class, 'curriculum'])->name('manage.curriculum')->middleware('permission:manage-curricula');
        Route::get('/gerenciar/matriz-curricular/{code}/disciplinas', [SubjectsController::class, 'subjects'])->name('manage.subjects')->middleware('permission:update-any-subject');
    });


});



require __DIR__.'/auth.php';
