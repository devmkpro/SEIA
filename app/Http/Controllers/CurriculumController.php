<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Curriculum;
use App\Http\Requests\StoreCurriculumRequest;

class CurriculumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): \Illuminate\Http\JsonResponse
    {
        $school_home = (new SchoolController)->getHome($request);
        $curriculums = Curriculum::where('school_uuid', $school_home->uuid)->get()->map(function ($curriculum) {
            return [
                'code' => $curriculum->code,
                'series' => $this->formatSeries($curriculum->series),
                'modality' => $this->formatModality($curriculum->modality),
                'weekly_hours' => $curriculum->weekly_hours,
                'start_time' => $curriculum->start_time,
                'end_time' => $curriculum->end_time,
                'total_hours' => $curriculum->total_hours,
            ];
        });

        return response()->json($curriculums);
    }

    /**
     * Render the curriculum view.
     */
    public function curriculum(): \Illuminate\View\View
    {
        return view('secretary.curriculum.index', [
            'title' => 'Matrizes Curriculares',
            'slot' => 'Olá, nesta página você pode gerenciar as matrizes curriculares da sua escola! Filtrando por modalidade e série, você pode adicionar, editar e excluir as disciplinas que compõem a matriz curricular.',
        ]);
    }

    /**
     * Format the series.
     */
    public function formatSeries($series): string
    {
        $seriesMap = [
            'educ_infa_cc_0_3' => 'Educação Infantil - Creche (0 a 3 anos)',
            'educ_infa_cc_4_5' => 'Educação Infantil - Creche (4 a 5 anos)',
            'educ_ini_1_5' => 'Ensino Fundamental - Anos Iniciais (1º ao 5º ano)',
            'educ_ini_6_9' => 'Ensino Fundamental - Anos Finais (6º ao 9º ano)',
            'educ_med_1' => 'Ensino Médio - 1º ano',
            'educ_med_2' => 'Ensino Médio - 2º ano',
            'educ_med_3' => 'Ensino Médio - 3º ano',
            'courses' => 'Curso',
            'other' => 'Outro',
        ];

        return $seriesMap[$series] ?? '';
    }

    /**
     * Format the modality.
     */
    public function formatModality($modality): string
    {
        $modalityMap = [
            'bercario' => 'Berçário',
            'creche' => 'Creche',
            'pre_escola' => 'Pré-escola',
            'fundamental' => 'Ensino Fundamental',
            'medio' => 'Ensino Médio',
            'eja' => 'EJA',
            'educacao_especial' => 'Educação Especial',
            'tecnico' => 'Técnico',
            'other' => 'Outro',
        ];

        return $modalityMap[$modality] ?? '';
    }

    /**
     * Format the turn.
     */
    public function formatTurn($turn): string
    {
        $turnMap = [
            'morning' => 'Manhã',
            'afternoon' => 'Tarde',
            'night' => 'Noite',
            'integral' => 'Integral',
            'other' => 'Outro',
        ];

        return $turnMap[$turn] ?? '';
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCurriculumRequest $request): mixed
    {
        $school_home = (new SchoolController)->getHome($request);
        Curriculum::create([
            'school_uuid' => $school_home->uuid,
            'series' => $request->serie,
            'modality' => $request->modalidade,
            'weekly_hours' => $request->horas_semanais,
            'total_hours' => $request->horas_totais,
            'start_time' => $request->hora_início,
            'end_time' => $request->hora_final,
            'description' => $request->descricao,
            'complementary_information' => $request->informacoes_complementares,
            'default_time_class' => $request->tempo_padrao_de_aula,
            'turn' => $request->turno,
        ]);

        return $this->response($request, 'manage.curriculum', 'Matriz curricular cadastrada com sucesso!');
    }

    /**
     * Edit the curriculum.
     */
    public function edit(Curriculum $curriculum): \Illuminate\View\View
    {
        return view('secretary.curriculum.edit', [
            'title' => 'Editar Matriz Curricular',
            'slot' => 'Você está editando a matriz curricular: ' . $this->formatSeries($curriculum->series) . ' - ' . $this->formatTurn($curriculum->turn) . '.',
            'seriesFormated' => $this->formatSeries($curriculum->series),
            'modalityFormated' => $this->formatModality($curriculum->modality),
            'curriculum' => $curriculum,
        ]);
    }

    /**
     * Show the curriculum.
     */
    public function show(Request $request): \Illuminate\Http\JsonResponse
    {
        $curriculum = Curriculum::where('code', $request->curriculum)->firstOrFail();
        return response()->json([
            'series' => $curriculum->series,
            'modality' => $curriculum->modality,
            'weekly_hours' => $curriculum->weekly_hours,
            'start_time' => $curriculum->start_time,
            'end_time' => $curriculum->end_time,
            'total_hours' => $curriculum->total_hours,
            'description' => $curriculum->description,
            'complementary_information' => $curriculum->complementary_information,
            'default_time_class' => $curriculum->default_time_class,
            'turn' => $curriculum->turn,
        ]);
    }

    /**
     * Update the curriculum.
     */
    public function update(StoreCurriculumRequest $request): mixed
    {
        $curriculum = Curriculum::where('code', $request->curriculum)->firstOrFail();
        $curriculum->update([
            'series' => $request->serie,
            'modality' => $request->modalidade,
            'weekly_hours' => $request->horas_semanais,
            'total_hours' => $request->horas_totais,
            'start_time' => $request->hora_início,
            'end_time' => $request->hora_final,
            'description' => $request->descricao,
            'complementary_information' => $request->informacoes_complementares,
            'default_time_class' => $request->tempo_padrao_de_aula,
            'turn' => $request->turno,
        ]);

        return $this->response($request, 'manage.curriculum.edit', 'Matriz curricular atualizada com sucesso!', 'message', 200, 'curriculum', $curriculum->code);
    }

    /**
     * Destroy the curriculum.
     */
    public function destroy(Request $request): mixed
    {
        $curriculum = Curriculum::where('code', $request->curriculum)->first();

        if ($curriculum->subjects()->count() > 0 || $curriculum->classes()->count() > 0) {
            return $this->response($request, 'manage.curriculum.edit', 'Não é possível excluir a matriz curricular pois ela possui disciplinas e/ou turmas vinculadas!', 'error', 422, 'curriculum', $curriculum->code);
        }

        $curriculum->delete();

        return $this->response($request, 'manage.curriculum', 'Matriz curricular excluída com sucesso!');
    }
}
