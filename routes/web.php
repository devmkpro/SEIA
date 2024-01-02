<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DataUserController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\SchoolYearController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/', function () {
    return view('welcome');
})->middleware(['auth', 'web'])->name('panel');

Route::middleware(['auth', 'web'])->group(function () {
    Route::get('/perfil', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::patch('/data-user', [DataUserController::class, 'update'])->name('data-user.update');
    Route::post('/set-school-home', [SchoolController::class, 'setHome'])->name('set-school-home');
    Route::delete('/delete-school-home', [SchoolController::class, 'deleteHome'])->name('delete-school-home');
});

Route::middleware(['auth', 'web', 'role:admin'])->group(function () {
    Route::get('/gerenciar/estados', [StateController::class, 'states'])->name('manage.states')->middleware('permission:manage-location');
    Route::get('/gerenciar/cidades', [CityController::class, 'cities'])->name('manage.cities')->middleware('permission:manage-location');
    Route::get('/gerenciar/escolas/nova', [SchoolController::class, 'create'])->name('manage.schools.create')->middleware('permission:create-any-school');
    Route::get('/gerenciar/escolas', [SchoolController::class, 'schools'])->name('manage.schools')->middleware('permission:update-any-school');
    Route::get('/gerenciar/anos-letivos', [SchoolYearController::class, 'schoolsyears'])->name('manage.school-years')->middleware('permission:update-any-school-year');
    Route::get('/gerenciar/anos-letivos/{schoolYear}', [SchoolYearController::class, 'show'])->name('manage.school-years.show')->middleware('permission:update-any-school-year');

});


//Route::middleware(['auth', 'school.role:teacher'])->group(function () {
    // EXEMPLO! PARA FUNCIONAR REQUER school_home NO COOKIE COM encrypt
    // verifica a role especifica para a escola ou se é admin
//});





require __DIR__.'/auth.php';
