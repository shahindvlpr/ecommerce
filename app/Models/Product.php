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

    /**
     * Get the first image URL safely
     */
    public function getFirstImageAttribute(): string
    {
        // 1. Check thumbnail
        if ($this->thumbnail && !empty($this->thumbnail)) {
            return $this->thumbnail;
        }

        // 2. Check images field (JSON array)
        if ($this->images) {
            // If it's already an array
            if (is_array($this->images) && !empty($this->images)) {
                return $this->images[0];
            }
            // If it's a string (JSON), decode it
            if (is_string($this->images)) {
                $decoded = json_decode($this->images, true);
                if (is_array($decoded) && !empty($decoded)) {
                    return $decoded[0];
                }
            }
        }

        // 3. Check images relation
        $firstImage = $this->images()->first();
        if ($firstImage && $firstImage->image) {
            return $firstImage->image;
        }

        // 4. Default fallback
        return 'default-product.jpg';
    }

    /**
     * Get image URL with full path
     */
    public function getImageUrlAttribute(): string
    {
        $image = $this->first_image;
        
        // Check if it's a full URL
        if (str_starts_with($image, 'http://') || str_starts_with($image, 'https://')) {
            return $image;
        }
        
        // Check if it's a placeholder
        if ($image === 'default-product.jpg' || str_contains($image, 'via.placeholder.com')) {
            return $image;
        }

        // Return storage path
        return asset('storage/' . $image);
    }

    private function getPlaceholderImage(): string
    {
        $categoryName = $this->category ? $this->category->name : 'Product';
        $productName = urlencode(substr($this->name, 0, 25));
        
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
        ];
        
        $color = '8b5cf6';
        foreach ($colors as $key => $hex) {
            if (stripos($categoryName, $key) !== false) {
                $color = $hex;
                break;
            }
        }
        
        return "https://via.placeholder.com/300x300/{$color}/FFFFFF?text={$productName}";
    }

    /**
     * Get gallery images safely
     */
    public function getGalleryImagesAttribute(): array
    {
        $images = [];
        
        // 1. Add thumbnail
        if ($this->thumbnail && !empty($this->thumbnail)) {
            $images[] = $this->thumbnail;
        }
        
        // 2. Get images from JSON field
        if ($this->images) {
            // If it's a string (JSON)
            if (is_string($this->images)) {
                $decoded = json_decode($this->images, true);
                if (is_array($decoded)) {
                    foreach ($decoded as $img) {
                        if (!empty($img) && !in_array($img, $images)) {
                            $images[] = $img;
                        }
                    }
                }
            }
            // If it's an array
            elseif (is_array($this->images)) {
                foreach ($this->images as $img) {
                    if (!empty($img) && !in_array($img, $images)) {
                        $images[] = $img;
                    }
                }
            }
        }
        
        // 3. Get images from relation
        if ($this->images()->exists()) {
            foreach ($this->images as $image) {
                if ($image && $image->image && !empty($image->image) && !in_array($image->image, $images)) {
                    $images[] = $image->image;
                }
            }
        }
        
        // 4. If no images, add placeholder
        if (empty($images)) {
            $images[] = $this->getPlaceholderImage();
        }
        
        return $images;
    }

    /**
     * Get formatted gallery images with full URLs
     */
    public function getGalleryImagesUrlAttribute(): array
    {
        $urls = [];
        foreach ($this->gallery_images as $image) {
            if (str_starts_with($image, 'http://') || str_starts_with($image, 'https://')) {
                $urls[] = $image;
            } elseif ($image === 'default-product.jpg' || str_contains($image, 'via.placeholder.com')) {
                $urls[] = $image;
            } else {
                $urls[] = asset('storage/' . $image);
            }
        }
        return $urls;
    }

    public function getFormattedPriceAttribute(): string
    {
        return number_format($this->price, 2);
    }

    public function getFormattedSalePriceAttribute(): string
    {
        return $this->sale_price ? number_format($this->sale_price, 2) : null;
    }

    public function getStarsAttribute(): string
    {
        $html = '';
        $rating = round($this->rating ?? 0);
        for ($i = 1; $i <= 5; $i++) {
            if ($i <= $rating) {
                $html .= '<i class="fas fa-star text-warning"></i>';
            } else {
                $html .= '<i class="fas fa-star text-muted"></i>';
            }
        }
        return $html;
    }

    public function getUrlAttribute(): string
    {
        return route('product.show', $this->slug);
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
        return $query->where('name', 'like', "%{$search}%")
            ->orWhere('short_description', 'like', "%{$search}%")
            ->orWhere('description', 'like', "%{$search}%")
            ->orWhere('sku', 'like', "%{$search}%");
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

    public function updateRating()
    {
        $avgRating = $this->reviews()->where('is_approved', true)->avg('rating');
        $this->rating = $avgRating ?? 0;
        $this->reviews_count = $this->reviews()->where('is_approved', true)->count();
        $this->save();
    }

    public function decreaseStock($quantity)
    {
        if ($this->stock >= $quantity) {
            $this->stock -= $quantity;
            $this->save();
            return true;
        }
        return false;
    }

    public function increaseStock($quantity)
    {
        $this->stock += $quantity;
        $this->save();
        return true;
    }

    public function hasStock($quantity = 1)
    {
        return $this->stock >= $quantity;
    }

    public function getRelatedProducts($limit = 4)
    {
        return Product::where('category_id', $this->category_id)
            ->where('id', '!=', $this->id)
            ->where('status', true)
            ->inStock()
            ->limit($limit)
            ->get();
    }

    public function incrementViews()
    {
        $this->views = ($this->views ?? 0) + 1;
        $this->save();
    }

    public function getIsNewAttribute(): bool
    {
        return $this->created_at && $this->created_at->diffInDays(now()) <= 7;
    }

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