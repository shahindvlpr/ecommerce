<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'phone',
        'email',
        'address',
        'city',
        'state',
        'postal_code',
        'country',
        'is_default',
        'type',
    ];

    protected $casts = [
        'is_default' => 'boolean',
    ];

    const TYPE_SHIPPING = 'shipping';
    const TYPE_BILLING = 'billing';
    const TYPE_BOTH = 'both';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getFullAddressAttribute(): string
    {
        $parts = [];
        if ($this->address) $parts[] = $this->address;
        if ($this->city) $parts[] = $this->city;
        if ($this->state) $parts[] = $this->state;
        if ($this->postal_code) $parts[] = $this->postal_code;
        if ($this->country) $parts[] = $this->country;
        return implode(', ', $parts);
    }

    public function scopeDefault($query)
    {
        return $query->where('is_default', true);
    }

    public function scopeShipping($query)
    {
        return $query->whereIn('type', [self::TYPE_SHIPPING, self::TYPE_BOTH]);
    }

    public function scopeBilling($query)
    {
        return $query->whereIn('type', [self::TYPE_BILLING, self::TYPE_BOTH]);
    }
}