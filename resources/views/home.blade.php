@extends('layouts.app')

@section('title', 'Drunkies - Home')

@push('styles')
<style>
    .top10-carousel-container {
        position: relative;
        padding: 0 50px;
        margin-bottom: 2rem;
    }
    .products-carousel {
        display: flex;
        overflow-x: auto;
        scroll-behavior: smooth;
        gap: 1rem;
        padding-bottom: 1rem;
    }
    .carousel-item {
        flex: 0 0 auto;
        width: 270px;
        transition: transform 0.3s ease;
        position: relative;
    }
    .product-card {
        border-radius: 15px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.08);
        transition: transform 0.3s ease;
        background: #fff;
        height: 100%;
        cursor: pointer;
    }
    .product-card:hover {
        transform: translateY(-5px) scale(1.03);
    }
    .carousel-control {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 40px;
        height: 40px;
        border-radius: 50%;
        z-index: 1;
        background: var(--beer-yellow);
        color: #222;
        border: none;
        font-size: 1.5rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }
    .carousel-control.prev { left: 10px; }
    .carousel-control.next { right: 10px; }
    .top-sticker {
        position: absolute;
        top: 10px;
        left: 10px;
        z-index: 2;
        font-size: 1.1rem;
        font-weight: bold;
        padding: 0.3em 0.7em;
        border-radius: 1em;
        color: #fff;
        display: flex;
        align-items: center;
        gap: 0.3em;
    }
    .top1 { background: var(--ph-red); }
    .top2 { background: var(--ph-blue); }
    .top3 { background: var(--beer-yellow); color: #222; }
    .top4to10 { background: #888; }
    .product-card .card-img-top {
        height: 180px;
        object-fit: cover;
        border-radius: 15px 15px 0 0;
    }
    .product-card .card-title {
        font-size: 1.1rem;
        font-weight: bold;
    }
    .product-card .card-text {
        font-size: 0.95rem;
    }
    .product-card .price {
        color: var(--ph-red);
        font-weight: bold;
        font-size: 1.1rem;
    }
    .product-card .stock {
        color: var(--ph-blue);
        font-size: 0.95rem;
    }
    .breadcrumb {
        background: none;
        padding: 0;
        margin-bottom: 1.5rem;
    }
    .hero-section {
        background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('{{ asset('images/hero-bg.jpg') }}');
        background-size: cover;
        background-position: center;
    }
    .product-card {
        transition: transform 0.2s;
    }
    .product-card:hover {
        transform: translateY(-5px);
    }
    .product-card img {
        height: 200px;
        object-fit: contain;
        padding: 1rem;
    }
    .rating {
        color: #ffc107;
    }
    .product-price {
        font-size: 1.25rem;
        font-weight: bold;
        color: #0d6efd;
    }
    .brand-carousel-wrapper {
        overflow: hidden;
        position: relative;
        width: 100%;
        background: #fff;
    }
    .brand-carousel {
        display: flex;
        animation: scrollBrands 20s linear infinite;
    }
    .brand-logo {
        flex: 0 0 auto;
        width: 120px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    @keyframes scrollBrands {
        0% { transform: translateX(0); }
        100% { transform: translateX(-50%); }
    }
    .brand-carousel-container {
        overflow: hidden;
        position: relative;
        width: 100%;
        background: #fff;
        padding: 2rem 0;
        margin: 2rem 0;
    }
    .brand-carousel {
        display: flex;
        animation: scrollBrands 30s linear infinite;
        width: calc(200px * 10); /* Adjust based on number of brands */
    }
    .brand-carousel:hover {
        animation-play-state: paused;
    }
    .brand-logo {
        flex: 0 0 200px;
        height: 100px;
        padding: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .brand-logo img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
        transition: transform 0.3s ease;
    }
    .brand-logo:hover img {
        transform: scale(1.1);
    }
    @keyframes scrollBrands {
        0% { transform: translateX(0); }
        100% { transform: translateX(calc(-200px * 5)); } /* Half of total width */
    }
    .product-card {
        border-radius: 15px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
        height: 100%;
        overflow: hidden;
    }
    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 15px rgba(0,0,0,0.2);
    }
    .product-image {
        height: 250px;
        width: 100%;
        object-fit: cover;
    }
    .product-details {
        padding: 1.5rem;
    }
    .product-title {
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }
    .product-brand {
        color: #666;
        font-size: 0.9rem;
        margin-bottom: 1rem;
    }
    .product-price {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--ph-red);
        margin-bottom: 1rem;
    }
    .product-rating {
        color: #ffc107;
        margin-bottom: 1rem;
    }
    .product-actions {
        display: flex;
        gap: 1rem;
    }
</style>
@endpush

@section('content')
<!-- Hero Section -->
<div class="hero-section bg-dark text-light py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="display-4 fw-bold mb-4">Welcome to Drunkies</h1>
                <p class="lead mb-4">Your premier destination for Philippine craft and commercial beers.</p>
                <a href="{{ route('products.index') }}" class="btn btn-warning btn-lg">Shop Now</a>
            </div>
            <div class="col-md-6">
                <img src="{{ asset('storage/images/hero-image.png') }}" alt="Hero Image" class="img-fluid rounded">
            </div>
        </div>
    </div>
</div>

<!-- Featured Brands Carousel -->
<div class="brand-carousel-container">
    <div class="container">
        <h2 class="text-center mb-4">Featured Brands</h2>
        <div class="brand-carousel">
            @foreach($brands as $brand)
                <a href="{{ route('brands.show', $brand) }}" class="brand-logo">
                    <img src="{{ asset('storage/images/brands/'.$brand->slug.'.jpg') }}" 
                         alt="{{ $brand->name }}" 
                         loading="lazy"
                         onerror="this.onerror=null; this.src='{{ asset('storage/images/brands/'.$brand->slug.'.png') }}'; this.onerror=null;">
                </a>
            @endforeach
            <!-- Duplicate brands for infinite scroll effect -->
            @foreach($brands as $brand)
                <a href="{{ route('brands.show', $brand) }}" class="brand-logo">
                    <img src="{{ asset('storage/images/brands/'.$brand->slug.'.jpg') }}" 
                         alt="{{ $brand->name }}" 
                         loading="lazy"
                         onerror="this.onerror=null; this.src='{{ asset('storage/images/brands/'.$brand->slug.'.png') }}'; this.onerror=null;">
                </a>
            @endforeach
        </div>
    </div>
</div>

<!-- Featured Categories -->
<div class="container py-5">
    <h2 class="text-center mb-4">Shop by Category</h2>
    <div class="row g-4">
        @foreach($categories as $category)
        <div class="col-6 col-md-4 col-lg-2">
            <a href="{{ route('categories.show', $category) }}" class="text-decoration-none">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center">
                        <i class="fas {{ $category->icon }} fa-2x mb-3 text-warning"></i>
                        <h5 class="card-title mb-0">{{ $category->name }}</h5>
                        <small class="text-muted">{{ $category->products_count }} Products</small>
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>
</div>

<!-- Featured Products -->
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Featured Products</h2>
        <a href="{{ route('products.index') }}" class="btn btn-outline-warning">View All</a>
    </div>
    <div class="row g-4">
        @foreach($featuredProducts as $product)
        <div class="col-6 col-md-4 col-lg-3">
            <div class="product-card">
                <img src="{{ asset('storage/images/products/'.$product->brand->slug.'/'.$product->slug.'.jpg') }}" 
                     class="product-image" 
                     alt="{{ $product->name }}"
                     loading="lazy"
                     onerror="this.onerror=null; this.src='{{ asset('storage/images/placeholder.jpg') }}';">
                <div class="product-details">
                    <h3 class="product-title">{{ $product->name }}</h3>
                    <p class="product-brand">{{ $product->brand->name }}</p>
                    <div class="product-rating">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star{{ $i <= $product->rating ? '' : '-o' }}"></i>
                        @endfor
                        <span class="ms-2 text-muted">({{ $product->reviews_count ?? 0 }} reviews)</span>
                    </div>
                    <div class="product-price">₱{{ number_format($product->price, 2) }}</div>
                    <div class="product-actions">
                        <button onclick="addToCart({{ $product->id }})" 
                                class="btn btn-warning flex-grow-1">
                            <i class="fas fa-shopping-cart me-2"></i>Add to Cart
                        </button>
                        <a href="{{ route('products.show', $product) }}" 
                           class="btn btn-outline-dark">
                            <i class="fas fa-eye"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- Latest Products -->
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Latest Products</h2>
        <div class="d-flex align-items-center">
            <span id="product-count" class="me-3">Showing {{ $products->count() }} of {{ $products->total() }} products</span>
        </div>
    </div>
    <div class="row g-4" id="products-container">
        @foreach($products as $product)
        <div class="col-6 col-md-4 col-lg-3">
            <div class="card h-100 product-card">
                <img src="{{ asset('storage/images/products/'.$product->brand->slug.'/'.$product->slug.'.jpg') }}" 
                     class="card-img-top" 
                     alt="{{ $product->name }}"
                     loading="lazy"
                     onerror="this.onerror=null; this.src='{{ asset('storage/images/placeholder.jpg') }}';">
                <div class="card-body">
                    <h5 class="card-title">{{ $product->name }}</h5>
                    <p class="text-muted mb-2">{{ $product->brand->name }}</p>
                    <div class="rating mb-2">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star{{ $i <= $product->rating ? '' : '-o' }}"></i>
                        @endfor
                    </div>
                    <p class="alcohol-content">
                        <i class="fas fa-wine-bottle me-1"></i>
                        {{ $product->alcohol_content }}% ABV
                    </p>
                    <p class="product-price mb-3">₱{{ number_format($product->price, 2) }}</p>
                    <div class="d-grid gap-2">
                        <button onclick="addToCart({{ $product->id }})" class="btn btn-primary">
                            <i class="fas fa-shopping-cart me-1"></i> Add to Cart
                        </button>
                        <a href="{{ route('products.show', $product) }}" 
                           class="btn btn-outline-primary">
                            View Details
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    @if($products->hasMorePages())
    <div class="text-center mt-4">
        <button id="load-more" class="btn btn-warning btn-lg" 
                data-next-page="{{ $products->currentPage() + 1 }}">
            Load More Products
        </button>
    </div>
    @endif
</div>

@push('scripts')
<script>
$(document).ready(function() {
    $('#load-more').click(function() {
        const button = $(this);
        const nextPage = button.data('next-page');
        
        button.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2"></span>Loading...');
        
        $.get('{{ route('home') }}?page=' + nextPage, function(response) {
            const parser = new DOMParser();
            const doc = parser.parseFromString(response, 'text/html');
            const newProducts = doc.querySelectorAll('#products-container .col-6');
            
            newProducts.forEach(product => {
                document.getElementById('products-container').appendChild(product);
            });
            
            const hasMore = doc.querySelector('#load-more');
            if (hasMore) {
                button.data('next-page', nextPage + 1);
                button.prop('disabled', false).text('Load More Products');
            } else {
                button.remove();
            }
            
            // Update product count
            const productCount = doc.getElementById('product-count').textContent;
            $('#product-count').text(productCount);
        });
    });
});

function addToCart(productId) {
    $.post('{{ route('cart.add') }}', {
        _token: '{{ csrf_token() }}',
        product_id: productId,
        quantity: 1
    })
    .done(function(response) {
        // Show success message
        const toast = new bootstrap.Toast(document.getElementById('cart-toast'));
        $('#cart-toast .toast-body').text('Product added to cart successfully!');
        toast.show();
        
        // Update cart count
        $('#cart-count').text(response.cartCount);
    })
    .fail(function(xhr) {
        // Show error message
        const toast = new bootstrap.Toast(document.getElementById('cart-toast'));
        $('#cart-toast .toast-body').text(xhr.responseJSON.message || 'Error adding product to cart');
        toast.show();
    });
}
</script>
@endpush 