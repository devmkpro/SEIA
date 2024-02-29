<?php

namespace App\Http\Controllers\Schools\Classes;

use App\Http\Controllers\Controller;
use App\Http\Requests\Classes\LinkClassToRoomRequest;
use Illuminate\Http\Request;
use App\Models\Classes\ClassesRooms;

class LinkClassToRoomController extends Controller
{
    public function store(LinkClassToRoomRequest $request) : mixed
    {
        ClassesRooms::create([
            'class_uuid' => $request->class_uuid,
            'room_uuid' => $request->room_uuid,
        ]);
        return $this->response($request, 'gerenciar.salas', 'Sala vinculada com sucesso!', 'message', 201, null, null, false, true);

    }
}