<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function getNotifications()
    {
        // Get authenticated user
        $user = Auth::user();

        if (!$user) {
            return response()->json(['notifications' => []], 200);
        }

        // Retrieve only recent unread notifications to keep payload light
        $notifications = Notification::query()
            ->where('user_id', $user->id)
            ->where('is_read', false)
            ->latest()
            ->limit(12)
            ->get(['id', 'title', 'message', 'created_at']);

        // Return notifications as JSON response
        return response()->json(['notifications' => $notifications], 200);
    }
    public function markAsRead($notification)
    {
        // Mark as read only if it belongs to the authenticated user
        $updated = Notification::where('id', (int) $notification)
            ->where('user_id', Auth::id())
            ->update(['is_read' => true]);

        if (!$updated) {
            return response()->json(['message' => 'Notification not found'], 404);
        }

        // Return a success response
        return response()->json(['message' => 'Notification marked as read successfully'], 200);
    }
}
