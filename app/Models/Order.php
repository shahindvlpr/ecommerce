<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_number',
        'name',
    'address',
    'city',
    'state',
    'postal_code',
    'country',
    'payment_method',
        'subtotal',
        'discount',
        'tax',
        'shipping_cost',
        'total',
        'status',
        'payment_status',
        'shipping_status',
        'shipping_address',
        'billing_address',
        'phone',
        'email',
        'tracking_number',
        'notes',
        'meta_data',
        'name',           
        'address',        
        'city',        
        'state',          
        'postal_code',    
        'country',        
        'payment_method', 
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'discount' => 'decimal:2',
        'tax' => 'decimal:2',
        'shipping_cost' => 'decimal:2',
        'total' => 'decimal:2',
        'meta_data' => 'array',
    ];

    const STATUS_PENDING = 'pending';
    const STATUS_PROCESSING = 'processing';
    const STATUS_SHIPPED = 'shipped';
    const STATUS_DELIVERED = 'delivered';
    const STATUS_CANCELLED = 'cancelled';
    const STATUS_REFUNDED = 'refunded';

    const PAYMENT_PENDING = 'pending';
    const PAYMENT_PAID = 'paid';
    const PAYMENT_FAILED = 'failed';
    const PAYMENT_REFUNDED = 'refunded';

    const SHIPPING_PENDING = 'pending';
    const SHIPPING_PROCESSING = 'processing';
    const SHIPPING_SHIPPED = 'shipped';
    const SHIPPING_DELIVERED = 'delivered';

    // ==================== RELATIONSHIPS ====================

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payment(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    // ==================== ACCESSORS ====================

    public function getStatusLabelAttribute(): string
    {
        $labels = [
            self::STATUS_PENDING => 'Pending',
            self::STATUS_PROCESSING => 'Processing',
            self::STATUS_SHIPPED => 'Shipped',
            self::STATUS_DELIVERED => 'Delivered',
            self::STATUS_CANCELLED => 'Cancelled',
            self::STATUS_REFUNDED => 'Refunded',
        ];
        return $labels[$this->status] ?? ucfirst($this->status);
    }

    public function getPaymentStatusLabelAttribute(): string
    {
        $labels = [
            self::PAYMENT_PENDING => 'Pending',
            self::PAYMENT_PAID => 'Paid',
            self::PAYMENT_FAILED => 'Failed',
            self::PAYMENT_REFUNDED => 'Refunded',
        ];
        return $labels[$this->payment_status] ?? ucfirst($this->payment_status);
    }

    public function getShippingStatusLabelAttribute(): string
    {
        $labels = [
            self::SHIPPING_PENDING => 'Pending',
            self::SHIPPING_PROCESSING => 'Processing',
            self::SHIPPING_SHIPPED => 'Shipped',
            self::SHIPPING_DELIVERED => 'Delivered',
        ];
        return $labels[$this->shipping_status] ?? ucfirst($this->shipping_status);
    }

    public function getStatusBadgeAttribute(): string
    {
        $badges = [
            self::STATUS_PENDING => 'warning',
            self::STATUS_PROCESSING => 'info',
            self::STATUS_SHIPPED => 'primary',
            self::STATUS_DELIVERED => 'success',
            self::STATUS_CANCELLED => 'danger',
            self::STATUS_REFUNDED => 'secondary',
        ];
        return $badges[$this->status] ?? 'secondary';
    }

    public function getPaymentStatusBadgeAttribute(): string
    {
        $badges = [
            self::PAYMENT_PENDING => 'warning',
            self::PAYMENT_PAID => 'success',
            self::PAYMENT_FAILED => 'danger',
            self::PAYMENT_REFUNDED => 'secondary',
        ];
        return $badges[$this->payment_status] ?? 'secondary';
    }

    public function getFormattedSubtotalAttribute(): string
    {
        return number_format($this->subtotal, 2);
    }

    public function getFormattedTotalAttribute(): string
    {
        return number_format($this->total, 2);
    }

    public function getFormattedTaxAttribute(): string
    {
        return number_format($this->tax, 2);
    }

    public function getFormattedShippingAttribute(): string
    {
        return number_format($this->shipping_cost, 2);
    }

    // ==================== SCOPES ====================

    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    public function scopeProcessing($query)
    {
        return $query->where('status', self::STATUS_PROCESSING);
    }

    public function scopeShipped($query)
    {
        return $query->where('status', self::STATUS_SHIPPED);
    }

    public function scopeDelivered($query)
    {
        return $query->where('status', self::STATUS_DELIVERED);
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', self::STATUS_CANCELLED);
    }

    public function scopeRefunded($query)
    {
        return $query->where('status', self::STATUS_REFUNDED);
    }

    public function scopePaid($query)
    {
        return $query->where('payment_status', self::PAYMENT_PAID);
    }

    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    // ==================== HELPER METHODS ====================

    public function isPending(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function isProcessing(): bool
    {
        return $this->status === self::STATUS_PROCESSING;
    }

    public function isShipped(): bool
    {
        return $this->status === self::STATUS_SHIPPED;
    }

    public function isDelivered(): bool
    {
        return $this->status === self::STATUS_DELIVERED;
    }

    public function isCancelled(): bool
    {
        return $this->status === self::STATUS_CANCELLED;
    }

    public function isRefunded(): bool
    {
        return $this->status === self::STATUS_REFUNDED;
    }

    public function isPaid(): bool
    {
        return $this->payment_status === self::PAYMENT_PAID;
    }

    public function canBeCancelled(): bool
    {
        return in_array($this->status, [self::STATUS_PENDING, self::STATUS_PROCESSING]);
    }

    public function canBeUpdated(): bool
    {
        return !in_array($this->status, [self::STATUS_DELIVERED, self::STATUS_CANCELLED, self::STATUS_REFUNDED]);
    }

    public function getShippingFullAddress(): string
    {
        $parts = [
            $this->shipping_address,
            $this->city,
            $this->state,
            $this->postal_code,
            $this->country,
        ];
        return implode(', ', array_filter($parts));
    }
}