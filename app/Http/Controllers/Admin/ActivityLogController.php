<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActivityLogController extends Controller
{
    /**
     * Display a listing of the activities.
     */
    public function index(Request $request)
    {
        // ডামি ডেটা তৈরি করুন (যদি ডেটা না থাকে)
        $this->createDummyDataIfEmpty();

        $query = ActivityLog::where('user_id', Auth::id())->with('user');

        // Filter by module
        if ($request->filled('module') && $request->module != 'all') {
            $query->where('module', $request->module);
        }

        // Filter by action
        if ($request->filled('action') && $request->action != 'all') {
            $query->where('action', $request->action);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Filter by status
        if ($request->filled('status') && $request->status != 'all') {
            $query->where('is_read', $request->status == 'read');
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('description', 'LIKE', "%{$search}%")
                  ->orWhere('action', 'LIKE', "%{$search}%")
                  ->orWhere('module', 'LIKE', "%{$search}%")
                  ->orWhereHas('user', function($user) use ($search) {
                      $user->where('name', 'LIKE', "%{$search}%")
                           ->orWhere('email', 'LIKE', "%{$search}%");
                  });
            });
        }

        $activities = $query->orderBy('created_at', 'desc')->paginate(20);

        // Get distinct modules and actions for filters
        $modules = ActivityLog::where('user_id', Auth::id())
            ->whereNotNull('module')
            ->distinct()
            ->pluck('module');

        $actions = ActivityLog::where('user_id', Auth::id())
            ->distinct()
            ->pluck('action');

        return view('admin.activity.index', compact('activities', 'modules', 'actions'));
    }

    /**
     * Display the specified activity.
     */
    public function show($id)
    {
        $activity = ActivityLog::where('user_id', Auth::id())
            ->with('user')
            ->findOrFail($id);

        // Mark as read if unread
        if (!$activity->is_read) {
            $activity->update(['is_read' => true]);
        }

        return view('admin.activity.show', compact('activity'));
    }

    /**
     * Get recent activities for navbar dropdown.
     */
    public function recent()
    {
        $activities = ActivityLog::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->with('user')
            ->get()
            ->map(function ($log) {
                return [
                    'id' => $log->id,
                    'action' => $log->action,
                    'module' => $log->module,
                    'description' => $log->description,
                    'ip_address' => $log->ip_address,
                    'time' => $log->created_at->diffForHumans(),
                    'time_full' => $log->created_at->format('M d, Y H:i:s'),
                    'icon' => $this->getActionIcon($log->action),
                    'color' => $this->getActionColor($log->action),
                    'user_name' => $log->user->name ?? 'Unknown',
                    'user_avatar' => $log->user->avatar ?? null,
                    'is_read' => $log->is_read,
                ];
            });

        $unreadCount = ActivityLog::where('user_id', Auth::id())
            ->where('is_read', false)
            ->count();

        return response()->json([
            'activities' => $activities,
            'unread_count' => $unreadCount,
            'total' => ActivityLog::where('user_id', Auth::id())->count()
        ]);
    }

    /**
     * Mark single activity as read.
     */
    public function markAsRead($id)
    {
        try {
            $activity = ActivityLog::where('user_id', Auth::id())
                ->findOrFail($id);
            
            $activity->update(['is_read' => true]);

            return response()->json([
                'success' => true,
                'message' => 'Activity marked as read'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to mark activity as read'
            ], 404);
        }
    }

    /**
     * Mark all activities as read.
     */
    public function markAllAsRead()
    {
        try {
            ActivityLog::where('user_id', Auth::id())
                ->where('is_read', false)
                ->update(['is_read' => true]);

            return response()->json([
                'success' => true,
                'message' => 'All activities marked as read'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to mark activities as read'
            ], 500);
        }
    }

    /**
     * Delete single activity.
     */
    public function destroy($id)
    {
        try {
            $activity = ActivityLog::where('user_id', Auth::id())
                ->findOrFail($id);
            
            $activity->delete();

            return response()->json([
                'success' => true,
                'message' => 'Activity deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete activity'
            ], 404);
        }
    }

    /**
     * Clear all activities for the current user.
     */
    public function clearAll()
    {
        try {
            ActivityLog::where('user_id', Auth::id())->delete();

            return response()->json([
                'success' => true,
                'message' => 'All activities cleared successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to clear activities'
            ], 500);
        }
    }

    /**
     * Export activities as CSV.
     */
    public function export(Request $request)
    {
        $query = ActivityLog::where('user_id', Auth::id())->with('user');

        // Apply filters
        if ($request->filled('module') && $request->module != 'all') {
            $query->where('module', $request->module);
        }

        if ($request->filled('action') && $request->action != 'all') {
            $query->where('action', $request->action);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $activities = $query->orderBy('created_at', 'desc')->get();

        if ($activities->isEmpty()) {
            return back()->with('error', 'No activities to export.');
        }

        $filename = 'activity-log-' . now()->format('Y-m-d-H-i-s') . '.csv';
        $handle = fopen('php://temp', 'w+');

        // Headers
        fputcsv($handle, [
            'ID', 'User', 'Action', 'Module', 'Description', 
            'IP Address', 'Status', 'Date', 'Time'
        ]);

        // Data
        foreach ($activities as $activity) {
            fputcsv($handle, [
                $activity->id,
                $activity->user->name ?? 'Unknown',
                $activity->action,
                $activity->module ?? 'N/A',
                $activity->description ?? 'N/A',
                $activity->ip_address ?? 'N/A',
                $activity->is_read ? 'Read' : 'Unread',
                $activity->created_at->format('Y-m-d'),
                $activity->created_at->format('H:i:s')
            ]);
        }

        rewind($handle);
        $csv = stream_get_contents($handle);
        fclose($handle);

        return response($csv)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"')
            ->header('Cache-Control', 'must-revalidate, post-check=0, pre-check=0')
            ->header('Pragma', 'public')
            ->header('Expires', '0');
    }

    /**
     * Get activity statistics.
     */
    public function stats()
    {
        $userId = Auth::id();

        $stats = [
            'total' => ActivityLog::where('user_id', $userId)->count(),
            'today' => ActivityLog::where('user_id', $userId)->whereDate('created_at', today())->count(),
            'this_week' => ActivityLog::where('user_id', $userId)->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
            'this_month' => ActivityLog::where('user_id', $userId)->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->count(),
            'unread' => ActivityLog::where('user_id', $userId)->where('is_read', false)->count(),
        ];

        // Get top actions
        $topActions = ActivityLog::where('user_id', $userId)
            ->select('action', \Illuminate\Support\Facades\DB::raw('count(*) as count'))
            ->groupBy('action')
            ->orderBy('count', 'desc')
            ->limit(5)
            ->get();

        // Get top modules
        $topModules = ActivityLog::where('user_id', $userId)
            ->select('module', \Illuminate\Support\Facades\DB::raw('count(*) as count'))
            ->whereNotNull('module')
            ->groupBy('module')
            ->orderBy('count', 'desc')
            ->limit(5)
            ->get();

        return response()->json([
            'stats' => $stats,
            'top_actions' => $topActions,
            'top_modules' => $topModules
        ]);
    }

    /**
     * Create dummy data if no activities exist.
     */
    private function createDummyDataIfEmpty()
    {
        $count = ActivityLog::where('user_id', Auth::id())->count();
        
        if ($count == 0) {
            $actions = ['login', 'view', 'create', 'update', 'delete', 'export', 'import'];
            $modules = ['auth', 'dashboard', 'products', 'categories', 'orders', 'users', 'settings'];
            $descriptions = [
                'User logged in successfully',
                'Viewed dashboard',
                'Created new product',
                'Updated product information',
                'Deleted product',
                'Exported data',
                'Imported data',
                'Updated settings',
                'Created new category',
                'Updated user profile'
            ];
            
            for ($i = 0; $i < 15; $i++) {
                ActivityLog::create([
                    'user_id' => Auth::id(),
                    'action' => $actions[array_rand($actions)],
                    'module' => $modules[array_rand($modules)],
                    'ip_address' => request()->ip(),
                    'description' => $descriptions[array_rand($descriptions)] . ' ' . ($i + 1),
                    'is_read' => $i % 2 == 0,
                    'created_at' => now()->subMinutes(rand(1, 120))
                ]);
            }
        }
    }

    /**
     * Get action icon.
     */
    private function getActionIcon($action)
    {
        $icons = [
            'login' => 'fa-sign-in-alt',
            'logout' => 'fa-sign-out-alt',
            'create' => 'fa-plus-circle',
            'update' => 'fa-edit',
            'delete' => 'fa-trash',
            'view' => 'fa-eye',
            'status' => 'fa-toggle-on',
            'featured' => 'fa-star',
            'export' => 'fa-file-export',
            'import' => 'fa-file-import',
            'order' => 'fa-shopping-cart',
            'payment' => 'fa-credit-card',
            'profile' => 'fa-user-edit',
            'settings' => 'fa-cog',
            'backup' => 'fa-database',
            'restore' => 'fa-undo-alt',
        ];

        return $icons[$action] ?? 'fa-circle';
    }

    /**
     * Get action color.
     */
    private function getActionColor($action)
    {
        $colors = [
            'login' => 'emerald',
            'logout' => 'rose',
            'create' => 'indigo',
            'update' => 'amber',
            'delete' => 'rose',
            'view' => 'sky',
            'status' => 'sky',
            'featured' => 'amber',
            'export' => 'emerald',
            'import' => 'purple',
            'order' => 'indigo',
            'payment' => 'pink',
            'profile' => 'indigo',
            'settings' => 'gray',
            'backup' => 'teal',
            'restore' => 'pink',
        ];

        return $colors[$action] ?? 'gray';
    }
}