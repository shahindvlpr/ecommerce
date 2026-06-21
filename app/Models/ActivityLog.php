<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityLog extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'activity_logs';
    
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'action',
        'module',
        'ip_address',
        'description',
        'data',
        'is_read',
        'created_at'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'data' => 'array',
        'is_read' => 'boolean',
        'created_at' => 'datetime'
    ];

    /**
     * Get the user that owns the activity log.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope a query to only include recent activities.
     */
    public function scopeRecent($query, $limit = 10)
    {
        return $query->orderBy('created_at', 'desc')->limit($limit);
    }

    /**
     * Scope a query to only include activities for a specific user.
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope a query to only include activities for a specific module.
     */
    public function scopeModule($query, $module)
    {
        return $query->where('module', $module);
    }

    /**
     * Scope a query to only include activities for a specific action.
     */
    public function scopeAction($query, $action)
    {
        return $query->where('action', $action);
    }

    /**
     * Scope a query to only include unread activities.
     */
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    /**
     * Scope a query to only include today's activities.
     */
    public function scopeToday($query)
    {
        return $query->whereDate('created_at', today());
    }

    /**
     * Scope a query to only include this week's activities.
     */
    public function scopeThisWeek($query)
    {
        return $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
    }

    /**
     * Scope a query to only include this month's activities.
     */
    public function scopeThisMonth($query)
    {
        return $query->whereMonth('created_at', now()->month)
                     ->whereYear('created_at', now()->year);
    }

    /**
     * Get the action icon.
     */
    public function getIconAttribute(): string
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

        return $icons[$this->action] ?? 'fa-circle';
    }

    /**
     * Get the action color.
     */
    public function getColorAttribute(): string
    {
        $colors = [
            'login' => 'success',
            'logout' => 'danger',
            'create' => 'primary',
            'update' => 'warning',
            'delete' => 'danger',
            'view' => 'info',
            'status' => 'info',
            'featured' => 'warning',
            'export' => 'success',
            'import' => 'info',
            'order' => 'primary',
            'payment' => 'pink',
            'profile' => 'primary',
            'settings' => 'secondary',
            'backup' => 'teal',
            'restore' => 'pink',
        ];

        return $colors[$this->action] ?? 'secondary';
    }

    /**
     * Get the action badge class.
     */
    public function getBadgeClassAttribute(): string
    {
        return "bg-{$this->color} bg-opacity-10 text-{$this->color}";
    }

    /**
     * Mark activity as read.
     */
    public function markAsRead(): bool
    {
        return $this->update(['is_read' => true]);
    }

    /**
     * Get formatted time.
     */
    public function getFormattedTimeAttribute(): string
    {
        return $this->created_at->format('M d, Y H:i:s');
    }

    /**
     * Get time ago.
     */
    public function getTimeAgoAttribute(): string
    {
        return $this->created_at->diffForHumans();
    }

    /**
     * Get user name.
     */
    public function getUserNameAttribute(): string
    {
        return $this->user->name ?? 'Unknown User';
    }

    /**
     * Get user avatar.
     */
    public function getUserAvatarAttribute(): ?string
    {
        return $this->user->avatar ?? null;
    }
}