<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StateController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\DataUserController;
use App\Http\Controllers\SchoolYearController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/login', [AuthController::class, 'login']);


Route::group(['middleware' => ['api', 'auth:sanctum', 'role:admin']], function () {
    Route::get('/verify/schools', [SchoolController::class, 'index'])->name('manage.schools.index')->middleware('permission:view-any-school');
    Route::get('/verify/cities', [CityController::class, 'index'])->name('manage.cities.index')->middleware('permission:manage-location');
    Route::get('/verify/states', [StateController::class, 'index'])->name('manage.states.index')->middleware('permission:manage-location');
    Route::get('/states/cities', [StateController::class, 'cities'])->name('manage.states.cities');
    Route::post('/gerenciar/escolas/nova', [SchoolController::class, 'store'])->name('manage.schools.store')->middleware('permission:create-any-school');
    Route::post('/gerenciar/estados', [StateController::class, 'store'])->name('manage.states.store')->middleware('permission:manage-location');
    Route::get('/verify/school-years', [SchoolYearController::class, 'index'])->name('manage.school-years.index')->middleware('permission:manage-school-years');
    Route::post('/gerenciar/anos-letivos/novo', [SchoolYearController::class, 'store'])->name('manage.school-years.store')->middleware('permission:create-any-school-year');
    Route::put('/gerenciar/anos-letivos/', [SchoolYearController::class, 'update'])->name('manage.school-years.update')->middleware('permission:update-any-school-year');

});
