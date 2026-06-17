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

    // ==================== ACCESSORS ====================

    /**
     * Get the discounted price
     */
    public function getDiscountedPriceAttribute(): float
    {
        return $this->sale_price ?? $this->price;
    }

    /**
     * Check if product is on sale
     */
    public function getIsOnSaleAttribute(): bool
    {
        return !is_null($this->sale_price) && $this->sale_price < $this->price;
    }

    /**
     * Get discount percentage
     */
    public function getDiscountPercentageAttribute(): float
    {
        if ($this->is_on_sale && $this->price > 0) {
            return round((($this->price - $this->sale_price) / $this->price) * 100, 2);
        }
        return 0;
    }

    /**
     * Check if product is in stock
     */
    public function getIsInStockAttribute(): bool
    {
        return $this->stock > 0;
    }

    /**
     * Get product image URL with fallback (FIXED)
     */
    public function getImageUrlAttribute(): string
    {
        // If thumbnail exists, use it
        if ($this->thumbnail) {
            // Check if it's a full URL or storage path
            if (str_starts_with($this->thumbnail, 'http://') || str_starts_with($this->thumbnail, 'https://')) {
                return $this->thumbnail;
            }
            return asset('storage/' . $this->thumbnail);
        }

        // If images array has first image, use it
        if ($this->images && is_array($this->images) && count($this->images) > 0) {
            return asset('storage/' . $this->images[0]);
        }

        // If product has images relation, use first image
        if ($this->images()->exists()) {
            $firstImage = $this->images()->first();
            if ($firstImage && $firstImage->image) {
                return asset('storage/' . $firstImage->image);
            }
        }

        // Get placeholder image based on category
        return $this->getPlaceholderImage();
    }

    /**
     * Get placeholder image based on category
     */
    private function getPlaceholderImage(): string
    {
        $categoryName = $this->category ? $this->category->name : 'Product';
        $productName = urlencode(substr($this->name, 0, 25));
        
        // Category-based color mapping
        $colors = [
            'Electronics' => '667eea',
            'Fashion' => 'f093fb',
            'Clothing' => 'f093fb',
            'Home & Living' => '4facfe',
            'Home' => '4facfe',
            'Books' => 'f6d365',
            'Beauty' => 'f5576c',
            'Sports' => '4facfe',
            'Toys' => 'f093fb',
            'Food' => 'f6d365',
            'Furniture' => '4facfe',
            'Accessories' => 'f093fb',
            'Shoes' => '4facfe',
        ];
        
        $color = '8b5cf6'; // default purple
        foreach ($colors as $key => $hex) {
            if (stripos($categoryName, $key) !== false) {
                $color = $hex;
                break;
            }
        }
        
        // Return placeholder with product name
        return "https://via.placeholder.com/300x300/{$color}/FFFFFF?text={$productName}";
    }

    /**
     * Get gallery images
     */
    public function getGalleryImagesAttribute(): array
    {
        $images = [];
        
        // Add thumbnail as first image if exists
        if ($this->thumbnail) {
            if (str_starts_with($this->thumbnail, 'http://') || str_starts_with($this->thumbnail, 'https://')) {
                $images[] = $this->thumbnail;
            } else {
                $images[] = asset('storage/' . $this->thumbnail);
            }
        }
        
        // Add images from images array
        if ($this->images && is_array($this->images)) {
            foreach ($this->images as $image) {
                if (str_starts_with($image, 'http://') || str_starts_with($image, 'https://')) {
                    $images[] = $image;
                } else {
                    $images[] = asset('storage/' . $image);
                }
            }
        }
        
        // Add images from images relation
        if ($this->images()->exists()) {
            foreach ($this->images as $image) {
                if ($image->image) {
                    if (str_starts_with($image->image, 'http://') || str_starts_with($image->image, 'https://')) {
                        $images[] = $image->image;
                    } else {
                        $images[] = asset('storage/' . $image->image);
                    }
                }
            }
        }
        
        // If no images, add placeholder
        if (empty($images)) {
            $images[] = $this->image_url;
        }
        
        // Remove duplicates
        return array_unique($images);
    }

    /**
     * Get formatted price
     */
    public function getFormattedPriceAttribute(): string
    {
        return number_format($this->price, 2);
    }

    /**
     * Get formatted sale price
     */
    public function getFormattedSalePriceAttribute(): string
    {
        return $this->sale_price ? number_format($this->sale_price, 2) : null;
    }

    /**
     * Get product rating as stars HTML
     */
    public function getStarsAttribute(): string
    {
        $html = '';
        $rating = round($this->rating);
        for ($i = 1; $i <= 5; $i++) {
            if ($i <= $rating) {
                $html .= '<i class="fas fa-star text-warning"></i>';
            } else {
                $html .= '<i class="fas fa-star text-muted"></i>';
            }
        }
        return $html;
    }

    /**
     * Get product URL
     */
    public function getUrlAttribute(): string
    {
        return route('product.show', $this->slug);
    }

    /**
     * Get formatted price with currency symbol
     */
    public function getPriceFormattedAttribute(): string
    {
        return '$' . number_format($this->price, 2);
    }

    /**
     * Get formatted sale price with currency symbol
     */
    public function getSalePriceFormattedAttribute(): string
    {
        return $this->sale_price ? '$' . number_format($this->sale_price, 2) : null;
    }

    // ==================== SCOPES ====================

    /**
     * Scope a query to only include active products
     */
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    /**
     * Scope a query to only include featured products
     */
    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    /**
     * Scope a query to only include trending products
     */
    public function scopeTrending($query)
    {
        return $query->where('trending', true);
    }

    /**
     * Scope a query to only include in-stock products
     */
    public function scopeInStock($query)
    {
        return $query->where('stock', '>', 0);
    }

    /**
     * Scope a query to only include low stock products
     */
    public function scopeLowStock($query, $threshold = 10)
    {
        return $query->where('stock', '<=', $threshold)->where('stock', '>', 0);
    }

    /**
     * Scope a query to only include out of stock products
     */
    public function scopeOutOfStock($query)
    {
        return $query->where('stock', '<=', 0);
    }

    /**
     * Scope a query to search products
     */
    public function scopeSearch($query, $search)
    {
        return $query->where('name', 'like', "%{$search}%")
            ->orWhere('short_description', 'like', "%{$search}%")
            ->orWhere('description', 'like', "%{$search}%")
            ->orWhere('sku', 'like', "%{$search}%");
    }

    /**
     * Scope a query to filter by price range
     */
    public function scopePriceRange($query, $min, $max)
    {
        return $query->whereBetween('price', [$min, $max]);
    }

    /**
     * Scope a query to filter by category
     */
    public function scopeOfCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    /**
     * Scope a query to filter by brand
     */
    public function scopeOfBrand($query, $brandId)
    {
        return $query->where('brand_id', $brandId);
    }

    /**
     * Scope a query for featured products with rating
     */
    public function scopeFeaturedWithRating($query)
    {
        return $query->featured()->active()->with('category')->orderBy('rating', 'desc');
    }

    /**
     * Scope a query for latest products
     */
    public function scopeLatestProducts($query, $limit = 8)
    {
        return $query->active()->orderBy('created_at', 'desc')->limit($limit);
    }

    /**
     * Scope a query for best selling products
     */
    public function scopeBestSelling($query, $limit = 8)
    {
        return $query->active()->orderBy('views', 'desc')->limit($limit);
    }

    // ==================== HELPER METHODS ====================

    /**
     * Update product rating
     */
    public function updateRating()
    {
        $avgRating = $this->reviews()->where('is_approved', true)->avg('rating');
        $this->rating = $avgRating ?? 0;
        $this->reviews_count = $this->reviews()->where('is_approved', true)->count();
        $this->save();
    }

    /**
     * Decrease stock quantity
     */
    public function decreaseStock($quantity)
    {
        if ($this->stock >= $quantity) {
            $this->stock -= $quantity;
            $this->save();
            return true;
        }
        return false;
    }

    /**
     * Increase stock quantity
     */
    public function increaseStock($quantity)
    {
        $this->stock += $quantity;
        $this->save();
        return true;
    }

    /**
     * Check if product has sufficient stock
     */
    public function hasStock($quantity = 1)
    {
        return $this->stock >= $quantity;
    }

    /**
     * Get related products
     */
    public function getRelatedProducts($limit = 4)
    {
        return Product::where('category_id', $this->category_id)
            ->where('id', '!=', $this->id)
            ->where('status', true)
            ->inStock()
            ->limit($limit)
            ->get();
    }

    /**
     * Increment view count
     */
    public function incrementViews()
    {
        $this->views = ($this->views ?? 0) + 1;
        $this->save();
    }

    /**
     * Check if product is new (created within last 7 days)
     */
    public function getIsNewAttribute(): bool
    {
        return $this->created_at && $this->created_at->diffInDays(now()) <= 7;
    }

    /**
     * Get product rating percentage
     */
    public function getRatingPercentageAttribute(): float
    {
        return ($this->rating / 5) * 100;
    }

    /**
     * Get product rating count by star
     */
    public function getRatingDistributionAttribute(): array
    {
        $distribution = [
            1 => 0,
            2 => 0,
            3 => 0,
            4 => 0,
            5 => 0,
        ];
        
        $reviews = $this->reviews()->where('is_approved', true)->get();
        foreach ($reviews as $review) {
            if (isset($distribution[$review->rating])) {
                $distribution[$review->rating]++;
            }
        }
        
        return $distribution;
    }

    /**
     * Get product main image (alias for image_url)
     */
    public function getMainImageAttribute(): string
    {
        return $this->image_url;
    }

    /**
     * Get product thumbnail (alias for image_url)
     */
    public function getThumbnailUrlAttribute(): string
    {
        return $this->image_url;
    }

    /**
     * Get product status label
     */
    public function getStatusLabelAttribute(): string
    {
        if (!$this->status) {
            return 'Inactive';
        }
        if ($this->stock <= 0) {
            return 'Out of Stock';
        }
        if ($this->stock <= 10) {
            return 'Low Stock';
        }
        return 'Active';
    }

    /**
     * Get product status badge color
     */
    public function getStatusBadgeAttribute(): string
    {
        if (!$this->status) {
            return 'danger';
        }
        if ($this->stock <= 0) {
            return 'danger';
        }
        if ($this->stock <= 10) {
            return 'warning';
        }
        return 'success';
    }
}