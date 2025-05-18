@extends('layouts.admin')

@section('title', 'Inventory Management')
@section('header-title', 'Inventory')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="h3 mb-0">Inventory Management</h1>
        </div>
    </div>

    <!-- Overview Stats -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="me-3 bg-primary text-white rounded-3 p-3">
                        <i class="fas fa-boxes fa-2x"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Total Stock</div>
                        <div class="h3 mb-0">{{ $totalStock ?? 0 }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="me-3 bg-danger text-white rounded-3 p-3">
                        <i class="fas fa-exclamation-triangle fa-2x"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Low Stock Items</div>
                        <div class="h3 mb-0">{{ $lowStockCount ?? 0 }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="me-3 bg-success text-white rounded-3 p-3">
                        <i class="fas fa-money-bill-wave fa-2x"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Inventory Value</div>
                        <div class="h3 mb-0">₱{{ number_format($totalValue ?? 0, 2) }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Inventory Table -->
    <div class="card">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Inventory List</h5>
            <div class="d-flex">
                <form action="{{ route('admin.inventory') }}" method="GET" class="me-2">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Search products..." value="{{ request('search') }}">
                        <button class="btn btn-outline-secondary" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>
                <div class="dropdown">
                    <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="fas fa-filter me-1"></i> Filter
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('admin.inventory', ['filter' => 'low_stock']) }}">Low Stock</a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.inventory', ['filter' => 'out_of_stock']) }}">Out of Stock</a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.inventory') }}">All Products</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Image</th>
                            <th>Product</th>
                            <th>Brand</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Value</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products ?? [] as $product)
                        <tr>
                            <td>{{ $product->product_id }}</td>
                            <td>
                                <img src="{{ asset('storage/' . $product->image_url) }}" alt="{{ $product->name }}" width="40" height="40" class="img-thumbnail">
                            </td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->brand->name }}</td>
                            <td>{{ $product->category->name }}</td>
                            <td>₱{{ number_format($product->price, 2) }}</td>
                            <td>
                                <span class="{{ $product->stock <= 5 ? 'text-danger' : '' }}">
                                    {{ $product->stock }}
                                </span>
                                <button type="button" class="btn btn-sm btn-outline-secondary ms-2" data-bs-toggle="modal" data-bs-target="#stockModal{{ $product->product_id }}">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </td>
                            <td>₱{{ number_format($product->stock * $product->price, 2) }}</td>
                            <td>
                                <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center py-4">No products found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        @if(isset($products) && method_exists($products, 'links'))
        <div class="card-footer">
            <div class="d-flex justify-content-end">
                {{ $products->links() }}
            </div>
        </div>
        @endif
    </div>
</div>
@endsection 