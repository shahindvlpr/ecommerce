<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'session_id',
        'product_id',
        'product_variation_id',
        'quantity',
        'price',
        'attributes',
        'expires_at', 
    ];

    protected $casts = [
        'attributes' => 'array',
        'price' => 'decimal:2',
        'expires_at' => 'datetime', // datetime cast
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function variation(): BelongsTo
    {
        return $this->belongsTo(ProductVariation::class, 'product_variation_id');
    }

    public function getSubtotalAttribute(): float
    {
        return $this->quantity * $this->price;
    }

    /**
     * Check if cart item is expired
     */
    public function isExpired(): bool
    {
        if (!$this->expires_at) {
            return false;
        }
        return $this->expires_at->isPast();
    }

    /**
     * Get remaining time before expiration
     */
    public function getRemainingTimeAttribute(): ?string
    {
        if (!$this->expires_at) {
            return null;
        }
        
        $diff = now()->diff($this->expires_at);
        
        if ($diff->invert) {
            return 'Expired';
        }
        
        if ($diff->days > 0) {
            return $diff->days . 'd ' . $diff->h . 'h';
        }
        
        if ($diff->h > 0) {
            return $diff->h . 'h ' . $diff->i . 'm';
        }
        
        return $diff->i . 'm ' . $diff->s . 's';
    }

    /**
     * Scope for active (non-expired) cart items
     */
    public function scopeActive($query)
    {
        return $query->where(function ($q) {
            $q->whereNull('expires_at')
              ->orWhere('expires_at', '>', now());
        });
    }

    /**
     * Scope for expired cart items
     */
    public function scopeExpired($query)
    {
        return $query->whereNotNull('expires_at')
            ->where('expires_at', '<=', now());
    }
}