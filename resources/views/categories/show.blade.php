@extends('layouts.app')

@section('title', $category->name . ' - Drunkies')

@push('styles')
<link rel="stylesheet" href="{{ asset('resources/css/products-page.css') }}">
@endpush

@section('content')
<div class="container py-4">
    <!-- 3-Image Carousel -->
    <div id="categoryCarousel" class="carousel slide mb-4" data-bs-ride="carousel">
        <div class="carousel-inner rounded shadow-sm">
            <div class="carousel-item active">
                <img src="https://placehold.co/900x250/FFD600/222?text=Promo+1" class="d-block w-100" alt="Promo 1">
            </div>
            <div class="carousel-item">
                <img src="https://placehold.co/900x250/1976D2/fff?text=Promo+2" class="d-block w-100" alt="Promo 2">
            </div>
            <div class="carousel-item">
                <img src="https://placehold.co/900x250/FF1744/fff?text=Promo+3" class="d-block w-100" alt="Promo 3">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#categoryCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#categoryCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>

    <!-- Breadcrumbs -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb bg-white px-3 py-2 rounded shadow-sm">
            <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="fas fa-home me-1"></i>Home Page</a></li>
            <li class="breadcrumb-item active">{{ $category->name }}</li>
        </ol>
    </nav>

    <div class="row g-4">
        <!-- Sidebar -->
        <aside class="col-12 col-md-3 mb-4 mb-md-0">
            <div class="card p-3 mb-3">
                <h6 class="fw-bold mb-2">Brands</h6>
                <form id="brand-filter-form">
                    @foreach($brands as $b)
                        <div class="form-check">
                            <input class="form-check-input brand-checkbox" type="checkbox" name="brands[]" value="{{ $b->id }}" id="brand-{{ $b->id }}" {{ in_array($b->id, $selectedBrands ?? []) ? 'checked' : '' }}>
                            <label class="form-check-label" for="brand-{{ $b->id }}">{{ $b->name }}</label>
                        </div>
                    @endforeach
                </form>
            </div>
            <div class="card p-3">
                <h6 class="fw-bold mb-2">Categories</h6>
                <form id="category-filter-form">
                    @foreach($categories as $cat)
                        <div class="form-check">
                            <input class="form-check-input category-checkbox" type="checkbox" name="categories[]" value="{{ $cat->id }}" id="cat-{{ $cat->id }}" {{ in_array($cat->id, $selectedCategories ?? []) ? 'checked' : '' }}>
                            <label class="form-check-label" for="cat-{{ $cat->id }}">{{ $cat->name }}</label>
                        </div>
                    @endforeach
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <section class="col-12 col-md-9">
            <!-- Sort Bar -->
            <div class="d-flex flex-wrap align-items-center justify-content-between mb-3 gap-2">
                <h4 class="mb-0 fw-bold">{{ $category->name }} Beers</h4>
                <form id="sort-form" class="d-flex align-items-center gap-2">
                    <label for="sort" class="me-2 mb-0">Sort by:</label>
                    <select name="sort" id="sort" class="form-select form-select-sm w-auto">
                        <option value="popular" {{ $sort == 'popular' ? 'selected' : '' }}>Popular</option>
                        <option value="new" {{ $sort == 'new' ? 'selected' : '' }}>New</option>
                        <option value="price_low" {{ $sort == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                        <option value="price_high" {{ $sort == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                    </select>
                </form>
            </div>
            <!-- Product Grid -->
            <div class="row g-4">
                @forelse($products as $product)
                    <div class="col-12 col-md-6 col-lg-3">
                        @include('components.product-card', ['product' => $product])
                    </div>
                @empty
                    <div class="col-12"><div class="alert alert-info">No products found.</div></div>
                @endforelse
            </div>
        </section>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('resources/js/products-page.js') }}"></script>
@endpush 