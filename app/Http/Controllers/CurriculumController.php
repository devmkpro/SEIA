<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Curriculum;
use App\Http\Requests\StoreCurriculumRequest;
use App\Models\School;

class CurriculumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $school_home = $request->cookie('school_home'); 
        $school_home = decrypt($school_home);
        return response()->json(Curriculum::where('school_uuid', $school_home)->get()->map(function ($curriculum) {
            return [
                'uuid' => encrypt($curriculum->uuid),
                'series' => $this->formatSeries($curriculum->series),
                'modality' => $this->formatModality($curriculum->modality),
                'weekly_hours' => $curriculum->weekly_hours,
                'start_time' => $curriculum->start_time,
                'end_time' => $curriculum->end_time,
                'total_hours' => $curriculum->total_hours,

            ];
        }));
    }

    /**
     * Render the curriculum view.
     */
    public function curriculum()
    {
        return view('secretary.curriculum.index', [
            'title' => 'Matriz curricular',
            'slot' => 'Olá, nesta página você pode gerenciar a matriz curricular da sua escola! Filtrando por modalidade e série, você pode adicionar, editar e excluir as disciplinas que compõem a matriz curricular.',
        ]);
    }

    /**
     * Format the series.
     */
    public function formatSeries($series)
    {
        switch ($series) {
            case 'educ_infa_cc_0_3':
                return 'Educação Infantil - Creche (0 a 3 anos)';
            case 'educ_infa_cc_4_5':
                return 'Educação Infantil - Creche (4 a 5 anos)';
            case 'educ_ini_1_5':
                return 'Ensino Fundamental - Anos Iniciais (1º ao 5º ano)';
            case 'educ_ini_6_9':
                return 'Ensino Fundamental - Anos Finais (6º ao 9º ano)';
            case 'educ_med_1':
                return 'Ensino Médio - 1º ano';
            case 'educ_med_2':
                return 'Ensino Médio - 2º ano';
            case 'educ_med_3':
                return 'Ensino Médio - 3º ano';
            case 'other':
                return 'Outro';
        }
    }

    /**
     * Format the modality.
     */

    public function formatModality($modality)
    {
        switch ($modality) {
            case 'bercario':
                return 'Berçário';
            case 'creche':
                return 'Creche';
            case 'pre_escola':
                return 'Pré-escola';
            case 'fundamental':
                return 'Ensino Fundamental';
            case 'medio':
                return 'Ensino Médio';
            case 'eja':
                return 'EJA';
            case 'educacao_especial':
                return 'Educação Especial';
            case 'other':
                return 'Outro';
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCurriculumRequest $request)
    {
        $school_home = (new SchoolController)->getHome($request);
        Curriculum::create([
            'school_uuid' => $school_home->uuid,
            'series' => $request->series,
            'modality' => $request->modality,
            'weekly_hours' => $request->weekly_hours,
            'total_hours' => $request->total_hours,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'description' => $request->description,
            'complementary_information' => $request->complementary_information,
        ]);

        return redirect()->route('manage.curriculum')->with('message', 'Matriz curricular criada com sucesso!');
    }

    /**
     * Show the curriculum.
     */
    public function show(Request $request, $uuidEncoded)
    {
        $uuid = decrypt($uuidEncoded);
        $curriculum = Curriculum::where('uuid', $uuid)->firstOrFail();
        $school_home = (new SchoolController)->getHome($request);
        
        if ($curriculum->school_uuid != $school_home->uuid) {
            return redirect()->route('manage.curriculum')->withErros(['error' => 'Você não tem permissão para acessar essa página!']);
        }

        return response()->json([
            'uuid' => encrypt($curriculum->uuid),
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
        $uuid = decrypt($request->curriculum);
        $curriculum = Curriculum::where('uuid', $uuid)->firstOrFail();
        $school_home = (new SchoolController)->getHome($request);

        if ($curriculum->school_uuid != $school_home->uuid) {
            return redirect()->route('manage.curriculum')->withErros(['error' => 'Você não tem permissão para acessar essa página!']);
        }

        $curriculum->update([
            'series' => $request->series,
            'modality' => $request->modality,
            'weekly_hours' => $request->weekly_hours,
            'total_hours' => $request->total_hours,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'description' => $request->description,
            'complementary_information' => $request->complementary_information,
        ]);

        return redirect()->route('manage.curriculum')->with('message', 'Matriz curricular atualizada com sucesso!');
    }
    
}
