<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'user_id',
        'invoice_number',
        'subtotal',
        'tax',
        'shipping',
        'discount',
        'total',
        'status',
        'due_date',
        'paid_date',
        'notes',
        'billing_address',
        'shipping_address',
        'items',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'tax' => 'decimal:2',
        'shipping' => 'decimal:2',
        'discount' => 'decimal:2',
        'total' => 'decimal:2',
        'due_date' => 'date',
        'paid_date' => 'date',
        'items' => 'array',
    ];

    const STATUS_PAID = 'paid';
    const STATUS_UNPAID = 'unpaid';
    const STATUS_PARTIAL = 'partial';
    const STATUS_REFUNDED = 'refunded';
    const STATUS_CANCELLED = 'cancelled';

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getStatusLabelAttribute(): string
    {
        $labels = [
            self::STATUS_PAID => 'Paid',
            self::STATUS_UNPAID => 'Unpaid',
            self::STATUS_PARTIAL => 'Partial',
            self::STATUS_REFUNDED => 'Refunded',
            self::STATUS_CANCELLED => 'Cancelled',
        ];
        return $labels[$this->status] ?? $this->status;
    }

    public function getStatusBadgeAttribute(): string
    {
        $classes = [
            self::STATUS_PAID => 'success',
            self::STATUS_UNPAID => 'danger',
            self::STATUS_PARTIAL => 'warning',
            self::STATUS_REFUNDED => 'info',
            self::STATUS_CANCELLED => 'secondary',
        ];
        return $classes[$this->status] ?? 'secondary';
    }

    public function scopeUnpaid($query)
    {
        return $query->where('status', self::STATUS_UNPAID);
    }

    public function scopePaid($query)
    {
        return $query->where('status', self::STATUS_PAID);
    }

    public function scopeOverdue($query)
    {
        return $query->where('status', self::STATUS_UNPAID)
            ->where('due_date', '<', now());
    }

    public function markAsPaid()
    {
        $this->update([
            'status' => self::STATUS_PAID,
            'paid_date' => now(),
        ]);
    }

    public function markAsRefunded()
    {
        $this->update([
            'status' => self::STATUS_REFUNDED,
        ]);
    }

    public function markAsCancelled()
    {
        $this->update([
            'status' => self::STATUS_CANCELLED,
        ]);
    }

    public function isOverdue(): bool
    {
        return $this->status === self::STATUS_UNPAID && 
               $this->due_date && 
               $this->due_date->isPast();
    }
}