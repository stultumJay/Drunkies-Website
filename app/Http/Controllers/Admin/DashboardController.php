<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Review;
use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Get recent orders
        $recentOrders = Order::with(['user', 'items.product'])
            ->latest()
            ->take(5)
            ->get();

        // Get low stock products
        $lowStockProducts = Product::where('stock', '<', 10)
            ->orderBy('stock')
            ->take(5)
            ->get();

        // Get sales statistics
        $salesStats = Order::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('COUNT(*) as total_orders'),
            DB::raw('SUM(total) as total_sales')
        )
        ->where('created_at', '>=', now()->subDays(30))
        ->groupBy('date')
        ->get();

        // Get user statistics
        $userStats = [
            'total' => User::count(),
            'new_this_month' => User::where('created_at', '>=', now()->startOfMonth())->count(),
            'active' => User::where('last_login_at', '>=', now()->subDays(30))->count(),
        ];

        return view('admin.dashboard', compact(
            'recentOrders',
            'lowStockProducts',
            'salesStats',
            'userStats'
        ));
    }

    public function storeProduct(Request $request)
    {
        $request->validate([
            'brand_id' => 'required|exists:brands,id',
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'alcohol_content' => 'required|numeric|min:0|max:100',
            'container_type' => 'required|string|in:Bottle,Can',
            'volume' => 'required|string',
            'is_featured' => 'boolean'
        ]);

        // Get the brand slug for folder organization
        $brand = Brand::find($request->brand_id);
        $brandSlug = Str::slug($brand->name);
        
        // Store image in brand-specific folder
        $imagePath = $request->file('image')->store("products/{$brandSlug}", 'public');

        $product = Product::create([
            'brand_id' => $request->brand_id,
            'category_id' => $request->category_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'image_url' => $imagePath,
            'alcohol_content' => $request->alcohol_content,
            'container_type' => $request->container_type,
            'volume' => $request->volume,
            'is_featured' => $request->boolean('is_featured', false),
            'rating' => 0
        ]);

        return redirect()->back()->with('success', 'Product added successfully!');
    }

    public function deleteProduct(Product $product)
    {
        if ($product->image_url) {
            Storage::disk('public')->delete($product->image_url);
        }
        
        $product->delete();
        return redirect()->back()->with('success', 'Product deleted successfully!');
    }

    public function updateStock(Request $request, Product $product)
    {
        $request->validate([
            'stock' => 'required|integer|min:0'
        ]);

        $product->update(['stock' => $request->stock]);
        return redirect()->back()->with('success', 'Stock updated successfully!');
    }

    public function deleteReview(Review $review)
    {
        $review->delete();
        return redirect()->back()->with('success', 'Review deleted successfully!');
    }

    public function inventory()
    {
        $products = Product::with(['brand', 'category'])
            ->orderBy('stock', 'asc')
            ->paginate(20);
        
        $lowStockCount = Product::where('stock', '<=', 5)->count();
        $totalStock = Product::sum('stock');
        $totalValue = Product::selectRaw('SUM(stock * price) as value')->first()->value;
        
        return view('admin.inventory', compact('products', 'lowStockCount', 'totalStock', 'totalValue'));
    }

    public function orders()
    {
        $orders = Order::with(['user', 'items.product'])
            ->latest()
            ->paginate(20);
        
        return view('admin.orders', compact('orders'));
    }

    public function users()
    {
        $users = User::withCount('orders')
            ->latest()
            ->paginate(20);
        
        return view('admin.users', compact('users'));
    }

    public function analytics()
    {
        // This would normally include more complex queries for analytics
        $topProducts = Product::orderBy('quantity_sold', 'desc')->take(10)->get();
        $topBrands = Brand::withCount('products')->orderBy('products_count', 'desc')->take(5)->get();
        
        return view('admin.analytics', compact('topProducts', 'topBrands'));
    }

    public function promos()
    {
        return view('admin.promos');
    }

    public function settings()
    {
        return view('admin.settings');
    }
} 