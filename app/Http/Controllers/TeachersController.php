<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\StoreSchoolConnectionRequest;
use App\Http\Requests\StoreTeacherSchedules;
use App\Http\Requests\StoreTeacherSubjects;
use App\Models\Classes;
use App\Models\Role;
use App\Models\SchoolConnectionRequest;
use App\Models\TeachersSchools;
use App\Models\User;
use App\Models\State;
use App\Models\City;
use App\Models\TeachersSchedules;
use App\Models\TeachersSubjects;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TeachersController extends Controller
{

    /**
     * Render the teachers create view.
     */
    public function create(Request $request, Classes $class): \Illuminate\View\View
    {
        return view('teachers.create', [
            'title' => 'Cadastrar professor(a)',
            'slot' => 'Você está cadastrando um novo professor(a) para a turma ' . $class->name . '/' . $class->schoolYear->name,
            'states' => State::all(),
            'cities' => City::all(),
            'class' => $class,
        ]);
    }

    /**
     * Render Edit teacher view.
     */
    public function edit(Classes $class, $username): \Illuminate\View\View
    {
        $user = User::where('username', $username)->first();
        $datauser = $user->datauser;
        $teacherSchool = TeachersSchools::where('user_uuid', $user->uuid)->where('class_uuid', $class->uuid)->first();
        return view('teachers.edit', [
            'title' => 'Editando professor(a): ' . $user->name,
            'slot' => 'Turma: ' . $class->name . '/' . $class->schoolYear->name,
            'class' => $class,
            'user' => $user,
            'datauser' => $datauser,
            'teacherSchool' => $teacherSchool,
            'alerts' => $this->getAlerts($teacherSchool),
        ]);
    }


    /**
     * Get alerts of edit
     */
    public function getAlerts($teacherSchool): array
    {
        $alerts = [];
        if ($teacherSchool->teacherSubjects){
            $userTotalSchedules = TeachersSchedules::where('user_uuid', $teacherSchool->teacherSubjects->user_uuid)->sum('total_hours');
            $maxWeeklyWorkload = $teacherSchool->weekly_workload;
            if ($userTotalSchedules >= $maxWeeklyWorkload * 0.8) {
                $alerts[] = [
                    'type' => 'warning',
                    'message' => 'A carga horária do professor está perto de atingir o limite semanal.',
                ];
            }
        }

        return $alerts;
    }

    /**
     * Store a new teacher.
     */
    public function store(StoreEmployeeRequest $request, Classes $class)
    {
        $school_home = (new SchoolController)->getHome($request);
        if ($class->schools_uuid != $school_home->uuid) {
            return $this->response($request, 'manage.classes', 'Turma não encontrada.', 'error', 404);
        }

        $dataToCreateUser = [
            'name' => $request->nome,
            'email' => $request->email,
            'phone' => $request->celular,
            'password' => str_replace(['.', '-', '/'], '', $request->cpf),
        ];

        try {
            DB::beginTransaction();


            (new ProfileController)->store($dataToCreateUser);
            $user = User::where('email', $request->email)->first();
            $user->datauser()->create([
                'landline' => $request->telefone_fixo,
                'inep' => $request->inep,
                'cpf' => $request->cpf,
                'district' => $request->bairro,
                'birth_date' => $request->data_nascimento,
                'gender' => $request->genero,
                'rg' => $request->rg,
                'country' => $request->naturalidade,
                'street' => $request->logradouro,
                'number' => $request->numero,
                'zone' => $request->zona,
                'city' => $request->cidade,
                'city_birth' => $request->cidade_nascimento,
                'state' => $request->estado,
                'state_birth' => $request->estado_nascimento,
                'zip_code' => $request->cep,
                'mother_name' => $request->nome_mae,
                'father_name' => $request->nome_pai,
                'cpf_responsible' => $request->cpf,
                'deficiency' => $request->deficiencia ? true : false,
                'zip_code' => $request->cep,
            ]);

            $user->assignRole('teacher');
            $user->assignRoleForSchool('teacher', $school_home->uuid);
            $this->linkInClass($class->uuid, $user->uuid);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->response($request, 'manage.classes.teachers', 'Erro ao cadastrar professor(a)!', 'error', 500, 'class', $class->code);
        }

        DB::commit();
        return $this->response($request, 'manage.classes.teachers', 'Professor(a) cadastrado(a) com sucesso!', 'message', 200, 'class', $class->code);
    }

    /**
     * Render the teachers view.
     */
    public function teachers(Request $request, Classes $class): \Illuminate\View\View
    {
        $school_home = (new SchoolController)->getHome($request);
        if ($class->schools_uuid != $school_home->uuid) {
            return $this->response($request, 'manage.classes', 'Turma não encontrada.', 'error', 404);
        }
        return view('teachers.index', [
            'class' => $class,
            'title' => 'Aqui você pode gerenciar os professores da turma ' . $class->name . '/' . $class->schoolYear->name,
            'slot' => 'Os professores são responsáveis por gerenciar as notas e faltas dos alunos, e também por lançar os conteúdos e atividades.',
        ]);
    }

    /**
     * Get teachers from class.
     */
    public function getTeachers(Request $request, Classes $class)
    {
        $school_home = (new SchoolController)->getHome($request);

        if ($class->schools_uuid != $school_home->uuid) {
            return $this->response($request, 'manage.classes', 'Turma não encontrada.', 'error', 404);
        }

        if ($request->search) {
            $users = User::where('email', $request->search)->orWhere('username', $request->search)->get();
            $users = $users->filter(function ($user) {
                $class = Classes::where('code', request()->class->code)->first();
                return $user->hasRole('teacher') && !TeachersSchools::where('user_uuid', $user->uuid)->where('class_uuid', $class->uuid)->first();
            });

            return $users->map(function ($user) {
                return [
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->phone,
                    'username' => $user->username,
                ];
            });
        }

        $teachers = $class->teachers;
        return $teachers->map(function ($teacher) {
            if ($teacher->subjects) {
                $subjects = $teacher->subjects->pluck('name')->map(function ($subject) {
                    return ucfirst($subject);
                })->implode(', ');
            } else {
                $subjects = 'Nenhuma disciplina vinculada';
            }

            return [
                'name' => $teacher->user->name,
                'email' => $teacher->user->email,
                'phone' => $teacher->user->phone,
                'username' => $teacher->user->username,
                'subjects' => $subjects,
            ];
        });
    }

    /**
     * Create new request to connect school.
     */
    public function invite(StoreSchoolConnectionRequest $request, Classes $class)
    {
        $user = User::where('username', $request->username)->first();
        $role = Role::where('name', $request->role)->first();

        $isInvited = SchoolConnectionRequest::where('user_uuid', $user->uuid)
            ->where('class_uuid', $class->uuid)
            ->where('role', $role->uuid)
            ->first();

        if ($isInvited) {
            return $this->response($request, 'manage.classes.teachers', 'Solicitação de vínculo já enviada!', 'message', 200, 'class', $class->code);
        }

        $isTeacher = TeachersSchools::where('user_uuid', $user->uuid)
            ->where('class_uuid', $class->uuid)
            ->first();

        if ($isTeacher) {
            return $this->response($request, 'manage.classes.teachers', 'Professor já vinculado à turma!', 'error', 200, 'class', $class->code);
        }

        $school_connection_request = (new SchoolConnectionController)->store($class->schools_uuid, $user->uuid, $role->uuid, $class->uuid);

        (new NotificationController)->store(
            "Nova solicitação de vinculo com escola",
            "Você recebeu uma solicitação para lecionar na escola " . $school_connection_request->school->name . " na turma " . $school_connection_request->class->name . "/" . $school_connection_request->class->schoolYear->name,
            "ph ph-chalkboard",
            false,
            $school_connection_request->user_uuid,
            'request',
            $school_connection_request->uuid
        );

        return $this->response($request, 'manage.classes.teachers', 'Solicitação de vínculo enviada com sucesso!', 'message', 200, 'class', $class->code);
    }

    /**
     * Link teacher to class.
     */
    public function linkInClass($class_uuid, $user_uuid): \Illuminate\Http\JsonResponse
    {
        $class = Classes::where('uuid', $class_uuid)->first();
        TeachersSchools::create([
            'class_uuid' => $class->uuid,
            'school_uuid' => $class->school->uuid,
            'user_uuid' => $user_uuid,
        ]);

        return response()->json([
            'message' => 'Professor vinculado com sucesso!',
        ], 201);
    }


    /**
     * New Schedules for teacher.
     */
    public function linkNewSchedules(StoreTeacherSchedules $request, Classes $class)
    {
        $teacherSubject = TeachersSubjects::where('uuid', $request->teacher_subject_uuid)->first();

        if (!$teacherSubject) {
            return $this->response($request, 'manage.classes', 'Professor não encontrado.', 'error', 404);
        }

        $subject = $teacherSubject->subjects;
        $teacherSchool = TeachersSchools::where('user_uuid', $teacherSubject->user_uuid)->where('class_uuid', $class->uuid)->first();
        $maxWeeklyWorkload = $teacherSchool->weekly_workload;
        $userTotalSchedules = TeachersSchedules::where('user_uuid', $teacherSubject->user_uuid)->sum('total_hours');
        $userTotalSchedulesInSubject = TeachersSchedules::where('user_uuid', $teacherSubject->user_uuid)->where('subject_uuid', $subject->uuid)->sum('total_hours');
        $totalSubjectSchedules = TeachersSchedules::where('subject_uuid', $subject->uuid)->sum('total_hours');
        $maxSubjectWorkload = $subject->ch;

        $isSameTeacherSubject = $teacherSubject->uuid == $request->teacher_subject_uuid;
        $totalSchedulesToCheck = $isSameTeacherSubject ? ($userTotalSchedules - $userTotalSchedulesInSubject + $request->total_hours) : ($userTotalSchedules + $request->total_hours);
        $maxWorkloadToCheck = $isSameTeacherSubject ? $maxWeeklyWorkload : $maxSubjectWorkload;

        if ($totalSchedulesToCheck > $maxWorkloadToCheck) {
            $errorMsg = 'Não foi possível cadastrar o horário, pois a carga horária requerida não pode ser maior que a carga horária permitida. (' . $maxWorkloadToCheck . ' horas)';
            return $this->response($request, 'manage.classes', $errorMsg, 'error', 404);
        } else if ($totalSubjectSchedules + $request->total_hours > $maxSubjectWorkload) {
            $errorMsg = 'Não foi possível cadastrar o horário, pois a carga horária requerida não pode ser maior que a carga horária da disciplina. (' . $maxSubjectWorkload . ' horas)';
            return $this->response($request, 'manage.classes', $errorMsg, 'error', 404);
        }

        try {
            DB::beginTransaction();

            TeachersSchedules::updateOrCreate([
                'user_uuid' => $teacherSubject->user_uuid,
                'teacher_subject_uuid' => $teacherSubject->uuid,
                'subject_uuid' => $subject->uuid,
                'day' => $request->day,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
            ], [
                'total_hours' => $request->total_hours,
            ]);

            DB::commit();
            return $this->response($request, 'manage.classes.teachers', 'Horário cadastrado com sucesso!', 'message', 200, 'class', $class->code);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->response($request, 'manage.classes.teachers', 'Erro ao cadastrar horário!', 'error', 500, 'class', $class->code);
        }
    }
}
