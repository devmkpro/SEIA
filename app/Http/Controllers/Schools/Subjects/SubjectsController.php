<?php

namespace App\Http\Controllers\Schools\Subjects;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Schools\SchoolController;
use App\Http\Requests\Subjects\StoreSubjectsRequest;
use Illuminate\Http\Request;
use App\Models\Curriculum\Curriculum;
use App\Models\Subject\Subjects;
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
     * Render a views subjects
     */
    public function subjects(Request $request, Curriculum $curriculum)
    {
        $curriculum = Curriculum::where('code', $curriculum->code)->first();
        $subjects = $curriculum->subjects()->get();
        return view('secretary.subjects.index', ['curriculum' => $curriculum,
            'title' => 'Disciplinas da Matriz Curricular: ' . $curriculum->code,
            'slot' => 'Aqui você pode gerenciar as disciplinas da matriz curricular',
            'subjects' => $subjects->map(function ($subject) {
                return [
                    'uuid' => encrypt($subject->uuid),
                    'name' => $this->formatName($subject->name),
                    'ch' => $subject->ch,
                    'ch_week' => $subject->ch_week,
                    'description' => $subject->description,
                    'modality' => $this->formatModality($subject->modality)
                ];
            })
        ]);
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
     * Store a new subject
     */
    public function store(StoreSubjectsRequest $request)
    {
        $curriculum = Curriculum::where('code', $request->curriculum)->where('school_uuid', (new SchoolController)->getHome($request)->uuid)->first();
        $curriculum->subjects()->create([
            'name' => $request->nome,
            'ch' => $request->carga_horaria,
            'ch_week' => $request->carga_horaria_semanal,
            'description' => $request->descricao,
            'modality' => $request->modalidade,
        ]);
        return $this->response($request, 'manage.subjects', 'Disciplina criada com sucesso', 'message', 201, 'curriculum', $curriculum->code);
    }

    /**
     * Update a subject
     */
    public function update(StoreSubjectsRequest $request)
    {
        $subject = Subjects::where('uuid', decrypt($request->subject))->firstOrFail();
        $subject->update([
            'name' => $request->nome,
            'ch' => $request->carga_horaria,
            'ch_week' => $request->carga_horaria_semanal,
            'description' => $request->descricao,
            'modality' => $request->modalidade,
        ]);
        return $this->response($request, 'manage.subjects', 'Disciplina atualizada com sucesso', 'message', 200, 'curriculum', $subject->curriculum->code);
    }

    /**
     * Destroy a subject
     */
    public function destroy(Request $request)
    {
        $subject = Subjects::where('uuid', decrypt($request->subject))->firstOrFail();
        if ($subject->curriculum->classes()->exists()) {
            return  $this->response($request, 'manage.subjects', 'Disciplina não pode ser excluída pois está sendo usada em uma turma', 'error', 403, 'curriculum', $subject->curriculum->code);
        }
        $subject->delete();
        return $this->response($request, 'manage.subjects', 'Disciplina excluída com sucesso', 'message', 200, 'curriculum', $subject->curriculum->code);
    }

 

    /**
     * Verify if a user is teacher of a subject
     */
    public function verifyTeacherOfSubject($subject, $username): bool
    {
        return $username && $subject && $subject->teachers()->whereHas('user', function ($query) use ($username) {
            $query->where('username', $username);
        })->exists();
    }

}
