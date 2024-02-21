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
        Route::post('/definir-escola-inicio', [SchoolController::class, 'setHome'])->name('set-school-home')->middleware('to.set.school.home');
        Route::delete('/deletar-escola-inicio', [SchoolController::class, 'deleteHome'])->name('delete-school-home');
        Route::put('/perfil', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/perfil', [ProfileController::class, 'destroy'])->name('profile.destroy');
        Route::patch('/dados-usuario', [DataUserController::class, 'update'])->name('data-user.update');
        Route::post('/gerenciar/escola/convite/aceitar', [SchoolConnectionController::class, 'acceptOrReject'])->name('invite.acceptOrReject');
        Route::put('/gerenciar/notificacao/lida', [NotificationController::class, 'markAsRead'])->name('notification.read');

        // Rotas abaixo não retornar nenhum dado comprometedor, apenas dados públicos do IBGE
        Route::get('/estados/cidades', [StateController::class, 'cities'])->name('states.cities');
        Route::get('/verificar/cidades', [CityController::class, 'index'])->name('cities.index')->middleware('permission:manage-location');
        Route::get('/verificar/estados', [StateController::class, 'index'])->name('states.index')->middleware('permission:manage-location');
        Route::get('/verificar/cidades/{code}', [CityController::class, 'show'])->name('cities.show')->middleware('permission:manage-location');
        Route::get('/verificar/estados/{code}', [StateController::class, 'show'])->name('states.show')->middleware('permission:manage-location');

        Route::middleware(['role:admin'])->group(function () {
            Route::get('/verificar/escolas', [SchoolController::class, 'index'])->name('schools.index')->middleware('permission:view-any-school');
            Route::get('/verificar/anos-letivos', [SchoolYearController::class, 'index'])->name('school-years.index')->middleware('permission:manage-school-years');
            Route::get('/anos-letivos/{schoolYear:code}', [SchoolYearController::class, 'show'])->name('school-years.show')->middleware('permission:update-any-school-year');
            Route::post('/anos-letivos/novo', [SchoolYearController::class, 'store'])->name('school-years.store')->middleware('permission:create-any-school-year');
            Route::put('/anos-letivos/', [SchoolYearController::class, 'update'])->name('school-years.update')->middleware('permission:update-any-school-year');
            Route::post('/escolas/nova', [SchoolController::class, 'store'])->name('schools.store')->middleware('permission:create-any-school');
        });

        Route::middleware(['checkIfSetSchoolHome'])->group(function () {
            // School -> Secretary
            Route::middleware(['school.role:secretary'])->group(function () {
                Route::get('/verificar/matriz-curricular', [CurriculumController::class, 'index'])->name('curriculum.index')->middleware('permission:manage-curricula');
                Route::post('/matriz-curricular/novo', [CurriculumController::class, 'store'])->name('curriculum.store')->middleware('permission:create-any-curriculum');
                Route::middleware(['school.curriculum'])->group(function () {
                    Route::get('/matriz-curricular', [CurriculumController::class, 'show'])->name('curriculum.show')->middleware('permission:update-any-curriculum');
                    Route::put('/matriz-curricular', [CurriculumController::class, 'update'])->name('curriculum.update')->middleware('permission:update-any-curriculum');
                    Route::get('/verificar/disciplinas/matriz-curricular', [SubjectsController::class, 'index'])->name('subjects.index')->middleware('permission:manage.subjects');
                    Route::post('/matriz-curricular/disciplinas', [SubjectsController::class, 'store'])->name('subjects.store')->middleware('permission:create-any-subject');
                    Route::delete('/matriz-curricular/deletar', [CurriculumController::class, 'destroy'])->name('curriculum.destroy')->middleware('permission:delete-any-curriculum');
                });
                Route::middleware(['school.curriculum.subject'])->group(function () {
                    Route::get('/verificar/disciplinas', [SubjectsController::class, 'show'])->name('subjects.show')->middleware('permission:update-any-subject');
                    Route::put('/disciplinas/', [SubjectsController::class, 'update'])->name('subjects.update')->middleware('permission:update-any-subject');
                    Route::delete('/disciplinas/deletar', [SubjectsController::class, 'destroy'])->name('subjects.destroy')->middleware('permission:delete-any-subject');
                });
            });

            // School -> Secretary | Director
            Route::middleware(['school.role:secretary|director'])->group(function () {
                Route::group(['middleware' => ['checkIfSchoolYearActive']], function () {
                    Route::get('/verificar/turmas', [ClassesController::class, 'index'])->name('classes.index')->middleware('permission:manage-classes');
                    Route::post('/turmas', [ClassesController::class, 'store'])->name('classes.store')->middleware('permission:create-any-class');
                    Route::put('/turmas', [ClassesController::class, 'update'])->name('classes.update')->middleware('permission:update-any-class');
                    Route::put('/turmas/mudar/matriz-curricular', [SetClassCurriculumController::class, 'store'])->name('classes.change.curriculum')->middleware('permission:update-any-class');

                    Route::get('/professores/turmas/{class:code}', [TeachersController::class, 'getTeachers'])->name('classes.teachers.get')->middleware('permission:manage-teachers');
                    Route::post('/salas', [RoomsController::class, 'store'])->name('rooms.store')->middleware('permission:create-any-room');
                    Route::delete('/salas', [RoomsController::class, 'destroy'])->name('rooms.destroy')->middleware('permission:delete-any-room');
                    Route::put('/salas', [RoomsController::class, 'update'])->name('rooms.update')->middleware('permission:update-any-room');

                    Route::middleware(['checkIfClassCurriculumSet'])->group(function () {
                        Route::post('/turmas/{class:code}/professores/convite', [TeachersController::class, 'invite'])->name('classes.teachers.invite')->middleware('permission:create-any-teacher');
                        Route::post('/turmas/{class:code}/professores', [TeachersController::class, 'store'])->name('classes.teachers.store')->middleware('permission:create-any-teacher');
                        Route::post('/turmas/{class:code}/professores/disciplinas', [LinkTeacherSubjectController::class, 'store'])->name('classes.teachers.subjects.link')->middleware('permission:update-any-teacher');
                        Route::delete('/turmas/{class:code}/professores/disciplinas', [UnlinkTeacherSubjectController::class, 'store'])->name('classes.teachers.subjects.unlink')->middleware('permission:update-any-teacher');

                        Route::post('/turmas/{class:code}/professores/horarios', [TeachersController::class, 'linkNewSchedules'])->name('classes.teachers.schedules')->middleware('permission:update-any-teacher');
                        Route::post('/turmas/{class:code}/alunos', [StudentsController::class, 'store'])->name('classes.students.store')->middleware('permission:create-any-student');
                        Route::get('/turmas/{class:code}/disciplinas/{teacher:username}', [GetClassSubjectsController::class, 'store'])->name('classes.subjects.get')->middleware('permission:manage-subjects');
                    });
                });
            });
        });
    });
});


