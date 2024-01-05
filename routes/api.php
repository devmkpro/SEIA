<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StateController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\CurriculumController;
use App\Http\Controllers\DataUserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SchoolYearController;
use App\Http\Controllers\SubjectsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Middlewares explained in routes/web.php
|
*/

Route::post('/login', [AuthController::class, 'login']);

Route::group(['middleware' => ['api', 'auth:sanctum']], function () {

    Route::post('/set-school-home', [SchoolController::class, 'setHome'])->name('set-school-home')->middleware('to.set.school.home');
    Route::delete('/delete-school-home', [SchoolController::class, 'deleteHome'])->name('delete-school-home');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::patch('/data-user', [DataUserController::class, 'update'])->name('data-user.update');


    Route::middleware(['role:admin'])->group(function () {
        Route::get('/verify/schools', [SchoolController::class, 'index'])->name('manage.schools.index')->middleware('permission:view-any-school');
        Route::get('/verify/cities', [CityController::class, 'index'])->name('manage.cities.index')->middleware('permission:manage-location');
        Route::get('/verify/cities/{code}', [CityController::class, 'show'])->name('manage.cities.show')->middleware('permission:manage-location');
        Route::get('/verify/states', [StateController::class, 'index'])->name('manage.states.index')->middleware('permission:manage-location');
        Route::get('/verify/states/{code}', [StateController::class, 'show'])->name('manage.states.show')->middleware('permission:manage-location');
        Route::get('/states/cities', [StateController::class, 'cities'])->name('manage.states.cities');
        Route::get('/verify/school-years', [SchoolYearController::class, 'index'])->name('manage.school-years.index')->middleware('permission:manage-school-years');

        Route::get('/manage/school-years/{schoolYear}', [SchoolYearController::class, 'show'])->name('manage.school-years.show')->middleware('permission:update-any-school-year');
        Route::post('/manage/school-years/new', [SchoolYearController::class, 'store'])->name('manage.school-years.store')->middleware('permission:create-any-school-year');
        Route::put('/manage/school-years/', [SchoolYearController::class, 'update'])->name('manage.school-years.update')->middleware('permission:update-any-school-year');
        Route::post('/manage/schools/new', [SchoolController::class, 'store'])->name('manage.schools.store')->middleware('permission:create-any-school');
    });

    // school_home required
    Route::group(['middleware' => ['school_home']], function () {
        // School -> Secretary
        Route::group(['middleware' => ['school.role:secretary']], function () {
            Route::get('/verify/curriculum', [CurriculumController::class, 'index'])->name('manage.curriculum.index')->middleware('permission:manage-curricula');
            Route::post('/manage/curriculum/new', [CurriculumController::class, 'store'])->name('manage.curriculum.store')->middleware('permission:create-any-curriculum');

            // School -> Teacher
            Route::middleware(['school.curriculum'])->group(function () {
                Route::get('/manage/curriculum', [CurriculumController::class, 'show'])->name('manage.curriculum.show')->middleware('permission:update-any-curriculum');
                Route::put('/manage/curriculum', [CurriculumController::class, 'update'])->name('manage.curriculum.update')->middleware('permission:update-any-curriculum');
                Route::get('/verify/subjects/curriculum', [SubjectsController::class, 'index'])->name('manage.subjects.index')->middleware('permission:manage.subjects');
                Route::post('/manage/curriculum/subjects', [SubjectsController::class, 'store'])->name('manage.subjects.store')->middleware('permission:create-any-subject');
                Route::delete('/manage/curriculum/delete', [CurriculumController::class, 'destroy'])->name('manage.curriculum.destroy')->middleware('permission:delete-any-curriculum');
            });

            // Require Subject in request
            Route::middleware(['school.curriculum.subject'])->group(function () {
                Route::get('/verify/subjects', [SubjectsController::class, 'show'])->name('manage.subjects.show')->middleware('permission:update-any-subject');
                Route::put('/manage/subjects/', [SubjectsController::class, 'update'])->name('manage.subjects.update')->middleware('permission:update-any-subject');
                Route::delete('/manage/subjects/delete', [SubjectsController::class, 'destroy'])->name('manage.subjects.destroy')->middleware('permission:delete-any-subject');
            });
        });
    });

});

