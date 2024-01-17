<?php

namespace App\Http\Controllers;

use App\Models\Notifications;

class NotificationController extends Controller
{
    /**
     * Store a new notification.
     */
    public function store($title, $body, $icon, $read, $user_uuid, $type, $request_uuid = null)
    {
        $notification = new Notifications();
        $notification->title = $title;
        $notification->body = $body;
        $notification->icon = $icon;
        $notification->read = $read;
        $notification->user_uuid = $user_uuid;
        $notification->type = $type;
        $notification->request_uuid = $request_uuid;
        $notification->save();

        return response()->json([
            'message' => 'Notificação criada com sucesso!',
        ], 201);
    }

    /**
     * Mark notification as read.
     */
    public function markAsRead($uuid){
        $notification = Notifications::where('uuid', $uuid)->first();
        $notification->read = true;
        $notification->save();

        return response()->json([
            'message' => 'Notificação marcada como lida com sucesso!',
        ], 200);
    }
}
