<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CartItem;
use App\Models\Product;
use App\Services\CartService;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index()
    {
        $cart = session()->get('cart', []);
        $total = 0;
        $items = [];

        foreach ($cart as $id => $details) {
            $product = Product::with(['brand', 'category'])->find($id);
            if ($product) {
                $items[] = [
                    'product' => $product,
                    'quantity' => $details['quantity'],
                    'subtotal' => $product->price * $details['quantity']
                ];
                $total += $product->price * $details['quantity'];
            }
        }

        return view('cart.index', compact('items', 'total'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $product = Product::findOrFail($request->product_id);
        $cart = session()->get('cart', []);

        if (isset($cart[$request->product_id])) {
            $cart[$request->product_id]['quantity'] += $request->quantity;
        } else {
            $cart[$request->product_id] = [
                'quantity' => $request->quantity,
                'name' => $product->name,
                'price' => $product->price,
                'image' => $product->image_url
            ];
        }

        session()->put('cart', $cart);

        if ($request->ajax()) {
            return response()->json([
                'message' => 'Product added to cart successfully',
                'cartCount' => array_sum(array_column($cart, 'quantity'))
            ]);
        }

        return redirect()->back()->with('success', 'Product added to cart successfully');
    }

    public function update(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $cart = session()->get('cart', []);

        if (isset($cart[$request->product_id])) {
            $cart[$request->product_id]['quantity'] = $request->quantity;
            session()->put('cart', $cart);

            if ($request->ajax()) {
                return response()->json([
                    'message' => 'Cart updated successfully',
                    'cartCount' => array_sum(array_column($cart, 'quantity'))
                ]);
            }
        }

        return redirect()->back()->with('error', 'Product not found in cart');
    }

    public function remove(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);

        $cart = session()->get('cart', []);

        if (isset($cart[$request->product_id])) {
            unset($cart[$request->product_id]);
            session()->put('cart', $cart);

            if ($request->ajax()) {
                return response()->json([
                    'message' => 'Product removed from cart',
                    'cartCount' => array_sum(array_column($cart, 'quantity'))
                ]);
            }
        }

        return redirect()->back()->with('error', 'Product not found in cart');
    }

    public function clear()
    {
        session()->forget('cart');
        return redirect()->back()->with('success', 'Cart cleared successfully');
    }
} 