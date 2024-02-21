<?php
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Location\CityController;
use App\Http\Controllers\Location\StateController;
use App\Http\Controllers\Schools\Classes\ClassesController;
use App\Http\Controllers\Schools\Classes\GetClassSubjectsController;
use App\Http\Controllers\Schools\Classes\SetClassCurriculumController;
use App\Http\Controllers\Schools\Curriculums\CurriculumController;
use App\Http\Controllers\Schools\Rooms\RoomsController;
use App\Http\Controllers\Schools\SchoolConnectionController;
use App\Http\Controllers\Schools\SchoolController;
use App\Http\Controllers\Schools\SchoolYearController;
use App\Http\Controllers\Schools\Subjects\SubjectsController;
use App\Http\Controllers\Schools\Teachers\TeachersController;
use App\Http\Controllers\Schools\Teachers\UnlinkTeacherSubjectController;
use App\Http\Controllers\User\Data\DataUserController;
use App\Http\Controllers\User\Notification\NotificationController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\Schools\Students\StudentsController;
use App\Http\Controllers\Schools\Teachers\LinkTeacherSubjectController;
use Illuminate\Support\Facades\Route;


Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::group(['middleware' => ['api', 'auth:sanctum']], function () {
    Route::prefix('gerenciar')->name('manage.')->group(function () {
        Route::put('/perfil', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/perfil', [ProfileController::class, 'destroy'])->name('profile.destroy');
        Route::post('/definir-escola-inicio', [SchoolController::class, 'setHome'])->name('set-school-home')->middleware('to.set.school.home');
        Route::delete('/deletar-escola-inicio', [SchoolController::class, 'deleteHome'])->name('delete-school-home');
        Route::patch('/dados-usuario', [DataUserController::class, 'update'])->name('data-user.update');
        Route::post('/gerenciar/escola/convite/aceitar', [SchoolConnectionController::class, 'acceptOrReject'])->name('invite.acceptOrReject');
        Route::put('/gerenciar/notificacao/lida', [NotificationController::class, 'markAsRead'])->name('notification.read');

        // Rotas abaixo não retornar nenhum dado comprometedor, apenas dados públicos do IBGE
        Route::prefix('localizacao')->name('location.')->group(function () {

            Route::prefix('cidades')->name('cities.')->group(function () {
                Route::get('/', [CityController::class, 'index'])->name('index')->middleware('permission:manage-location');
                Route::get('/verificar/{code}', [CityController::class, 'show'])->name('show')->middleware('permission:manage-location');
            });

            Route::prefix('estados')->name('states.')->group(function () {
                Route::get('/', [StateController::class, 'index'])->name('index')->middleware('permission:manage-location');
                Route::get('/verificar/{code}', [StateController::class, 'show'])->name('show')->middleware('permission:manage-location');
                Route::get('/cidades', [StateController::class, 'cities'])->name('cities')->middleware('permission:manage-location');

            });
            
          
        });


        Route::middleware(['role:admin'])->group(function () {
            Route::get('escolas', [SchoolController::class, 'index'])->name('schools.index')->middleware('permission:view-any-school');
            Route::get('/anos-letivos', [SchoolYearController::class, 'index'])->name('school-years.index')->middleware('permission:manage-school-years');
            Route::get('/anos-letivos/{schoolYear:code}', [SchoolYearController::class, 'show'])->name('school-years.show')->middleware('permission:update-any-school-year');
            Route::post('/anos-letivos/novo', [SchoolYearController::class, 'store'])->name('school-years.store')->middleware('permission:create-any-school-year');
            Route::put('/anos-letivos', [SchoolYearController::class, 'update'])->name('school-years.update')->middleware('permission:update-any-school-year');
            Route::post('/escolas/nova', [SchoolController::class, 'store'])->name('schools.store')->middleware('permission:create-any-school');
        });

        Route::middleware(['checkIfSetSchoolHome'])->group(function () {
            // School -> Secretary
            Route::middleware(['school.role:secretary'])->group(function () {
                Route::prefix('matriz-curricular')->group(function () {
                    Route::name('curriculum.')->group(function () {
                        Route::get('/', [CurriculumController::class, 'index'])->name('index')->middleware('permission:manage-curricula');
                        Route::post('adicionar', [CurriculumController::class, 'store'])->name('store')->middleware('permission:create-any-curriculum');
                        Route::middleware(['school.curriculum'])->group(function () {
                            Route::get('verificar', [CurriculumController::class, 'show'])->name('show')->middleware('permission:update-any-curriculum');
                            Route::put('atualizar', [CurriculumController::class, 'update'])->name('update')->middleware('permission:update-any-curriculum');
                            Route::delete('deletar', [CurriculumController::class, 'destroy'])->name('destroy')->middleware('permission:delete-any-curriculum');
                        });

                    });

                    Route::prefix('disciplinas')->group(function () {
                        Route::group(['name' => 'subjects.'], function () {
                            Route::middleware(['school.role:secretary'])->group(function () {
                                Route::get('/', [SubjectsController::class, 'index'])->name('index')->middleware('permission:manage.subjects');
                                Route::post('adicionar', [SubjectsController::class, 'store'])->name('store')->middleware('permission:create-any-subject');
                            });

                            Route::middleware(['school.curriculum.subject'])->group(function () {
                                Route::get('verificar', [SubjectsController::class, 'show'])->name('show')->middleware('permission:update-any-subject');
                                Route::put('atualizar', [SubjectsController::class, 'update'])->name('update')->middleware('permission:update-any-subject');
                                Route::delete('deletar', [SubjectsController::class, 'destroy'])->name('destroy')->middleware('permission:delete-any-subject');
                            });
                        });

                    });

                });



            });

            // School -> Secretary | Director
            Route::middleware(['school.role:secretary|director'])->group(function () {
                Route::group(['middleware' => ['checkIfSchoolYearActive']], function () {
                    Route::prefix('turmas')->name('classes.')->group(function () {
                        Route::get('/', [ClassesController::class, 'index'])->name('index')->middleware('permission:manage-classes');
                        Route::post('adicionar', [ClassesController::class, 'store'])->name('store')->middleware('permission:create-any-class');
                        Route::put('atualizar', [ClassesController::class, 'update'])->name('update')->middleware('permission:update-any-class');
                        Route::put('/alterar/matriz-curricular', [SetClassCurriculumController::class, 'store'])->name('change.curriculum')->middleware('permission:update-any-class');
                        Route::get('/{class:code}/professores', [TeachersController::class, 'getTeachers'])->name('teachers.get')->middleware('permission:manage-teachers');

                        Route::middleware(['checkIfClassCurriculumSet'])->group(function () {

                            Route::post('/{class:code}/professores/convite', [TeachersController::class, 'invite'])->name('teachers.invite')->middleware('permission:create-any-teacher');
                            Route::post('/{class:code}/professores/adicionar', [TeachersController::class, 'store'])->name('teachers.store')->middleware('permission:create-any-teacher');

                            Route::post('/{class:code}/professores/disciplinas/vincular', [LinkTeacherSubjectController::class, 'store'])->name('teachers.subjects.link')->middleware('permission:update-any-teacher');
                            Route::delete('/{class:code}/professores/disciplinas/desvincular', [UnlinkTeacherSubjectController::class, 'store'])->name('teachers.subjects.unlink')->middleware('permission:update-any-teacher');

                            Route::post('/{class:code}/professores/horarios', [TeachersController::class, 'linkNewSchedules'])->name('teachers.schedules')->middleware('permission:update-any-teacher');
                            Route::post('/{class:code}/alunos', [StudentsController::class, 'store'])->name('students.store')->middleware('permission:create-any-student');
                            Route::get('/{class:code}/disciplinas/{teacher:username}', [GetClassSubjectsController::class, 'store'])->name('subjects.get')->middleware('permission:manage-subjects');
                        });
                    });
                });

                Route::prefix('salas')->name('rooms.')->group(function () {
                    Route::post('', [RoomsController::class, 'store'])->name('store')->middleware('permission:create-any-room');
                    Route::delete('', [RoomsController::class, 'destroy'])->name('destroy')->middleware('permission:delete-any-room');
                    Route::put('', [RoomsController::class, 'update'])->name('update')->middleware('permission:update-any-room');
                });
            });
        });
    });
});


