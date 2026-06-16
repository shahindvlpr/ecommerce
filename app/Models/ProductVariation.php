<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductVariation extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'attribute_name',
        'attribute_value',
        'sku',
        'price_adjustment',
        'sale_price',
        'stock',
        'image',
    ];

    protected $casts = [
        'price_adjustment' => 'decimal:2',
        'sale_price' => 'decimal:2',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function getFinalPriceAttribute(): float
    {
        $basePrice = $this->product->price;
        $adjustedPrice = $basePrice + $this->price_adjustment;
        
        if ($this->sale_price) {
            return $this->sale_price;
        }
        
        return $adjustedPrice;
    }

    public function getIsInStockAttribute(): bool
    {
        return $this->stock > 0;
    }
}