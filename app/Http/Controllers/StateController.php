<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\State;

class StateController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        return response()->json(State::all()->map(function ($state) {
            return [
                'name' => $state->name,
                'ibge_code' => $state->ibge_code,
                'schools_count' => $state->schools()->count(),
            ];
        }));
    }

    /**
     * Display the states index.
     */
    public function states(): \Illuminate\Contracts\View\View
    {

        return view('admin.states.index', [
            'title' => 'Gerenciar Estados',
            'slot' => 'Olá, seja bem-vindo(a) ao painel de gerenciamento de estados. Todos os estados são efetivamente brasileiros, e possuem um código IBGE único.',
        ]);
    }

    /**
     * Get cities by state code.
     */
    public function cities(Request $request){

        $request->validate([
            'code' => 'required|numeric',
        ]);

        $state = State::where('ibge_code', $request->code)->first();

        if (!$state) {
            return response()->json(['error' => 'Estado não encontrado.'], 404);
        }

        return response()->json($state->cities()->get()->map(function ($city) {
            return [
                'ibge_code' => $city->ibge_code,
                'name' => $city->name,
            ];
        }));
    }

    /**
     * Show the state by code.
     */
    public function show($code)
    {
        $state = State::where('ibge_code', $code)->first();
        if (!$state) {
            return response()->json(['error' => 'Estado não encontrado.'], 404);
        }

        return response()->json ([
            'name' => $state->name,
            'ibge_code' => $state->ibge_code,
            'schools_count' => $state->schools()->count(),
        ]);
    }
}
