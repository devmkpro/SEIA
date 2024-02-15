<?php

namespace App\Http\Controllers\Schools;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Schools\Teachers\TeachersController;
use App\Http\Requests\ChangeConnectionRequest;
use App\Models\Notification\Notifications;
use Illuminate\Support\Facades\Auth;
use App\Models\School\School;
use App\Models\User;
use App\Models\School\SchoolConnectionRequest;
use App\Models\Role;



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
    public function acceptOrReject(ChangeConnectionRequest $request): mixed
    {
        $notication = Notifications::where('code', $request->notification)->first();
        
        if (!$notication->read){
            $notication->read = true;
            $notication->save();
        }

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

        $request_connection->status = $request->status;
        $request_connection->save();

        if ($request->status == 'accepted') {
            return $this->response($request, 'panel', 'Solicitação aceita com sucesso!', 'success', 200);
        } else {
            return $this->response($request, 'panel', 'Solicitação rejeitada com sucesso!', 'success', 200);
        }
    }
    
}
