<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Attribute extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
        'type',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'status' => 'boolean',
    ];

    // ==================== RELATIONSHIPS ====================

    /**
     * Get the values for this attribute.
     */
    public function values(): HasMany
    {
        return $this->hasMany(AttributeValue::class);
    }

    /**
     * Get the products that have this attribute.
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_attributes')
            ->withPivot('value')
            ->withTimestamps();
    }

    // ==================== ACCESSORS ====================

    /**
     * Get the type label.
     */
    public function getTypeLabelAttribute(): string
    {
        $labels = [
            'text' => 'Text',
            'select' => 'Select (Dropdown)',
            'color' => 'Color',
            'size' => 'Size',
            'checkbox' => 'Checkbox',
            'radio' => 'Radio',
        ];

        return $labels[$this->type] ?? ucfirst($this->type);
    }

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
     * Get the values count with label.
     */
    public function getValuesCountLabelAttribute(): string
    {
        $count = $this->values()->count();
        return $count . ' ' . ($count == 1 ? 'value' : 'values');
    }

    // ==================== SCOPES ====================

    /**
     * Scope a query to only include active attributes.
     */
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    /**
     * Scope a query to only include inactive attributes.
     */
    public function scopeInactive($query)
    {
        return $query->where('status', false);
    }

    /**
     * Scope a query to only include attributes of a specific type.
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope a query to search by name or slug.
     */
    public function scopeSearch($query, $search)
    {
        return $query->where('name', 'like', "%{$search}%")
            ->orWhere('slug', 'like', "%{$search}%");
    }

    // ==================== HELPER METHODS ====================

    /**
     * Check if attribute has values.
     */
    public function hasValues(): bool
    {
        return $this->values()->exists();
    }

    /**
     * Get values as array for dropdown.
     */
    public function getValuesForDropdown(): array
    {
        return $this->values()
            ->where('status', true)
            ->pluck('value', 'id')
            ->toArray();
    }

    /**
     * Get values as array with color codes.
     */
    public function getValuesWithColors(): array
    {
        return $this->values()
            ->where('status', true)
            ->select('id', 'value', 'color_code')
            ->get()
            ->toArray();
    }

    /**
     * Get formatted values for product page.
     */
    public function getFormattedValues(): array
    {
        $values = [];
        foreach ($this->values()->where('status', true)->get() as $value) {
            $item = [
                'id' => $value->id,
                'value' => $value->value,
                'slug' => $value->slug,
            ];

            if ($this->type === 'color' && $value->color_code) {
                $item['color_code'] = $value->color_code;
            }

            $values[] = $item;
        }
        return $values;
    }
}