<?php

namespace App\Http\Controllers;

use App\Http\Requests\SchoolHomeChangeRequest;
use Illuminate\Http\Request;
use App\Models\City;
use App\Models\State;
use App\Models\School;
use App\Http\Requests\StoreSchoolRequest;

class SchoolController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(): \Illuminate\Http\JsonResponse 
    {
        return response()->json(School::all()->map(function ($school) {
            return [
                'code' => $school->code,
                'name' => $school->name,
                'email' => $school->email,
                'city' => $school->city->name,
                'state' => $school->state->name,
                'district' => $school->district,
            ];
        }));
    }

    /**
     * Display the schools create.
     */
    public function create(): \Illuminate\Contracts\View\View
    {
        return view('admin.schools.create',[
            'title' => 'Cadastrar Escola',
            'slot' => 'Olá, seja bem-vindo(a) ao painel de gerenciamento de escolas. Aqui você pode cadastrar uma nova escola no sistema.',
            'cities' => City::all(),
            'states' => State::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSchoolRequest $request): \Illuminate\Http\RedirectResponse
    {
        $validated = $request->validated();

        $city = City::where('ibge_code', $validated['city_code'])->first();
        $state = State::where('ibge_code', $validated['state_code'])->first();

        School::create($validated + [
            'city_uuid' => $city->uuid,
            'state_uuid' => $state->uuid,
        ]);

        return $this->response($request, 'manage.schools', 'Escola cadastrada com sucesso!');
    }

    /**
     * Render the all schools edit.
     */
    public function schools(): \Illuminate\Contracts\View\View
    {
        return view('admin.schools.index',[
            'title' => 'Gerenciar Escolas',
            'slot' => 'Olá, seja bem-vindo(a) ao painel de gerenciamento de escolas. Aqui você pode gerenciar as escolas cadastradas no sistema.',
            'schools' => School::all(),
        ]);
    }

    /**
     * Set School Home Cookie and redirect to home.
     */
    public function setHome(SchoolHomeChangeRequest $request)
    {
        return $this->response($request, 'panel', 'Escola definida com sucesso!')->withCookie(cookie()->forever('school_home', encrypt($request->school)));
    }

    /**
     * Delete School Home Cookie and redirect to home.
     */
    public function deleteHome(Request $request)
    {
        return $this->response($request, 'panel', 'Escola removida com sucesso!', 'message')->withCookie(cookie()->forget('school_home'));
    }

    /**
     * Get School Home Cookie.
     */
    public function getHome(Request $request): ?School
    {
        $school_home = $request->cookie('school_home');
        if (!$school_home) {
            return null;
        }

        return School::where('code', decrypt($school_home))->first();
    }

}
