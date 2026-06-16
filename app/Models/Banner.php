<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'subtitle',
        'image',
        'mobile_image',
        'url',
        'button_text',
        'button_url',
        'position',
        'order',
        'type',
        'status',
        'start_date',
        'end_date',
        'meta_data',
    ];

    protected $casts = [
        'status' => 'boolean',
        'start_date' => 'date',
        'end_date' => 'date',
        'meta_data' => 'array',
    ];

    public function getIsActiveAttribute(): bool
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

        return true;
    }

    public function getImageUrlAttribute(): string
    {
        return asset('storage/' . $this->image);
    }

    public function getMobileImageUrlAttribute(): string
    {
        if ($this->mobile_image) {
            return asset('storage/' . $this->mobile_image);
        }
        return $this->image_url;
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