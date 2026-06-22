<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VendorEarning extends Model
{
    protected $fillable = [
        'vendor_id', 'order_id', 'product_id', 'amount', 'commission',
        'net_amount', 'type', 'status', 'description', 'metadata', 'paid_at'
    ];

    protected $casts = [
        'metadata' => 'array',
        'paid_at' => 'datetime',
        'amount' => 'decimal:2',
        'commission' => 'decimal:2',
        'net_amount' => 'decimal:2',
    ];

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'vendor_id');
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopePaid($query)
    {
        return $query->where('status', 'paid');
    }

    public function scopeType($query, $type)
    {
        return $query->where('type', $type);
    }
}