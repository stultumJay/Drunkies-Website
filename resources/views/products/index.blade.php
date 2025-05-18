@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row">
        <!-- Filters Sidebar -->
        <div class="col-lg-3 mb-4">
            <div class="card bg-dark text-light">
                <div class="card-body">
                    <h5 class="card-title mb-4">Filters</h5>
                    <form id="filterForm" class="filter-form">
                        <!-- Search -->
                        <div class="mb-4">
                            <label class="form-label">Search</label>
                            <input type="text" name="search" class="form-control bg-dark text-light border-secondary" 
                                   value="{{ request('search') }}" placeholder="Search products...">
                        </div>

                        <!-- Brands -->
                        <div class="mb-4">
                            <label class="form-label">Brands</label>
                            @foreach($brands as $brand)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="brands[]" 
                                           value="{{ $brand->slug }}" id="brand{{ $brand->id }}"
                                           {{ in_array($brand->slug, request('brands', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="brand{{ $brand->id }}">
                                        {{ $brand->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>

                        <!-- Categories -->
                        <div class="mb-4">
                            <label class="form-label">Categories</label>
                            @foreach($categories as $category)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="categories[]" 
                                           value="{{ $category->slug }}" id="category{{ $category->id }}"
                                           {{ in_array($category->slug, request('categories', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="category{{ $category->id }}">
                                        {{ $category->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>

                        <!-- Price Range -->
                        <div class="mb-4">
                            <label class="form-label">Price Range</label>
                            <div class="row g-2">
                                <div class="col-6">
                                    <input type="number" name="min_price" class="form-control bg-dark text-light border-secondary" 
                                           value="{{ request('min_price') }}" placeholder="Min">
                                </div>
                                <div class="col-6">
                                    <input type="number" name="max_price" class="form-control bg-dark text-light border-secondary" 
                                           value="{{ request('max_price') }}" placeholder="Max">
                                </div>
                            </div>
                        </div>

                        <!-- Sort -->
                        <div class="mb-4">
                            <label class="form-label">Sort By</label>
                            <select name="sort" class="form-select bg-dark text-light border-secondary">
                                <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest</option>
                                <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                                <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                                <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Name: A to Z</option>
                                <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Name: Z to A</option>
                                <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Rating</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-warning w-100">Apply Filters</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Products Grid -->
        <div class="col-lg-9">
            @if(isset($brand))
                <h2 class="mb-4">{{ $brand->name }} Products</h2>
            @elseif(isset($category))
                <h2 class="mb-4">{{ $category->name }}</h2>
            @else
                <h2 class="mb-4">All Products</h2>
            @endif

            <div id="productsGrid">
                @include('products.partials.grid')
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Handle filter form submission
    $('#filterForm').on('submit', function(e) {
        e.preventDefault();
        const formData = $(this).serialize();
        
        $.get('{{ route("products.filter") }}', formData, function(response) {
            $('#productsGrid').html(response);
        });
    });

    // Handle filter changes
    $('.filter-form select, .filter-form input[type="checkbox"]').on('change', function() {
        $('#filterForm').submit();
    });
});
</script>
@endpush 