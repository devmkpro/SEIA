<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\Role;
use App\Models\School;
use Illuminate\Http\Request;
use App\Models\SchoolConnectionRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class SchoolConnectionController extends Controller
{
    /**
     * Store a new school connection request.
     */
    public function store($school_uuid, $user_uuid, $role, $class_uuid = null): SchoolConnectionRequest
    {
        $model = SchoolConnectionRequest::create([
            'school_uuid' => $school_uuid,
            'user_uuid' => $user_uuid,
            'role' => $role,
            'class_uuid' => $class_uuid,
        ]);

        return $model;
    }

    /**
     * Accept a school connection request.
     */
    public function acceptOrReject(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'school_request' => 'required|string|exists:school_connection_requests,uuid',
            'notification' => 'required|string|exists:notifications,uuid',
            'status' => 'required|string|in:accepted,rejected',
        ]);

        (new NotificationController())->markAsRead($request->notification);

        $request_connection = SchoolConnectionRequest::where('uuid', $request->school_request)->first();
        $user = Auth::user();
        $user = User::where('uuid', $user->uuid)->first();
        
        if ($user->uuid != $request_connection->user_uuid) {
            return $this->response($request, 'panel', 'Você não tem permissão para aceitar essa solicitação!', 'error', 403);
        }
        $role = Role::where('uuid', $request_connection->role)->first();
        $school = School::where('uuid', $request_connection->school_uuid)->first();
        $user->assignRoleForSchool($role->name, $school->uuid);


        if($request_connection->class_uuid){
            (new TeachersController())->linkinClass($request_connection->class_uuid, $user->uuid);
        }

        $request_connection->status = 'accepted';
        $request_connection->save();

        return $this->response($request, 'panel', 'Solicitação aceita com sucesso!', 'message', 200);
    }
    
}
