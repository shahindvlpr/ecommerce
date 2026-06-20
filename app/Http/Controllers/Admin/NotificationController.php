<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Display a listing of notifications.
     */
    public function index()
    {
        $notifications = Notification::where('user_id', Auth::id())
            ->latest()
            ->paginate(15);

        return view('admin.notifications.index', compact('notifications'));
    }

    /**
     * Get unread notifications count (for AJAX).
     */
    public function getUnreadCount()
    {
        try {
            $count = Notification::where('user_id', Auth::id())
                ->where('is_read', false)
                ->count();

            return response()->json(['count' => $count]);
        } catch (\Exception $e) {
            \Log::error('getUnreadCount error: ' . $e->getMessage());
            return response()->json(['count' => 0, 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Get latest notifications (for dropdown).
     */
    public function getLatest()
    {
        try {
            $notifications = Notification::where('user_id', Auth::id())
                ->latest()
                ->limit(5)
                ->get();

            $unreadCount = Notification::where('user_id', Auth::id())
                ->where('is_read', false)
                ->count();

            return response()->json([
                'notifications' => $notifications,
                'unread_count' => $unreadCount,
            ]);
        } catch (\Exception $e) {
            \Log::error('getLatest error: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Mark a notification as read.
     */
    public function markAsRead($id)
    {
        try {
            $notification = Notification::where('user_id', Auth::id())
                ->where('id', $id)
                ->firstOrFail();

            $notification->update([
                'is_read' => true,
                'read_at' => now(),
            ]);

            if (request()->ajax() || request()->wantsJson()) {
                return response()->json(['success' => true]);
            }

            return redirect()->back()->with('success', 'Notification marked as read.');
        } catch (\Exception $e) {
            \Log::error('markAsRead error: ' . $e->getMessage());
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
            }
            return redirect()->back()->with('error', 'Failed to mark as read.');
        }
    }

    /**
     * Mark all notifications as read.
     */
    public function markAllAsRead()
    {
        try {
            Notification::where('user_id', Auth::id())
                ->where('is_read', false)
                ->update(['is_read' => true, 'read_at' => now()]);

            return redirect()->back()->with('success', 'All notifications marked as read.');
        } catch (\Exception $e) {
            \Log::error('markAllAsRead error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to mark all as read.');
        }
    }

    /**
     * Delete a notification.
     */
    public function destroy($id)
    {
        try {
            $notification = Notification::where('user_id', Auth::id())
                ->where('id', $id)
                ->firstOrFail();

            $notification->delete();

            if (request()->ajax() || request()->wantsJson()) {
                return response()->json(['success' => true]);
            }

            return redirect()->back()->with('success', 'Notification deleted.');
        } catch (\Exception $e) {
            \Log::error('destroy error: ' . $e->getMessage());
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
            }
            return redirect()->back()->with('error', 'Failed to delete notification.');
        }
    }

    /**
     * Delete all notifications.
     */
    public function destroyAll()
    {
        try {
            Notification::where('user_id', Auth::id())->delete();
            return redirect()->back()->with('success', 'All notifications deleted.');
        } catch (\Exception $e) {
            \Log::error('destroyAll error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to delete notifications.');
        }
    }
}