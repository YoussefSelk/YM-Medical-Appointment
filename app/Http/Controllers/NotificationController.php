<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function getNotifications()
    {
        // Get authenticated user
        $user = Auth::user();

        // Retrieve all notifications for the user
        $notifications = $user->notifications->where('is_read', false);

        // Return notifications as JSON response
        return response()->json(['notifications' => $notifications], 200);
    }
    public function markAsRead($notificationId)
    {
        // Mark the notification as read
        Notification::where('id', $notificationId)->update(['is_read' => true]);

        // Return a success response
        return response()->json(['message' => 'Notification marked as read successfully'], 200);
    }
}
