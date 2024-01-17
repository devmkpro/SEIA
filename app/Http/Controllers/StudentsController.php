<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StudentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStudentRequest $request, Classes $class)
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
                'deficiency' => $request->deficiencia,
                'zip_code' => $request->cep,
                'cpf_responsible'=> $request->cpf_responsavel,
                'name_responsible'=> $request->nome_responsavel,
            ]);

            $user->assignRole('student');
            $user->assignRoleForSchool('student', $school_home->uuid);
            $this->linkinClass($class->uuid, $user->uuid);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->response($request, 'manage.classes.students.store', 'Erro ao cadastrar aluno(a)!', 'error', 500, 'class', $class->code);
        }

        DB::commit();
        return $this->response($request, 'manage.classes.students.store', 'Aluno(a) cadastrado(a) com sucesso!', 'message', 200, 'class', $class->code);
    

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
