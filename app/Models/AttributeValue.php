<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class AttributeValue extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'attribute_id',
        'value',
        'slug',
        'color_code',
        'image',
        'position',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'status' => 'boolean',
        'position' => 'integer',
    ];

    // ==================== RELATIONSHIPS ====================

    /**
     * Get the attribute that owns this value.
     */
    public function attribute(): BelongsTo
    {
        return $this->belongsTo(Attribute::class);
    }

    /**
     * Get the products that have this attribute value.
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_attributes', 'attribute_value_id', 'product_id')
            ->withTimestamps();
    }

    // ==================== ACCESSORS ====================

    /**
     * Get the status badge.
     */
    public function getStatusBadgeAttribute(): string
    {
        if ($this->status) {
            return '<span class="badge bg-success"><i class="fas fa-check-circle"></i> Active</span>';
        }
        return '<span class="badge bg-secondary"><i class="fas fa-times-circle"></i> Inactive</span>';
    }

    /**
     * Get the status label.
     */
    public function getStatusLabelAttribute(): string
    {
        return $this->status ? 'Active' : 'Inactive';
    }

    /**
     * Get the color preview HTML.
     */
    public function getColorPreviewAttribute(): string
    {
        if ($this->color_code) {
            return '<span style="display: inline-block; width: 25px; height: 25px; border-radius: 50%; background: ' . $this->color_code . '; border: 1px solid #ddd;"></span>';
        }
        return '<span class="text-muted">N/A</span>';
    }

    /**
     * Get the image URL.
     */
    public function getImageUrlAttribute(): string
    {
        if ($this->image) {
            return asset('storage/' . $this->image);
        }
        return asset('images/default-attribute.png');
    }

    // ==================== SCOPES ====================

    /**
     * Scope a query to only include active values.
     */
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    /**
     * Scope a query to only include inactive values.
     */
    public function scopeInactive($query)
    {
        return $query->where('status', false);
    }

    /**
     * Scope a query to order by position.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('position', 'asc');
    }

    /**
     * Scope a query to search by value.
     */
    public function scopeSearch($query, $search)
    {
        return $query->where('value', 'like', "%{$search}%")
            ->orWhere('slug', 'like', "%{$search}%");
    }

    // ==================== HELPER METHODS ====================

    /**
     * Generate a unique slug for the value.
     */
    public static function generateSlug($value, $attributeId)
    {
        $slug = Str::slug($value);
        $count = self::where('attribute_id', $attributeId)
            ->where('slug', 'like', $slug . '%')
            ->count();

        return $count > 0 ? $slug . '-' . ($count + 1) : $slug;
    }
}