<?php

namespace App\Helpers;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class ActivityHelper
{
    /**
     * Log an activity.
     */
    public static function log($action, $module = null, $description = null, $data = null)
    {
        if (!Auth::check()) {
            return null;
        }

        return ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => $action,
            'module' => $module,
            'ip_address' => request()->ip(),
            'description' => $description,
            'data' => $data,
            'is_read' => false,
            'created_at' => now()
        ]);
    }

    /**
     * Get recent activities.
     */
    public static function getRecent($limit = 10)
    {
        if (!Auth::check()) {
            return collect();
        }

        return ActivityLog::forUser(Auth::id())
            ->recent($limit)
            ->with('user')
            ->get();
    }

    /**
     * Get unread count.
     */
    public static function getUnreadCount()
    {
        if (!Auth::check()) {
            return 0;
        }

        return ActivityLog::forUser(Auth::id())->unread()->count();
    }

    /**
     * Get activity statistics.
     */
    public static function getStats()
    {
        if (!Auth::check()) {
            return [];
        }

        $userId = Auth::id();

        return [
            'total' => ActivityLog::forUser($userId)->count(),
            'today' => ActivityLog::forUser($userId)->today()->count(),
            'this_week' => ActivityLog::forUser($userId)->thisWeek()->count(),
            'this_month' => ActivityLog::forUser($userId)->thisMonth()->count(),
            'unread' => ActivityLog::forUser($userId)->unread()->count(),
        ];
    }

    /**
     * Clear all activities.
     */
    public static function clearAll()
    {
        if (!Auth::check()) {
            return false;
        }

        return ActivityLog::forUser(Auth::id())->delete();
    }
}