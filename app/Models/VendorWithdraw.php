<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VendorWithdraw extends Model
{
    protected $fillable = [
        'vendor_id', 'amount', 'fee', 'net_amount', 'payment_method',
        'status', 'account_details', 'notes', 'rejection_reason',
        'processed_at', 'completed_at'
    ];

    protected $casts = [
        'processed_at' => 'datetime',
        'completed_at' => 'datetime',
        'amount' => 'decimal:2',
        'fee' => 'decimal:2',
        'net_amount' => 'decimal:2',
    ];

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'vendor_id');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeProcessing($query)
    {
        return $query->where('status', 'processing');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }
}