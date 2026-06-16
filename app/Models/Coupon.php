<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'type',
        'value',
        'min_order_amount',
        'max_discount',
        'usage_limit',
        'used_count',
        'per_user_limit',
        'start_date',
        'end_date',
        'status',
    ];

    protected $casts = [
        'value' => 'decimal:2',
        'min_order_amount' => 'decimal:2',
        'max_discount' => 'decimal:2',
        'status' => 'boolean',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    const TYPE_FIXED = 'fixed';
    const TYPE_PERCENTAGE = 'percentage';

    public function getIsValidAttribute(): bool
    {
        if (!$this->status) {
            return false;
        }

        if ($this->start_date && $this->start_date->isFuture()) {
            return false;
        }

        if ($this->end_date && $this->end_date->isPast()) {
            return false;
        }

        if ($this->usage_limit && $this->used_count >= $this->usage_limit) {
            return false;
        }

        return true;
    }

    public function calculateDiscount($subtotal): float
    {
        if (!$this->is_valid) {
            return 0;
        }

        if ($this->min_order_amount && $subtotal < $this->min_order_amount) {
            return 0;
        }

        if ($this->type === self::TYPE_PERCENTAGE) {
            $discount = ($subtotal * $this->value) / 100;
            if ($this->max_discount) {
                return min($discount, $this->max_discount);
            }
            return $discount;
        }

        return min($this->value, $subtotal);
    }

    public function scopeActive($query)
    {
        return $query->where('status', true)
            ->where(function ($q) {
                $q->whereNull('start_date')
                    ->orWhere('start_date', '<=', now());
            })
            ->where(function ($q) {
                $q->whereNull('end_date')
                    ->orWhere('end_date', '>=', now());
            });
    }
}