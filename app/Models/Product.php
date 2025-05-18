<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $primaryKey = 'product_id';

    protected $fillable = [
        'brand_id',
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'stock',
        'image_url',
        'alcohol_content',
        'container_type',
        'volume',
        'is_featured',
        'rating',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'alcohol_content' => 'decimal:2',
        'is_featured' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($product) {
            if (!$product->slug) {
                $product->slug = Str::slug($product->name);
            }
        });
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    public function getAverageRatingAttribute(): float
    {
        return $this->reviews()->avg('rating') ?? 0;
    }

    public function isInStock(): bool
    {
        return $this->stock > 0;
    }

    public function decrementStock(int $quantity = 1): bool
    {
        return $this->decrement('stock', $quantity);
    }

    public function incrementStock(int $quantity = 1): bool
    {
        return $this->increment('stock', $quantity);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
} 