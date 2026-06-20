<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'title',
        'message',
        'link',
        'icon',
        'color',
        'is_read',
        'read_at',
        'data',
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'read_at' => 'datetime',
        'data' => 'array',
    ];

    // ==================== RELATIONSHIPS ====================

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // ==================== SCOPES ====================

    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    public function scopeRead($query)
    {
        return $query->where('is_read', true);
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    // ==================== ✅ ACCESSORS (যোগ করুন) ====================

    public function getTimeAgoAttribute(): string
    {
        return $this->created_at->diffForHumans();
    }

    public function getFormattedDateAttribute(): string
    {
        return $this->created_at->format('M d, Y h:i A');
    }

    public function getStatusBadgeAttribute(): string
    {
        if ($this->is_read) {
            return '<span class="badge bg-secondary">Read</span>';
        }
        return '<span class="badge bg-danger">Unread</span>';
    }

    public function getIconClassAttribute(): string
    {
        $icons = [
            'order' => 'fas fa-shopping-bag',
            'payment' => 'fas fa-credit-card',
            'review' => 'fas fa-star',
            'product' => 'fas fa-box',
            'user' => 'fas fa-user',
            'vendor' => 'fas fa-store',
            'system' => 'fas fa-cog',
            'warning' => 'fas fa-exclamation-triangle',
            'success' => 'fas fa-check-circle',
            'info' => 'fas fa-info-circle',
        ];

        return $icons[$this->type] ?? 'fas fa-bell';
    }

    // ==================== HELPER METHODS ====================

    public function markAsRead(): void
    {
        if (!$this->is_read) {
            $this->update([
                'is_read' => true,
                'read_at' => now(),
            ]);
        }
    }

    public function markAsUnread(): void
    {
        if ($this->is_read) {
            $this->update([
                'is_read' => false,
                'read_at' => null,
            ]);
        }
    }

    // ==================== FACTORY METHODS ====================

    public static function createNotification($userId, $type, $title, $message, $link = null, $data = [])
    {
        $colors = [
            'order' => '#667eea',
            'payment' => '#10b981',
            'review' => '#f59e0b',
            'product' => '#3b82f6',
            'user' => '#8b5cf6',
            'vendor' => '#ec4899',
            'system' => '#6b7280',
            'warning' => '#ef4444',
            'success' => '#10b981',
            'info' => '#3b82f6',
        ];

        return self::create([
            'user_id' => $userId,
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'link' => $link,
            'icon' => null,
            'color' => $colors[$type] ?? '#6b7280',
            'is_read' => false,
            'data' => $data,
        ]);
    }
}