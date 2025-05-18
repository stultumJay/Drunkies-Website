<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['brand', 'category']);

        // Filter by brand
        if ($request->has('brand')) {
            $query->whereHas('brand', function($q) use ($request) {
                $q->where('slug', $request->brand);
            });
        }

        // Filter by category
        if ($request->has('category')) {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // Filter by price range
        if ($request->has('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->has('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhereHas('brand', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  })
                  ->orWhereHas('category', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Sorting
        $sort = $request->get('sort', 'newest');
        switch ($sort) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            case 'rating':
                $query->orderBy('rating', 'desc');
                break;
            default:
                $query->latest();
                break;
        }

        $products = $query->paginate(12);

        if ($request->ajax()) {
            return view('products.partials.grid', compact('products'));
        }

        $brands = Brand::all();
        $categories = Category::all();

        return view('products.index', compact('products', 'brands', 'categories'));
    }

    public function show($brand, $product)
    {
        $product = Product::where('slug', $product)
            ->whereHas('brand', function($query) use ($brand) {
                $query->where('slug', $brand);
            })
            ->with(['brand', 'category', 'reviews.user'])
            ->firstOrFail();

        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->with(['brand', 'category'])
            ->take(4)
            ->get();

        return view('products.show', compact('product', 'relatedProducts'));
    }

    public function byBrand($brand)
    {
        $brand = Brand::where('slug', $brand)->firstOrFail();
        $products = Product::where('brand_id', $brand->id)
            ->with(['brand', 'category'])
            ->paginate(12);

        $brands = Brand::all();
        $categories = Category::all();

        return view('products.index', compact('products', 'brands', 'categories', 'brand'));
    }

    public function byCategory($category)
    {
        $category = Category::where('slug', $category)->firstOrFail();
        $products = Product::where('category_id', $category->id)
            ->with(['brand', 'category'])
            ->paginate(12);

        $brands = Brand::all();
        $categories = Category::all();

        return view('products.index', compact('products', 'brands', 'categories', 'category'));
    }

    public function filter(Request $request)
    {
        return $this->index($request);
    }

    public function searchSuggestions(Request $request)
    {
        $query = $request->get('query');
        
        $suggestions = Product::where('name', 'like', "%{$query}%")
            ->orWhereHas('brand', function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%");
            })
            ->with('brand')
            ->take(5)
            ->get()
            ->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'brand' => $product->brand->name,
                    'price' => $product->price,
                    'image' => Storage::url($product->image_url)
                ];
            });

        return response()->json(['suggestions' => $suggestions]);
    }

    public function review(Request $request, Product $product)
    {
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:10|max:1000'
        ]);

        $review = new Review([
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
            'user_id' => auth()->id()
        ]);

        $product->reviews()->save($review);

        // Update product rating
        $product->rating = $product->reviews()->avg('rating');
        $product->save();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Review submitted successfully!',
                'review' => $review->load('user')
            ]);
        }

        return back()->with('success', 'Review submitted successfully!');
    }

    public function rate(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5'
        ]);

        $product = Product::findOrFail($request->product_id);
        
        $review = $product->reviews()->updateOrCreate(
            ['user_id' => Auth::id()],
            [
                'rating' => $request->rating,
                'comment' => '' // Empty comment for ratings without reviews
            ]
        );

        // Update product's average rating
        $product->rating = $product->reviews()->avg('rating');
        $product->save();

        return response()->json([
            'success' => true,
            'message' => 'Rating updated successfully',
            'new_rating' => $product->rating
        ]);
    }
} 