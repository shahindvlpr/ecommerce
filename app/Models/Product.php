<?php

namespace App\Models;

use App\Models\Brand;
use App\Models\Cart;
use App\Models\Category;
use App\Models\OrderItem;
use App\Models\ProductImage;
use App\Models\ProductVariation;
use App\Models\Review;
use App\Models\Wishlist;
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
        'price'         => 'decimal:2',
        'sale_price'    => 'decimal:2',
        'cost_price'    => 'decimal:2',
        'featured'      => 'boolean',
        'trending'      => 'boolean',
        'status'        => 'boolean',
        'rating'        => 'decimal:2',
        'images'        => 'array',   // JSON column → auto array
        'attributes'    => 'array',
        'meta_data'     => 'array',
    ];

    // ==================== RELATIONSHIPS ====================

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

    /**
     * FIXED: Renamed to productImages() to avoid conflict with 'images' JSON column
     */
    public function productImages(): HasMany
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

    // ==================== ACCESSORS ====================

    /**
     * Get the image URL (alias for thumbnail_url)
     * Used in views: {{ $product->image_url }}
     */
    public function getImageUrlAttribute(): string
    {
        return $this->thumbnail_url;
    }

    /**
     * Get the primary display image URL
     * Priority: thumbnail → images JSON array → ProductImage relation → placeholder
     */
    public function getThumbnailUrlAttribute(): string
    {
        // 1. Check thumbnail column
        if (!empty($this->thumbnail)) {
            return $this->buildStorageUrl($this->thumbnail);
        }

        // 2. Check images JSON column
        $imagesArray = $this->images; // already cast to array
        if (!empty($imagesArray) && is_array($imagesArray)) {
            return $this->buildStorageUrl($imagesArray[0]);
        }

        // 3. Check ProductImage relation
        $firstImage = $this->productImages()->first();
        if ($firstImage && !empty($firstImage->image)) {
            return $this->buildStorageUrl($firstImage->image);
        }

        // 4. Placeholder
        return $this->getPlaceholderImage();
    }

    /**
     * Get all gallery image URLs
     */
    public function getGalleryImagesUrlAttribute(): array
    {
        $urls = [];

        // 1. Thumbnail
        if (!empty($this->thumbnail)) {
            $urls[] = $this->buildStorageUrl($this->thumbnail);
        }

        // 2. Images JSON column
        $imagesArray = $this->images;
        if (!empty($imagesArray) && is_array($imagesArray)) {
            foreach ($imagesArray as $img) {
                if (!empty($img)) {
                    $url = $this->buildStorageUrl($img);
                    if (!in_array($url, $urls)) {
                        $urls[] = $url;
                    }
                }
            }
        }

        // 3. ProductImage relation
        foreach ($this->productImages as $image) {
            if (!empty($image->image)) {
                $url = $this->buildStorageUrl($image->image);
                if (!in_array($url, $urls)) {
                    $urls[] = $url;
                }
            }
        }

        // 4. Fallback
        if (empty($urls)) {
            $urls[] = $this->getPlaceholderImage();
        }

        return $urls;
    }

    /**
     * Build full URL from a storage path
     */
    private function buildStorageUrl(string $path): string
    {
        // Already a full URL
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        // Already has storage/ prefix
        if (str_starts_with($path, 'storage/')) {
            return asset($path);
        }

        // Check if path already contains products/
        if (str_starts_with($path, 'products/')) {
            return asset('storage/' . $path);
        }

        return asset('storage/products/' . $path);
    }

    /**
     * Generate a placeholder image based on category
     */
    private function getPlaceholderImage(): string
    {
        $categoryName = $this->category?->name ?? 'Product';
        $productName  = urlencode(substr($this->name, 0, 20));

        $colors = [
            'Electronics'  => '667eea',
            'Fashion'      => 'f093fb',
            'Clothing'     => 'f093fb',
            'Home'         => '4facfe',
            'Books'        => 'f6d365',
            'Beauty'       => 'f5576c',
            'Sports'       => '43e97b',
            'Toys'         => 'fa709a',
            'Food'         => 'f6d365',
        ];

        $color = '8b5cf6';
        foreach ($colors as $key => $hex) {
            if (stripos($categoryName, $key) !== false) {
                $color = $hex;
                break;
            }
        }

        return "https://placehold.co/300x300/{$color}/FFFFFF?text={$productName}";
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

    public function getFormattedPriceAttribute(): string
    {
        return number_format($this->price, 2);
    }

    public function getFormattedSalePriceAttribute(): ?string
    {
        return $this->sale_price ? number_format($this->sale_price, 2) : null;
    }

    public function getStarsAttribute(): string
    {
        $html   = '';
        $rating = round($this->rating ?? 0);
        for ($i = 1; $i <= 5; $i++) {
            $html .= $i <= $rating
                ? '<i class="fas fa-star text-warning"></i>'
                : '<i class="far fa-star text-muted"></i>';
        }
        return $html;
    }

    public function getUrlAttribute(): string
    {
        return route('product.show', $this->slug);
    }

    public function getIsNewAttribute(): bool
    {
        return $this->created_at && $this->created_at->diffInDays(now()) <= 7;
    }

    public function getStatusLabelAttribute(): string
    {
        if (!$this->status)      return 'Inactive';
        if ($this->stock <= 0)   return 'Out of Stock';
        if ($this->stock <= 10)  return 'Low Stock';
        return 'Active';
    }

    public function getStatusBadgeAttribute(): string
    {
        if (!$this->status)      return 'danger';
        if ($this->stock <= 0)   return 'danger';
        if ($this->stock <= 10)  return 'warning';
        return 'success';
    }

    // ==================== SCOPES ====================

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    public function scopeTrending($query)
    {
        return $query->where('trending', true);
    }

    public function scopeInStock($query)
    {
        return $query->where('stock', '>', 0);
    }

    public function scopeLowStock($query, $threshold = 10)
    {
        return $query->where('stock', '<=', $threshold)->where('stock', '>', 0);
    }

    public function scopeOutOfStock($query)
    {
        return $query->where('stock', '<=', 0);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('short_description', 'like', "%{$search}%")
              ->orWhere('description', 'like', "%{$search}%")
              ->orWhere('sku', 'like', "%{$search}%");
        });
    }

    public function scopePriceRange($query, $min, $max)
    {
        return $query->whereBetween('price', [$min, $max]);
    }

    public function scopeOfCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    public function scopeOfBrand($query, $brandId)
    {
        return $query->where('brand_id', $brandId);
    }

    // ==================== HELPER METHODS ====================

    public function updateRating(): void
    {
        $this->rating        = $this->reviews()->where('is_approved', true)->avg('rating') ?? 0;
        $this->reviews_count = $this->reviews()->where('is_approved', true)->count();
        $this->save();
    }

    public function decreaseStock(int $quantity): bool
    {
        if ($this->stock >= $quantity) {
            $this->decrement('stock', $quantity);
            return true;
        }
        return false;
    }

    public function increaseStock(int $quantity): void
    {
        $this->increment('stock', $quantity);
    }

    public function hasStock(int $quantity = 1): bool
    {
        return $this->stock >= $quantity;
    }

    public function getRelatedProducts(int $limit = 4)
    {
        return Product::where('category_id', $this->category_id)
            ->where('id', '!=', $this->id)
            ->active()
            ->inStock()
            ->limit($limit)
            ->get();
    }

    public function incrementViews(): void
    {
        $this->increment('views');
    }
}