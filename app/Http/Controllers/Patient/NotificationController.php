<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Display a listing of the patient's notifications
     */
    public function index()
    {
        $notifications = Auth::user()
            ->notifications()
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('patient.notifications.index', compact('notifications'));
    }

    /**
     * Mark a notification as read
     */
    public function markAsRead($id)
    {
        try {
            $notification = Auth::user()
                ->notifications()
                ->where('id', $id)
                ->first();

            if (! $notification) {
                return response()->json([
                    'success' => false,
                    'message' => 'Notification not found',
                ], 404);
            }

            $notification->markAsRead();

            return response()->json([
                'success' => true,
                'message' => 'Notification marked as read',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to mark notification as read',
            ], 500);
        }
    }

    /**
     * Mark all notifications as read
     */
    public function markAllAsRead()
    {
        try {
            Auth::user()
                ->unreadNotifications()
                ->update(['read_at' => now()]);

            return response()->json([
                'success' => true,
                'message' => 'All notifications marked as read',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to mark notifications as read',
            ], 500);
        }
    }

    /**
     * Get unread notification count for AJAX requests
     */
    public function getUnreadCount()
    {
        $count = Auth::user()
            ->unreadNotifications()
            ->count();

        return response()->json(['count' => $count]);
    }
}
