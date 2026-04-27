<?php

namespace App\Http\Controllers;

use App\Models\AppNotification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AppNotificationController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        /** @var \App\Models\User $me */
        $me = $request->user();

        $notifications = AppNotification::where('user_id', $me->id)
            ->latest()
            ->limit(30)
            ->get()
            ->map(fn ($n) => [
                'id'        => $n->id,
                'type'      => $n->type,
                'icon'      => $n->icon,
                'title'     => $n->title,
                'body'      => $n->body,
                'link_view' => $n->link_view,
                'read'      => !is_null($n->read_at),
                'ago'       => $n->created_at->diffForHumans(),
            ]);

        $unread = AppNotification::where('user_id', $me->id)->whereNull('read_at')->count();

        return response()->json(['notifications' => $notifications, 'unread' => $unread]);
    }

    public function readAll(Request $request): JsonResponse
    {
        /** @var \App\Models\User $me */
        $me = $request->user();

        AppNotification::where('user_id', $me->id)->whereNull('read_at')->update(['read_at' => now()]);

        return response()->json(['message' => 'Toutes les notifications marquées comme lues.']);
    }

    public function read(Request $request, AppNotification $notification): JsonResponse
    {
        /** @var \App\Models\User $me */
        $me = $request->user();

        if ($notification->user_id === $me->id) {
            $notification->update(['read_at' => now()]);
        }

        return response()->json(['message' => 'Lu.']);
    }
}
