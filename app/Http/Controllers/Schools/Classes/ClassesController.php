<?php

namespace App\Http\Controllers\Schools\Classes;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Schools\Curriculums\CurriculumController;
use App\Http\Controllers\Schools\SchoolController;
use App\Http\Controllers\Schools\SchoolYearController;
use Illuminate\Http\Request;
use App\Http\Requests\StoreClassesRequest;
use Illuminate\View\View;
use App\Models\Curriculum\Curriculum;
use App\Models\Classes\Classes;


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
                'class' => $class->code,
                'turno' => $class->turn == 'morning' ? 'Manhã' : ($class->turn == 'afternoon' ? 'Tarde' : 'Noite'),
                'max_students' => $class->max_students,
            ];
        }));
    }

    /**
     * Index classes.
     */
    public function classes(Request $request): View
    {
        $school_home = (new SchoolController)->getHome($request);
        $school_year = (new SchoolYearController)->getActive();

        $classes = Classes::where('schools_uuid', $school_home->uuid)->where('school_years_uuid', $school_year->uuid)->get()->map(function ($class) {
            return [
                'status' => $class->status ? 'Ativa' : 'Inativa',
                'name' => $class->name,
                'school_year' => $class->schoolYear->name,
                'code' => $class->code,
                'turno' => $class->turn == 'morning' ? 'Manhã' : ($class->turn == 'afternoon' ? 'Tarde' : 'Noite'),
                'max_students' => $class->max_students,
            ];
        });

        return view('classes.index', [
            'title' => 'Gerenciar Turmas',
            'slot' => 'Você está gerenciando as turmas da sua escola do ano de ' . (new SchoolYearController)->getActive()->name,
            'classes' => $classes,
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreClassesRequest $request): mixed
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
            'primary_room' => $request->sala,
            'start_time' => $request->horario_inicio,
            'end_time' => $request->horario_fim,
            'schools_uuid' => $school_home->uuid,
            'school_years_uuid' => $school_year->uuid,
        ]);

        return $this->response($request, 'manage.classes', 'Turma criada com sucesso.', 'message', 201);
    }

    /**
     * edit class by code.
     */
    public function edit(Request $request, Classes $class): mixed
    {
        $school_home = (new SchoolController)->getHome($request);
        $curriculumns = Curriculum::where('school_uuid', $school_home->uuid)->get();
        $curriculumController = new CurriculumController;
        $curriculumns = $curriculumns->map(function ($curriculum) use ($curriculumController) {
            return [
                'uuid' => encrypt($curriculum->uuid),
                'code' => $curriculum->code,
                'series' => $curriculumController->formatSeries($curriculum->series),
                'modality' => $curriculumController->formatModality($curriculum->modality),
                'turn' => $curriculumController->formatTurn($curriculum->turn),
            ];
        });

        return view('classes.edit', [
            'title' => 'Gerenciar Turma',
            'slot' => 'Você está gerenciando a turma do ' . $class->name . '/' . $class->schoolYear->name,
            'class' => $class,
            'curriculum_modality' => $class->curriculum ? $curriculumController->formatSeries($class->curriculum->series) : null,
            'curriculums' => $curriculumns,
            'alerts' => $this->getAlerts($class),
        ]);
    }

    /**
     * Get alerts of edit
     */
    public function getAlerts(Classes $class): array
    {
        $alerts = [];
        if (!$class->curriculum) {
            $alerts[] = [
                'type' => 'danger',
                'message' => 'Turma sem matriz curricular.',
            ];
        }

        if ($class->teachers->count() == 0) {
            $alerts[] = [
                'type' => 'warning',
                'message' => 'Turma sem professores.',
            ];
        }

        return $alerts;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreClassesRequest $request): mixed
    {
        $school_home = (new SchoolController)->getHome($request);
        $class = Classes::where('code', $request->class)->first();

        if ($class->schools_uuid != $school_home->uuid) {
            return $this->response($request, 'manage.classes.edit', 'Turma não encontrada.', 'error', 404, 'class', $class->code);
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
            'primary_room' => $request->sala,
            'start_time' => $request->horario_inicio,
            'end_time' => $request->horario_fim,
        ]);

        return $this->response($request, 'manage.classes.edit', 'Turma alterada com sucesso.', 'message', 200, 'class', $class->code);
    }
}
