<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreClassesRequest;
use App\Models\Classes;
use App\Models\Curriculum;

class ClassesController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $school_home = (new SchoolController)->getHome($request);
        $school_year = (new SchoolYearController)->getActive();
        return response()->json(Classes::where('schools_uuid', $school_home->uuid)->where('school_years_uuid', $school_year->uuid)->get()->map(function ($class) {
            return [
                'status' => $class->status ? 'Ativa' : 'Inativa',
                'name' => $class->name,
                'school_year' => $class->schoolYear->name,
                'code' => $class->code,
                'turno' => $class->turn == 'morning' ? 'Manhã' : ($class->turn == 'afternoon' ? 'Tarde' : 'Noite'),
                'max_students' => $class->max_students,
            ];
        }));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreClassesRequest $request)
    {
        $school_home = (new SchoolController)->getHome($request);
        $school_year = (new SchoolYearController)->getActive();

        Classes::create([
            'name' => $request->nome,
            'turn' => $request->turno,
            'monday' => $request->segunda,
            'modality' => $request->modalidade,
            'tuesday' => $request->terca,
            'wednesday' => $request->quarta,
            'thursday' => $request->quinta,
            'friday' => $request->sexta,
            'saturday' => $request->sabado,
            'sunday' => $request->domingo,
            'max_students' => $request->max_estudantes,
            'room' => $request->sala,
            'start_time' => $request->horario_inicio,
            'end_time' => $request->horario_fim,
            'schools_uuid' => $school_home->uuid,
            'school_years_uuid' => $school_year->uuid,
        ]);

        return $this->response($request, 'manage.classes', 'Turma criada com sucesso.', 'message', 201);
    }

    /**
     * Index classes.
     */
    public function classes()
    {
        return view('classes.index', [
            'title' => 'Gerenciar Turmas',
            'slot' => 'Você está gerenciando as turmas da sua escola do ano de ' . (new SchoolYearController)->getActive()->name,
        ]);
    }

    /**
     * edit class by code.
     */
    public function edit(Request $request, $code)
    {
        $school_home = (new SchoolController)->getHome($request);
        $class = Classes::where('code', $code)->where('schools_uuid', $school_home->uuid)->first();
        if (!$class) {
            return $this->response($request, 'manage.classes', 'Turma não encontrada.', 'error', 404);
        }
        $curriculumns = Curriculum::where('school_uuid', $school_home->uuid)->get();
        $curriculumns = $curriculumns->map(function ($curriculum) {
            return [
                'uuid' => encrypt($curriculum->uuid),
                'series' => (new CurriculumController)->formatSeries($curriculum->series),
            ];
        });
        return view('classes.edit', [
            'title' => 'Gerenciar Turma',
            'slot' => 'Você está gerenciando a turma do ' . $class->name . '/' . $class->schoolYear->name,
            'class' => $class,
            'curriculum_modality' => $class->curriculum ? (new CurriculumController)->formatSeries($class->curriculum->series) : null,
            'curriculums' => $curriculumns,
        ]);
    }

    /**
     * Set class curriculum.
     */
    public function setCurriculum(Request $request, $code)
    {
        $school_home = (new SchoolController)->getHome($request);
        $class = Classes::where('code', $code)->where('schools_uuid', $school_home->uuid)->first();

        try{
            $curriculum = Curriculum::where('uuid', decrypt($request->curriculum))->where('school_uuid', $school_home->uuid)->first();
        } catch(\Exception $e){
            return $this->response($request, 'manage.classes.edit', 'Matriz curricular não encontrada.', 'error', 404, 'code', $code);
        }

        if (!$class || !$curriculum) {
            return $this->response($request, 'manage.classes.edit', 'Matriz curricular não encontrada.', 'error', 404, 'code', $code);
        }

        $class->update([
            'curriculum_uuid' => $curriculum->uuid,
        ]);

        return $this->response($request, 'manage.classes.edit', 'Matriz curricular alterada com sucesso.', 'message', 200, 'code', $code);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreClassesRequest $request, $code)
    {
        $school_home = (new SchoolController)->getHome($request);
        $class = Classes::where('code', $code)->where('schools_uuid', $school_home->uuid)->first();
        if (!$class) {
            return $this->response($request, 'manage.classes', 'Turma não encontrada.', 'error', 404);
        }
        $class->update([
            'name' => $request->nome,
            'turn' => $request->turno,
            'monday' => $request->segunda,
            'modality' => $request->modalidade,
            'tuesday' => $request->terca,
            'wednesday' => $request->quarta,
            'thursday' => $request->quinta,
            'friday' => $request->sexta,
            'saturday' => $request->sabado,
            'sunday' => $request->domingo,
            'max_students' => $request->max_estudantes,
            'room' => $request->sala,
            'start_time' => $request->horario_inicio,
            'end_time' => $request->horario_fim,
        ]);
        return $this->response($request, 'manage.classes.edit', 'Turma alterada com sucesso.', 'message', 200, 'code', $code);
    }
}
