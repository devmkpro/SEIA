<?php

namespace App\Http\Controllers\User\Notification;

use App\Http\Controllers\Controller;
use App\Http\Requests\Notifications\MarkNotificationRequest;
use App\Models\Notification\Notifications;

class NotificationController extends Controller
{

    /**
     * Render notifications page.
     */
    public function index()
    {
        return view('profile.notifications.index', [
            'title' => 'Minhas notificações',
            'slot' => 'Aqui você pode ver todas as suas notificações.',
            'notifications' => Notifications::where('user_uuid', auth()->user()->uuid)->orderBy('created_at', 'desc')->get(),
        ]);
    }
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
    public function markAsRead(MarkNotificationRequest $request)
    {
        $notification = Notifications::where('code', $request->notification)->first();
        $notification->read = true;
        $notification->save();

        return $this->response($request, 'panel', 'Notificação marcada como lida com sucesso!', 'message', 200, null, null, false, true);

    }


}
