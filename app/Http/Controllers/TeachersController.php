<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\StoreSchoolConnectionRequest;
use App\Models\Classes;
use App\Models\Role;
use App\Models\SchoolConnectionRequest;
use App\Models\TeachersSchoolsSubjects;
use App\Models\User;
use App\Models\State;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TeachersController extends Controller
{

    /**
     * Render the teachers create view.
     */
    public function create(Request $request, $code): \Illuminate\View\View
    {
        $class = Classes::where('code', $code)->first();
        if (!$class) {
            return $this->response($request, 'manage.classes', 'Turma não encontrada.', 'error', 404);
        }
        return view('teachers.create', [
            'title' => 'Cadastrar professor(a)',
            'slot' => 'Você está cadastrando um novo professor(a) para a turma ' . $class->name . '/' . $class->schoolYear->name,
            'states' => State::all(),
            'cities' => City::all(),
            'class' => $class,
        ]);
    }

    /**
     * Store a new teacher.
     */
    public function store(StoreEmployeeRequest $request, $class_code)
    {
        $school_home = (new SchoolController)->getHome($request);
        $class = Classes::where('code', $class_code)->where('schools_uuid', $school_home->uuid)->first();
        
        if (!$class || $class->schools_uuid != $school_home->uuid) {
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
                'deficiency' => $request->deficiencia,
                'zip_code' => $request->cep,
            ]);

            $user->assignRole('teacher');
            $user->assignRoleForSchool('teacher', $school_home->uuid);
            $this->linkinClass($class->uuid, $user->uuid);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->response($request, 'manage.classes.teachers', 'Erro ao cadastrar professor(a)!', 'error', 500, 'code', $class->code);
        }

        DB::commit();
        return $this->response($request, 'manage.classes.teachers', 'Professor(a) cadastrado(a) com sucesso!', 'message', 200, 'code', $class->code);
    }

    /**
     * Render the teachers view.
     */
    public function teachers(Request $request, $class_code)
    {
        $school_home = (new SchoolController)->getHome($request);
        $class = Classes::where('code', $class_code)->where('schools_uuid', $school_home->uuid)->first();
        if (!$class || $class->schools_uuid != $school_home->uuid) {
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
    public function getTeachers(Request $request, $class_code)
    {
        $school_home = (new SchoolController)->getHome($request);
        $class = Classes::where('code', $class_code)->where('schools_uuid', $school_home->uuid)->first();

        if (!$class || $class->schools_uuid != $school_home->uuid) {
            return $this->response($request, 'manage.classes', 'Turma não encontrada.', 'error', 404);
        }

        if ($request->search) {
            $users = User::where('email', $request->search)->orWhere('username', $request->search)->get();
            $users = $users->filter(function ($user) {
                $class = Classes::where('code', request()->code)->first();
                return $user->hasRole('teacher') && !TeachersSchoolsSubjects::where('user_uuid', $user->uuid)->where('class_uuid', $class->uuid)->first();
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
    public function invite(StoreSchoolConnectionRequest $request, $code)
    {
        $class = Classes::where('code', $code)->first();
        if (!$class) {
            return $this->response($request, 'manage.classes', 'Turma não encontrada.', 'error', 404);
        }

        $user = User::where('username', $request->username)->first();
        $role = Role::where('name', $request->role)->first();

        $isInvited = SchoolConnectionRequest::where('user_uuid', $user->uuid)
            ->where('class_uuid', $class->uuid)
            ->where('role', $role->uuid)
            ->first();

        if ($isInvited) {
            return $this->response($request, 'manage.classes.teachers', 'Solicitação de vínculo já enviada!', 'message', 200, 'code', $class->code);
        }

        $isTeacher = TeachersSchoolsSubjects::where('user_uuid', $user->uuid)
            ->where('class_uuid', $class->uuid)
            ->first();

        if ($isTeacher) {
            return $this->response($request, 'manage.classes.teachers', 'Professor já vinculado à turma!', 'error', 200, 'code', $class->code);
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

        return $this->response($request, 'manage.classes.teachers', 'Solicitação de vínculo enviada com sucesso!', 'message', 200, 'code', $class->code);
    }

    /**
     * Link teacher to class.
     */
    public function linkinClass($class_uuid, $user_uuid)
    {
        $class = Classes::where('uuid', $class_uuid)->first();
        TeachersSchoolsSubjects::create([
            'class_uuid' => $class->uuid,
            'school_uuid' => $class->school->uuid,
            'user_uuid' => $user_uuid,
        ]);

        return response()->json([
            'message' => 'Professor vinculado com sucesso!',
        ], 201);
    }
}
