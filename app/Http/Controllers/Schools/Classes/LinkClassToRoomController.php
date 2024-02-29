<?php

namespace App\Http\Controllers\Schools\Classes;

use App\Http\Controllers\Controller;
use App\Http\Requests\Classes\LinkClassToRoomRequest;
use App\Models\Classes\Classes;
use Illuminate\Http\Request;
use App\Models\Classes\ClassesRooms;
use App\Models\Room\Rooms;

class LinkClassToRoomController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(LinkClassToRoomRequest $request) : mixed
    {
        $class = Classes::where('code', $request->class_code)->first();
        $room = Rooms::where('code', $request->room_code)->first();
        
        if ($room->classes()->where('class_uuid', $class->uuid)->first()){
            return $this->response($request, 'gerenciar.salas', 'Sala já vinculada com essa turma!', 'error', 409);
        }

        ClassesRooms::create([
            'class_uuid' => $class->uuid,
            'room_uuid' => $room->uuid,
        ]);
        
        return $this->response($request, 'gerenciar.salas', 'Sala vinculada com sucesso!', 'message', 201);

    }

    
}