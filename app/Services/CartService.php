<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CartService
{
    public function getCurrentCart()
    {
        if (!Auth::check()) {
            return null;
        }

        return Cart::firstOrCreate([
            'user_id' => Auth::id()
        ]);
    }

    public function count()
    {
        $cart = $this->getCurrentCart();
        return $cart ? $cart->items()->sum('quantity') : 0;
    }

    public function addItem(Product $product, $quantity = 1)
    {
        $cart = $this->getCurrentCart();
        if (!$cart) {
            return false;
        }

        // Check if product already in cart
        $cartItem = $cart->items()->where('product_id', $product->id)->first();

        if ($cartItem) {
            // Update quantity if product exists
            $newQuantity = $cartItem->quantity + $quantity;
            if ($product->stock < $newQuantity) {
                return false;
            }
            $cartItem->update(['quantity' => $newQuantity]);
        } else {
            // Add new item if product doesn't exist
            if ($product->stock < $quantity) {
                return false;
            }
            $cart->items()->create([
                'product_id' => $product->id,
                'quantity' => $quantity
            ]);
        }

        return true;
    }

    public function removeItem(CartItem $item)
    {
        if ($item->cart->user_id !== Auth::id()) {
            return false;
        }

        return $item->delete();
    }

    public function updateItemQuantity(CartItem $item, $quantity)
    {
        if ($item->cart->user_id !== Auth::id()) {
            return false;
        }

        if ($item->product->stock < $quantity) {
            return false;
        }

        return $item->update(['quantity' => $quantity]);
    }

    public function clear()
    {
        $cart = $this->getCurrentCart();
        if (!$cart) {
            return false;
        }

        return $cart->items()->delete();
    }

    public function total()
    {
        $cart = $this->getCurrentCart();
        if (!$cart) {
            return 0;
        }

        return $cart->items()
            ->join('products', 'cart_items.product_id', '=', 'products.id')
            ->selectRaw('SUM(cart_items.quantity * products.price) as total')
            ->value('total') ?? 0;
    }
} 