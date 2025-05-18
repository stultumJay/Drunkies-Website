@extends('layouts.admin')

@section('title', 'Products')

@section('content')
<div class="bg-white rounded-lg shadow">
    <div class="p-6 border-b flex justify-between items-center">
        <h2 class="text-xl font-semibold">Manage Products</h2>
        <a href="{{ route('admin.products.create') }}" 
           class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
            Add New Product
        </a>
    </div>

    <div class="p-6">
        <!-- Search and Filter -->
        <div class="mb-6">
            <form action="{{ route('admin.products.index') }}" method="GET" class="flex gap-4">
                <div class="flex-1">
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}"
                           placeholder="Search products..."
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>
                <div>
                    <select name="brand" 
                            class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">All Brands</option>
                        @foreach($brands as $brand)
                            <option value="{{ $brand->id }}" {{ request('brand') == $brand->id ? 'selected' : '' }}>
                                {{ $brand->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <button type="submit" 
                            class="bg-gray-100 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-200">
                        Filter
                    </button>
                </div>
            </form>
        </div>

        <!-- Products Table -->
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="text-left border-b">
                        <th class="pb-3">Image</th>
                        <th class="pb-3">Name</th>
                        <th class="pb-3">Brand</th>
                        <th class="pb-3">Price</th>
                        <th class="pb-3">Stock</th>
                        <th class="pb-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-3">
                            <img src="{{ Storage::url($product->image_url) }}" 
                                 alt="{{ $product->name }}"
                                 class="w-16 h-16 object-cover rounded">
                        </td>
                        <td class="py-3">
                            <div class="font-medium">{{ $product->name }}</div>
                            <div class="text-sm text-gray-500">{{ $product->category->name }}</div>
                        </td>
                        <td class="py-3">{{ $product->brand->name }}</td>
                        <td class="py-3">₱{{ number_format($product->price, 2) }}</td>
                        <td class="py-3">
                            <span class="{{ $product->stock <= 10 ? 'text-red-600 font-semibold' : '' }}">
                                {{ $product->stock }}
                            </span>
                        </td>
                        <td class="py-3">
                            <div class="flex gap-2">
                                <a href="{{ route('admin.products.edit', $product) }}" 
                                   class="text-indigo-600 hover:text-indigo-900">
                                    Edit
                                </a>
                                <form action="{{ route('admin.products.destroy', $product) }}" 
                                      method="POST" 
                                      onsubmit="return confirm('Are you sure you want to delete this product?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-4 text-center text-gray-500">
                            No products found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $products->links() }}
        </div>
    </div>
</div>
@endsection 