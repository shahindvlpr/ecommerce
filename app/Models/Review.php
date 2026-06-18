<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'rating',
        'title',
        'comment',
        'images',
        'is_approved',
        'is_verified',
        'helpful_count',
        'reported_count',
    ];

    protected $casts = [
        'rating' => 'integer',
        'is_approved' => 'boolean',
        'is_verified' => 'boolean',
        'images' => 'array',
        'helpful_count' => 'integer',
        'reported_count' => 'integer',
    ];

    // ==================== RELATIONSHIPS ====================

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    // ==================== ACCESSORS ====================

    public function getStarsAttribute(): string
    {
        $html = '';
        for ($i = 1; $i <= 5; $i++) {
            $html .= $i <= $this->rating 
                ? '<i class="fas fa-star text-warning"></i>' 
                : '<i class="fas fa-star text-muted"></i>';
        }
        return $html;
    }

    public function getRatingStarsAttribute(): array
    {
        return [
            'full' => floor($this->rating),
            'half' => ($this->rating - floor($this->rating)) >= 0.5,
            'empty' => 5 - ceil($this->rating),
        ];
    }

    public function getFormattedDateAttribute(): string
    {
        return $this->created_at->format('M d, Y');
    }

    public function getTimeAgoAttribute(): string
    {
        return $this->created_at->diffForHumans();
    }

    public function getImagesUrlAttribute(): array
    {
        if (empty($this->images)) {
            return [];
        }

        $urls = [];
        foreach ($this->images as $image) {
            if (filter_var($image, FILTER_VALIDATE_URL)) {
                $urls[] = $image;
            } else {
                $urls[] = asset('storage/reviews/' . $image);
            }
        }
        return $urls;
    }

    public function getStatusBadgeAttribute(): string
    {
        if (!$this->is_approved) {
            return '<span class="badge bg-warning">Pending</span>';
        }
        return '<span class="badge bg-success">Approved</span>';
    }

    // ==================== SCOPES ====================

    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    public function scopePending($query)
    {
        return $query->where('is_approved', false);
    }

    public function scopeVerified($query)
    {
        return $query->where('is_verified', true);
    }

    public function scopeForProduct($query, $productId)
    {
        return $query->where('product_id', $productId);
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    // ==================== HELPER METHODS ====================

    public function isHelpful(): void
    {
        $this->increment('helpful_count');
    }

    public function report(): void
    {
        $this->increment('reported_count');
    }

    public function approve(): void
    {
        $this->update(['is_approved' => true]);
    }

    public function reject(): void
    {
        $this->update(['is_approved' => false]);
    }
}