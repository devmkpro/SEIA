<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRoomsRequest;
use App\Models\Rooms;
use App\Models\School;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class RoomsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoomsRequest $request):mixed
    {
        $school = School::where('code', $request->school_code)->first();
        Rooms::create([
            'code' => $request->code,
            'name' => $request->name,
            'description' => $request->description,
            'school_uuid' => $school->uuid,
        ]);
        return $this->response($request, 'manage.rooms', 'Sala criada com sucesso.');
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreRoomsRequest $request):mixed
    {
        //

        // Rooms::where($request->)->update([
        //     'code' => $request->code,
        //     'name' => $request->name,
        //     'description' => $request->description,
        // ]);

        // return $this->response($request, 'manage.rooms', 'Sala atualizada com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StoreRoomsRequest $request,Rooms $room):mixed
    {
            if($room->classes){
                return $this->response($request, 'manage.rooms', 'Não é possível deletar uma sala que está sendo utilizada.', 'error', 400);
            }
           $room->delete();
           return $this->response($request, 'manage.rooms', 'Sala deletada com sucesso.');
    }
}
