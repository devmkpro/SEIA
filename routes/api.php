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
    Route::post('/definir-escola-inicio', [SchoolController::class, 'setHome'])->name('set-school-home')->middleware('to.set.school.home');
    Route::delete('/deletar-escola-inicio', [SchoolController::class, 'deleteHome'])->name('delete-school-home');
    Route::put('/perfil', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/perfil', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::patch('/dados-usuario', [DataUserController::class, 'update'])->name('data-user.update');
    Route::post('/gerenciar/escola/convite/aceitar', [SchoolConnectionController::class, 'acceptOrReject'])->name('manage.invite.acceptOrReject');
    Route::put('/gerenciar/notificacao/lida', [NotificationController::class, 'markAsRead'])->name('notification.read');

    // Rotas abaixo não retornar nenhum dado comprometedor, apenas dados publicos do ibge
    Route::get('/estados/cidades', [StateController::class, 'cities'])->name('manage.states.cities');
    Route::get('/verificar/cidades', [CityController::class, 'index'])->name('manage.cities.index')->middleware('permission:manage-location');
    Route::get('/verificar/estados', [StateController::class, 'index'])->name('manage.states.index')->middleware('permission:manage-location');
    Route::get('/verificar/cidades/{code}', [CityController::class, 'show'])->name('manage.cities.show')->middleware('permission:manage-location');
    Route::get('/verificar/estados/{code}', [StateController::class, 'show'])->name('manage.states.show')->middleware('permission:manage-location');

    Route::middleware(['role:admin'])->group(function () {
        Route::get('/verificar/escolas', [SchoolController::class, 'index'])->name('manage.schools.index')->middleware('permission:view-any-school');
        Route::get('/verificar/anos-letivos', [SchoolYearController::class, 'index'])->name('manage.school-years.index')->middleware('permission:manage-school-years');
        Route::get('/gerenciar/anos-letivos/{schoolYear:code}', [SchoolYearController::class, 'show'])->name('manage.school-years.show')->middleware('permission:update-any-school-year');
        Route::post('/gerenciar/anos-letivos/novo', [SchoolYearController::class, 'store'])->name('manage.school-years.store')->middleware('permission:create-any-school-year');
        Route::put('/gerenciar/anos-letivos/', [SchoolYearController::class, 'update'])->name('manage.school-years.update')->middleware('permission:update-any-school-year');
        Route::post('/gerenciar/escolas/nova', [SchoolController::class, 'store'])->name('manage.schools.store')->middleware('permission:create-any-school');
    });

    // school_home required
    Route::group(['middleware' => ['checkIfSetSchoolHome']], function () {
        // School -> Secretary
        Route::group(['middleware' => ['school.role:secretary']], function () {
            Route::get('/verificar/curriculo', [CurriculumController::class, 'index'])->name('manage.curriculum.index')->middleware('permission:manage-curricula');
            Route::post('/gerenciar/curriculo/novo', [CurriculumController::class, 'store'])->name('manage.curriculum.store')->middleware('permission:create-any-curriculum');
            // Require Curriculum in request
            Route::middleware(['school.curriculum'])->group(function () {
                Route::get('/gerenciar/curriculo', [CurriculumController::class, 'show'])->name('manage.curriculum.show')->middleware('permission:update-any-curriculum');
                Route::put('/gerenciar/curriculo', [CurriculumController::class, 'update'])->name('manage.curriculum.update')->middleware('permission:update-any-curriculum');
                Route::get('/verificar/disciplinas/curriculo', [SubjectsController::class, 'index'])->name('manage.subjects.index')->middleware('permission:manage.subjects');
                Route::post('/gerenciar/curriculo/disciplinas', [SubjectsController::class, 'store'])->name('manage.subjects.store')->middleware('permission:create-any-subject');
                Route::delete('/gerenciar/curriculo/deletar', [CurriculumController::class, 'destroy'])->name('manage.curriculum.destroy')->middleware('permission:delete-any-curriculum');
            });
            // Require Subject in request
            Route::middleware(['school.curriculum.subject'])->group(function () {
                Route::get('/verificar/disciplinas', [SubjectsController::class, 'show'])->name('manage.subjects.show')->middleware('permission:update-any-subject');
                Route::put('/gerenciar/disciplinas/', [SubjectsController::class, 'update'])->name('manage.subjects.update')->middleware('permission:update-any-subject');
                Route::delete('/gerenciar/disciplinas/deletar', [SubjectsController::class, 'destroy'])->name('manage.subjects.destroy')->middleware('permission:delete-any-subject');
            });
        });

        // School -> Secretary | Director
        Route::middleware(['school.role:secretary|director'])->group(function () {
            Route::group(['middleware' => ['checkIfSchoolYearActive']], function () {

                Route::get('/verificar/turmas', [ClassesController::class, 'index'])->name('manage.classes.index')->middleware('permission:manage-classes');
                Route::post('/gerenciar/turmas', [ClassesController::class, 'store'])->name('manage.classes.store')->middleware('permission:create-any-class');
                Route::put('/gerenciar/turmas', [ClassesController::class, 'update'])->name('manage.classes.update')->middleware('permission:update-any-class');
                Route::put('/gerenciar/turmas/mudar/curriculo', [SetClassCurriculumController::class, 'store'])->name('manage.classes.change.curriculum')->middleware('permission:update-any-class');

                Route::get('/gerenciar/professores/turmas/{class:code}', [TeachersController::class, 'getTeachers'])->name('manage.classes.teachers.get')->middleware('permission:manage-teachers');
                Route::post('/gerenciar/salas', [RoomsController::class, 'store'])->name('manage.rooms.store')->middleware('permission:create-any-room');
                Route::delete('/gerenciar/salas', [RoomsController::class, 'destroy'])->name('manage.rooms.destroy')->middleware('permission:delete-any-room');
                Route::put('/gerenciar/salas', [RoomsController::class, 'update'])->name('manage.rooms.update')->middleware('permission:update-any-room');
                
                
                // checkIfClassCurriculumSet necessita de class:code valido
                Route::middleware(['checkIfClassCurriculumSet'])->group(function () {
                    Route::post('/gerenciar/turmas/{class:code}/professores/convite', [TeachersController::class, 'invite'])->name('manage.classes.teachers.invite')->middleware('permission:create-any-teacher');
                    Route::post('/gerenciar/turmas/{class:code}/professores', [TeachersController::class, 'store'])->name('manage.classes.teachers.store')->middleware('permission:create-any-teacher');
                    Route::post('/gerenciar/turmas/{class:code}/professores/disciplinas', [LinkTeacherSubjectController::class, 'store'])->name('manage.classes.teachers.subjects.link')->middleware('permission:update-any-teacher');
                    Route::delete('/gerenciar/turmas/{class:code}/professores/disciplinas', [UnlinkTeacherSubjectController::class, 'store'])->name('manage.classes.teachers.subjects.unlink')->middleware('permission:update-any-teacher');

                    Route::post('/gerenciar/turmas/{class:code}/professores/horarios', [TeachersController::class, 'linkNewSchedules'])->name('manage.classes.teachers.schedules')->middleware('permission:update-any-teacher');
                    Route::post('/gerenciar/turmas/{class:code}/alunos', [StudentsController::class, 'store'])->name('manage.classes.students.store')->middleware('permission:create-any-student');
                    Route::get('/gerenciar/turmas/{class:code}/disciplinas/{teacher:username}', [GetClassSubjectsController::class, 'store'])->name('manage.classes.subjects.get')->middleware('permission:manage-subjects');
                });
                
            });
        });
    });
});

