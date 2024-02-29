<?php

namespace App\Http\Controllers\Schools\Rooms;

use App\Http\Controllers\Controller;
use App\Http\Requests\Rooms\DestroyRoomRequest;
use App\Http\Requests\Rooms\StoreRoomsRequest;
use App\Http\Requests\Rooms\UpdateRoomsRequest;
use App\Models\Classes\ClassesRooms;
use App\Models\Room\Rooms;
use App\Models\School\School;


class RoomsController extends Controller
{
    /**
     *  git config --global user.email "you@example.com"
  git config --global user.name "Your Name"
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
        $Room = Rooms::where('code', $request->room_code)->first();
        $Room->update([
            'name' => $request->name != null ? $request->name : $Room->name,
            'description' => $request->description != null ? $request->description : $Room->description,
        ]);

        return $this->response($request, 'manage.rooms', 'Sala atualizada com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DestroyRoomRequest $request): mixed
    {
        $room = Rooms::where('code', $request->room_code)->first();
        
        if ($room->classes->count() > 0){
            return $this->response($request, 'manage.rooms', 'Não é possível deletar uma sala que está sendo utilizada.', 'error', 400);
        }

        $room->delete();
        return $this->response($request, 'manage.rooms', 'Sala deletada com sucesso.');
    }
}
