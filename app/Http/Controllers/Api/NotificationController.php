<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\Request;

class NotificationController extends ApiController
{
    public function index(Request $request)
    {
        $notifications = $request->user()->notifications()->paginate(20);

        return $this->success(['notifications' => $notifications]);
    }

    public function markRead(Request $request)
    {
        $request->user()->unreadNotifications->markAsRead();

        return $this->success([], 'Notificações marcadas como lidas.');
    }

    public function count(Request $request)
    {
        return $this->success(['count' => $request->user()->unreadNotifications->count()]);
    }
}
