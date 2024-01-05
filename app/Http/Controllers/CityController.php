<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\City;

class CityController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index($code=NULL)
    {
        return response()->json(City::all()->map(function ($city) {
            return [
                'name' => $city->name,
                'ibge_code' => $city->ibge_code,
                'schools_count' => $city->schools->count(),
            ];
        }));
    }

    /**
     * Display the cities edit.
     */
    public function cities(): \Illuminate\Contracts\View\View
    {
        return view('admin.cities.edit', [
            'title' => 'Gerenciar Cidades',
            'slot' => 'Olá, seja bem-vindo(a) ao painel de gerenciamento de cidades. Aqui você pode visualizar as cidades cadastradas. Todas são efetivamente brasileiras, e possuem um código IBGE único.',
        ]);
    }

    /**
     * Show the city by code.
     */
    public function show($code)
    {
        $city = City::where('ibge_code', $code)->first();
        if (!$city) {
            return response()->json(['error' => 'Cidade não encontrada.'], 404);
        }

        return response()->json ([
            'name' => $city->name,
            'ibge_code' => $city->ibge_code,
            'schools_count' => $city->schools->count(),
        ]);
    }

}
