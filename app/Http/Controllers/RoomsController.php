<?php

namespace App\Http\Controllers;

use App\Http\Requests\DestroyRoomRequest;
use App\Http\Requests\StoreRoomsRequest;
use App\Http\Requests\UpdateRoomsRequest;
use App\Models\Rooms;
use App\Models\School;


class RoomsController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoomsRequest $request): mixed
    {
        $school = School::where('code', $request->school_code)->first();
        Rooms::create([
            'name' => $request->name,
            'description' => $request->description,
            'school_uuid' => $school->uuid,
        ]);
        return $this->response($request, 'manage.rooms', 'Sala criada com sucesso.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoomsRequest $request): mixed
    {
        Rooms::where('code', $request->room_code)->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return $this->response($request, 'manage.rooms', 'Sala atualizada com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DestroyRoomRequest $request): mixed
    {
        $room = Rooms::where('code', $request->room_code)->first();

        if ($room->classes) {
            return $this->response($request, 'manage.rooms', 'Não é possível deletar uma sala que está sendo utilizada.', 'error', 400);
        }

        $room->delete();
        return $this->response($request, 'manage.rooms', 'Sala deletada com sucesso.');
    }
}
