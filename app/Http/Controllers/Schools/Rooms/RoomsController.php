<?php

namespace App\Http\Controllers\Schools\Rooms;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Schools\SchoolController;
use App\Http\Requests\Rooms\DestroyRoomRequest;
use App\Http\Requests\Rooms\StoreRoomsRequest;
use App\Http\Requests\Rooms\UpdateRoomsRequest;
use App\Models\Room\Rooms;
use App\Models\School\School;
use Illuminate\Http\Request;

class RoomsController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): \Illuminate\Contracts\View\View
    {
        $school = (new SchoolController)->getHome($request);
        $rooms = Rooms::where('school_uuid', $school->uuid)->get();
        return view('rooms.index', [
            'title' => 'Salas',
            'slot' => 'Olá, nesta página você pode gerenciar as salas da sua escola! Adicione, edite e exclua as salas que compõem a sua escola.',
            'rooms' => $rooms,
        ]);
    }

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
        $room = Rooms::where('code', $request->room_code)->first();
        $room->update([
            'name' => $request->name != null ? $request->name : $room->name,
            'description' => $request->description != null ? $request->description : $room->description,
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
