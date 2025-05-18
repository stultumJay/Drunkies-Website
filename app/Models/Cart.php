<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $primaryKey = 'cart_id';

    protected $fillable = [
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(CartItem::class, 'cart_id');
    }

    public function getTotalAttribute()
    {
        return $this->items->sum(function ($item) {
            return $item->quantity * $item->product->price;
        });
    }

    public function getItemCountAttribute()
    {
        return $this->items->sum('quantity');
    }

    public function addItem($product, $quantity = 1)
    {
        $existingItem = $this->items()->where('product_id', $product->product_id)->first();

        if ($existingItem) {
            $existingItem->increment('quantity', $quantity);
        } else {
            $this->items()->create([
                'product_id' => $product->product_id,
                'quantity' => $quantity,
            ]);
        }
    }

    public function removeItem($product)
    {
        $this->items()->where('product_id', $product->product_id)->delete();
    }

    public function updateItemQuantity($product, $quantity)
    {
        if ($quantity <= 0) {
            $this->removeItem($product);
        } else {
            $this->items()->where('product_id', $product->product_id)->update(['quantity' => $quantity]);
        }
    }

    public function clear()
    {
        $this->items()->delete();
    }
} 