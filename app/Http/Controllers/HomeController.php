<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        try {
            // Top Products (based on quantity sold)
            $topProducts = Product::with(['brand', 'category'])
                ->orderBy('quantity_sold', 'desc')
                ->limit(10)
                ->get();

            // Daily Discover Products (random selection with pagination)
            $products = Product::with(['brand', 'category'])
                ->inRandomOrder()
                ->paginate(20);

            // Featured Products (is_featured flag)
            $featuredProducts = Product::with(['brand', 'category'])
                ->where('is_featured', true)
                ->limit(4)
                ->get();

            // Categories with product count
            $categories = Category::withCount('products')
                ->orderBy('name')
                ->limit(6)
                ->get();

            // Featured Brands (brands with products)
            $featuredBrands = Brand::has('products')
                ->orderBy('name')
                ->limit(6)
                ->get();

            return view('home', compact('topProducts', 'products', 'featuredProducts', 'categories', 'featuredBrands'));
        } catch (\Exception $e) {
            \Log::error('Home page error: ' . $e->getMessage());
            return view('home', [
                'topProducts' => collect([]),
                'products' => new \Illuminate\Pagination\LengthAwarePaginator([], 0, 20),
                'featuredProducts' => collect([]),
                'categories' => collect([]),
                'featuredBrands' => collect([])
            ])->with('error', 'Unable to load some content. Please try again later.');
        }
    }

    public function newsletterSubscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:newsletter_subscribers,email'
        ]);

        NewsletterSubscriber::create([
            'email' => $request->email
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Successfully subscribed to newsletter!'
        ]);
    }
} 