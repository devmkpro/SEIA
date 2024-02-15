<?php

namespace App\Http\Controllers\Schools\Students;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Schools\SchoolController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Requests\StoreStudentRequest;
use App\Models\Student\StudentsClass;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Classes\Classes;

class StudentsController extends Controller
{

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStudentRequest $request, Classes $class)
    {
        $school_home = (new SchoolController)->getHome($request);
        if ($class->schools_uuid != $school_home->uuid) {
            return $this->response($request, 'manage.classes', 'A turma não pertence a escola selecionada!', 'error', 500);
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
                'name_responsible'=> $request->nome_responsavel,
            ]);

            $user->assignRole('student');
            $user->assignRoleForSchool('student', $school_home->uuid);
            $this->linkInClass($class->uuid, $user->uuid);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->response($request, 'manage.classes.students.store', 'Erro ao cadastrar aluno(a)!', 'error', 500, 'class', $class->code);
        }

        DB::commit();
        return $this->response($request, 'manage.classes.students.store', 'Aluno(a) cadastrado(a) com sucesso!', 'message', 200, 'class', $class->code);
    

    }

    /**
     * link in class
     */
    public function linkInClass($class_uuid, $user_uuid): \Illuminate\Http\JsonResponse
    {
        StudentsClass::create([
            'user_uuid' => $user_uuid,
            'classes_uuid' => $class_uuid,
        ]);

        return response()->json([
            'message' => 'Aluno(a) cadastrado(a) com sucesso!',
        ], 200);
    }
}
