<?php

namespace App\Http\Controllers;

use App\Models\Notifications;

class NotificationController extends Controller
{
    /**
     * Store a new notification.
     */
    public function store($title, $body, $icon, $read, $user_uuid, $type, $request_uuid = null): \Illuminate\Http\JsonResponse
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
    public function markAsRead($uuid): \Illuminate\Http\JsonResponse
    {
        $notification = Notifications::where('uuid', $uuid)->first();
        $notification->read = true;
        $notification->save();

        return response()->json([
            'message' => 'Notificação marcada como lida com sucesso!',
        ], 200);
    }

    /**
     * Mark notification as unread.
     */
    public function markAsUnread($uuid): \Illuminate\Http\JsonResponse
    {
        $notification = Notifications::where('uuid', $uuid)->first();
        $notification->read = false;
        $notification->save();

        return response()->json([
            'message' => 'Notificação marcada como não lida com sucesso!',
        ], 200);
    }

    /**
     * pagina notifications.
     */
    public function notificationsPage()
    {
        return view('profile.notifications', [
            'title' => 'Minhas notificações',
            'slot' => ' ',
        ]);
    }

}
