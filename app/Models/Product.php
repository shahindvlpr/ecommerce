<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'brand_id',
        'vendor_id',
        'name',
        'slug',
        'short_description',
        'description',
        'price',
        'sale_price',
        'cost_price',
        'stock',
        'sku',
        'barcode',
        'thumbnail',
        'images',
        'attributes',
        'featured',
        'trending',
        'status',
        'views',
        'rating',
        'reviews_count',
        'meta_data',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'cost_price' => 'decimal:2',
        'featured' => 'boolean',
        'trending' => 'boolean',
        'status' => 'boolean',
        'rating' => 'decimal:2',
        'images' => 'array',
        'attributes' => 'array',
        'meta_data' => 'array',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'vendor_id');
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class);
    }

    public function variations(): HasMany
    {
        return $this->hasMany(ProductVariation::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function wishlists(): HasMany
    {
        return $this->hasMany(Wishlist::class);
    }

    public function carts(): HasMany
    {
        return $this->hasMany(Cart::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getDiscountedPriceAttribute(): float
    {
        return $this->sale_price ?? $this->price;
    }

    public function getIsOnSaleAttribute(): bool
    {
        return !is_null($this->sale_price) && $this->sale_price < $this->price;
    }

    public function getDiscountPercentageAttribute(): float
    {
        if ($this->is_on_sale && $this->price > 0) {
            return round((($this->price - $this->sale_price) / $this->price) * 100, 2);
        }
        return 0;
    }

    public function getIsInStockAttribute(): bool
    {
        return $this->stock > 0;
    }

    public function getImageUrlAttribute(): string
    {
        if ($this->thumbnail) {
            return asset('storage/' . $this->thumbnail);
        }
        return asset('images/default-product.png');
    }

    public function getGalleryImagesAttribute(): array
    {
        if ($this->images && is_array($this->images)) {
            return array_map(function ($image) {
                return asset('storage/' . $image);
            }, $this->images);
        }
        return [];
    }

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    public function scopeInStock($query)
    {
        return $query->where('stock', '>', 0);
    }

    public function updateRating()
    {
        $avgRating = $this->reviews()->where('is_approved', true)->avg('rating');
        $this->rating = $avgRating ?? 0;
        $this->reviews_count = $this->reviews()->where('is_approved', true)->count();
        $this->save();
    }
}