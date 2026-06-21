<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductReturn extends Model
{
    use HasFactory;

    protected $table = 'returns';

    protected $fillable = [
        'user_id',
        'order_id',
        'order_item_id',
        'return_number',
        'reason',
        'status',
        'refund_amount',
        'refund_method',
        'bank_details',
        'admin_notes',
        'attachment',
        'requested_at',
        'approved_at',
        'completed_at',
    ];

    protected $casts = [
        'bank_details' => 'array',
        'refund_amount' => 'decimal:2',
        'requested_at' => 'datetime',
        'approved_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    // ✅ Status Constants
    const STATUS_PENDING = 'pending';
    const STATUS_APPROVED = 'approved';
    const STATUS_REJECTED = 'rejected';
    const STATUS_COMPLETED = 'completed';
    const STATUS_CANCELLED = 'cancelled';

    // ✅ Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function orderItem(): BelongsTo
    {
        return $this->belongsTo(OrderItem::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(ReturnItem::class);
    }

    // ✅ Accessors
    public function getStatusLabelAttribute(): string
    {
        $labels = [
            self::STATUS_PENDING => 'Pending Review',
            self::STATUS_APPROVED => 'Approved',
            self::STATUS_REJECTED => 'Rejected',
            self::STATUS_COMPLETED => 'Completed',
            self::STATUS_CANCELLED => 'Cancelled',
        ];
        return $labels[$this->status] ?? $this->status;
    }

    public function getStatusBadgeAttribute(): string
    {
        $classes = [
            self::STATUS_PENDING => 'warning',
            self::STATUS_APPROVED => 'success',
            self::STATUS_REJECTED => 'danger',
            self::STATUS_COMPLETED => 'info',
            self::STATUS_CANCELLED => 'secondary',
        ];
        return $classes[$this->status] ?? 'secondary';
    }

    // ✅ Scopes
    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    public function scopeApproved($query)
    {
        return $query->where('status', self::STATUS_APPROVED);
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', self::STATUS_COMPLETED);
    }

    public function scopeRejected($query)
    {
        return $query->where('status', self::STATUS_REJECTED);
    }

    // ✅ Helper Methods
    public function getReasonLabelAttribute()
    {
        $reasons = [
            'defective' => 'Defective Product',
            'wrong_item' => 'Wrong Item Received',
            'size_issue' => 'Size Issue',
            'damaged' => 'Damaged in Shipping',
            'not_satisfied' => 'Not Satisfied',
            'other' => 'Other Reason',
        ];
        return $reasons[$this->reason] ?? 'Other';
    }

    public function markAsApproved($refundAmount = null)
    {
        $this->update([
            'status' => self::STATUS_APPROVED,
            'refund_amount' => $refundAmount ?? $this->refund_amount,
            'approved_at' => now(),
        ]);
    }

    public function markAsRejected($notes = null)
    {
        $this->update([
            'status' => self::STATUS_REJECTED,
            'admin_notes' => $notes ?? $this->admin_notes,
        ]);
    }

    public function markAsCompleted()
    {
        $this->update([
            'status' => self::STATUS_COMPLETED,
            'completed_at' => now(),
        ]);
    }

    public function markAsCancelled()
    {
        $this->update([
            'status' => self::STATUS_CANCELLED,
        ]);
    }

    public function isPending(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function isApproved(): bool
    {
        return $this->status === self::STATUS_APPROVED;
    }

    public function isCompleted(): bool
    {
        return $this->status === self::STATUS_COMPLETED;
    }

    public function isRejected(): bool
    {
        return $this->status === self::STATUS_REJECTED;
    }
}