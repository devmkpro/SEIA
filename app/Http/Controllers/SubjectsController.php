<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSubjectsRequest;
use App\Models\Curriculum;
use App\Models\Subjects;
use Illuminate\Http\Request;

class SubjectsController extends Controller
{

    /**
     * Display a listing of the school years.
     */
    public function index(Request $request)
    {
        $curriculum = Curriculum::where('code', $request->curriculum)->first();
        $subjects = $curriculum->subjects()->get();
        return response()->json($subjects->map(function ($subject) {
            return [
                'uuid' => encrypt($subject->uuid),
                'name' => $this->formatName($subject->name),
                'ch' => $subject->ch,
                'ch_week' => $subject->ch_week,
                'description' => $subject->description,
                'modality' => $this->formatModality($subject->modality)
            ];
        }));
    }

    /**
     * Form Name 
     */

    public function formatName($name)
    {
        switch ($name) {
            case 'artes':
                return 'Artes';
            case 'biologia':
                return 'Biologia';
            case 'ciencias':
                return 'Ciências';
            case 'educacao-fisica':
                return 'Educação física';
            case 'filosofia':
                return 'Filosofia';
            case 'fisica':
                return 'Física';
            case 'geografia':
                return 'Geografia';
            case 'historia':
                return 'História';
            case 'ingles':
                return 'Inglês';
            case 'literatura':
                return 'Literatura';
            case 'matematica':
                return 'Matemática';
            case 'portugues':
                return 'Português';
            case 'quimica':
                return 'Química';
            case 'sociologia':
                return 'Sociologia';
            case 'ensino-religioso':
                return 'Ensino religioso';
            case 'other':
                return 'Outra';
        }

        return $name;
    }

    /**
     * Form Modality
     */

    public function formatModality($modality)
    {
        switch ($modality) {
            case 'linguagens-e-suas-tecnologias':
                return 'Linguagens e suas tecnologias';
            case 'ciencias-da-natureza-e-suas-tecnologias':
                return 'Ciências da natureza e suas tecnologias';
            case 'ciencias-humanas-e-suas-tecnologias':
                return 'Ciências humanas e suas tecnologias';
            case 'estudos-literarios':
                return 'Estudos literários';
            case 'ensino-religioso':
                return 'Ensino religioso';
            case 'parte-diversificada':
                return 'Parte diversificada';
        }

        return $modality;    
    }
    
    /**
     * Show a subject
     */
    public function show(Request $request)
    {
        $subject = Subjects::where('uuid', decrypt($request->subject))->firstOrFail();
        return response()->json([
            'uuid' => encrypt($subject->uuid), 
            'name' => $subject->name,
            'ch' => $subject->ch,
            'ch_week' => $subject->ch_week,
            'description' => $subject->description,
            'modality' => $subject->modality
        ]);
    }

    /**
     * Render a views subjects
     */
    public function subjects(Request $request, $curriculumCode)
    {
        $curriculum = Curriculum::where('code', $curriculumCode)->where('school_uuid', (new SchoolController)->getHome($request)->uuid)->first();
        if (!$curriculum) {
            return redirect()->route('manage.curriculum');
        }
        return view('secretary.subjects.index', ['curriculum' => $curriculum,
        'title' => 'Disciplinas da Matriz Curricular: ' . $curriculum->code,
        'slot' => 'Aqui você pode gerenciar as disciplinas da matriz curricular',
        ]);
    }

    /**
     * Store a new subject
     */
    public function store(StoreSubjectsRequest $request)
    {
        $curriculum = Curriculum::where('code', $request->curriculum)->where('school_uuid', (new SchoolController)->getHome($request)->uuid)->first();
        $curriculum->subjects()->create($request->validated());
        return redirect()->route('manage.subjects', ['code' => $curriculum->code])->with('message', 'Disciplina criada com sucesso');
    }

    /**
     * Update a subject
     */
    public function update(StoreSubjectsRequest $request)
    {
        $subject = Subjects::where('uuid', decrypt($request->subject))->first();
        $subject->update($request->validated());
        return redirect()->route('manage.subjects', ['code' => $subject->curriculum->code])->with('message', 'Disciplina atualizada com sucesso');
    }
}
