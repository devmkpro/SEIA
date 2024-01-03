<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Curriculum;
use App\Http\Requests\StoreCurriculumRequest;
use Illuminate\Support\Facades\Redirect;

class CurriculumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $school_home = decrypt($request->cookie('school_home'));
        $curriculums = Curriculum::where('school_uuid', $school_home)->get()->map(function ($curriculum) {
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
    public function curriculum()
    {
        return view('secretary.curriculum.index', [
            'title' => 'Matrizes Curriculares',
            'slot' => 'Olá, nesta página você pode gerenciar as matrizes curriculares da sua escola! Filtrando por modalidade e série, você pode adicionar, editar e excluir as disciplinas que compõem a matriz curricular.',
        ]);
    }

    /**
     * Format the series.
     */
    private function formatSeries($series)
    {
        $seriesMap = [
            'educ_infa_cc_0_3' => 'Educação Infantil - Creche (0 a 3 anos)',
            'educ_infa_cc_4_5' => 'Educação Infantil - Creche (4 a 5 anos)',
            'educ_ini_1_5' => 'Ensino Fundamental - Anos Iniciais (1º ao 5º ano)',
            'educ_ini_6_9' => 'Ensino Fundamental - Anos Finais (6º ao 9º ano)',
            'educ_med_1' => 'Ensino Médio - 1º ano',
            'educ_med_2' => 'Ensino Médio - 2º ano',
            'educ_med_3' => 'Ensino Médio - 3º ano',
            'other' => 'Outro',
        ];

        return $seriesMap[$series] ?? '';
    }

    /**
     * Format the modality.
     */
    private function formatModality($modality)
    {
        $modalityMap = [
            'bercario' => 'Berçário',
            'creche' => 'Creche',
            'pre_escola' => 'Pré-escola',
            'fundamental' => 'Ensino Fundamental',
            'medio' => 'Ensino Médio',
            'eja' => 'EJA',
            'educacao_especial' => 'Educação Especial',
            'other' => 'Outro',
        ];

        return $modalityMap[$modality] ?? '';
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCurriculumRequest $request)
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
        ]);

        return redirect()->route('manage.curriculum')->with('message', 'Matriz curricular criada com sucesso!');
    }



    /**
     * Show the curriculum.
     */
    public function show(Request $request)
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
        ]);
    }

    /**
     * Update the curriculum.
     */
    public function update(StoreCurriculumRequest $request)
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
        ]);

        return redirect()->route('manage.curriculum')->with('message', 'Matriz curricular atualizada com sucesso!');
    }

    /**
     * Destroy the curriculum.
     */
    public function destroy(Request $request)
    {
        $curriculum = Curriculum::where('code', $request->curriculum)->first();

        if ($curriculum->subjects()->count() > 0) {
            return Redirect::route('manage.curriculum')->withErrors(['error' => 'Não é possível excluir uma matriz curricular que possui disciplinas!']);
        }

        $curriculum->delete();

        return redirect()->route('manage.curriculum')->with('message', 'Matriz curricular excluída com sucesso!');
    }
}
