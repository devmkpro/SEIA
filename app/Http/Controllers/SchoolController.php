<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\City;
use App\Models\State;
use App\Models\School;
use App\Http\Requests\StoreSchoolRequest;
use Illuminate\Support\Facades\Redirect;

class SchoolController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(): mixed
    {
        return response()->json(School::all()->map(function ($school) {
            return [
                'uuid' => encrypt($school->uuid),
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
    public function create()
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

        return redirect()->route('manage.schools.create')->with('message', 'Escola cadastrada com sucesso!');
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
    public function setHome(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'school' => 'required|string',
        ]);

        $user = $request->user();
        $school = School::where('uuid', decrypt($request->school))->first();

        if (!$school) {
            return Redirect::route('panel')->withErrors(['school' => 'Escola não encontrada!']);
        }

        if (!$user->hasRole('admin') && (!$user->schools() || !$user->schools()->where('school_uuid', decrypt($request->school))->exists())) {
            return Redirect::route('panel')->withErrors(['school' => 'Você não tem permissão para acessar essa escola!']);
        }

        (new CookieController)->setCookie('school_home', encrypt($school->uuid), 1440);

        return Redirect::route('panel')->with('message', 'Escola selecionada com sucesso!');
    }

    /**
     * Delete School Home Cookie and redirect to home.
     */
    public function deleteHome(): \Illuminate\Http\RedirectResponse
    {
        (new CookieController)->deleteCookie('school_home');

        return Redirect::route('panel')->with('info', 'Escolha uma escola para acessar o sistema!');
    }




}
