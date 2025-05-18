@extends('layouts.app')

@section('title', $product->name . ' - Drunkies')

@push('styles')
<style>
    .product-gallery {
        position: relative;
        margin-bottom: 2rem;
    }
    .product-main-image {
        width: 100%;
        height: 400px;
        object-fit: contain;
        border-radius: 15px;
        background: #fff;
        padding: 1rem;
    }
    .product-thumbnails {
        display: flex;
        gap: 1rem;
        margin-top: 1rem;
    }
    .product-thumbnail {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 8px;
        cursor: pointer;
        border: 2px solid transparent;
        transition: all 0.3s ease;
    }
    .product-thumbnail.active {
        border-color: var(--ph-red);
    }
    .product-info {
        padding: 2rem;
        background: #fff;
        border-radius: 15px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }
    .product-title {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 1rem;
    }
    .product-brand {
        color: #666;
        margin-bottom: 1rem;
    }
    .product-rating {
        color: #ffc107;
        margin-bottom: 1rem;
    }
    .product-price {
        font-size: 2rem;
        font-weight: 700;
        color: var(--ph-red);
        margin-bottom: 1.5rem;
    }
    .product-description {
        margin-bottom: 1.5rem;
        line-height: 1.6;
    }
    .product-meta {
        margin-bottom: 1.5rem;
    }
    .product-meta-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 0.5rem;
    }
    .quantity-input {
        width: 100px;
    }
    .reviews-section {
        margin-top: 3rem;
    }
    .review-card {
        background: #fff;
        border-radius: 15px;
        padding: 1.5rem;
        margin-bottom: 1rem;
    }
    .review-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
    }
    .reviewer-info {
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    .reviewer-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
    }
    .review-rating {
        color: #ffc107;
    }
    .review-content {
        line-height: 1.6;
    }
    .review-date {
        color: #666;
        font-size: 0.9rem;
    }
</style>
@endpush

@section('content')
<div class="container py-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('brands.show', $product->brand) }}">{{ $product->brand->name }}</a></li>
            <li class="breadcrumb-item active">{{ $product->name }}</li>
        </ol>
    </nav>

    <div class="row g-4">
        <!-- Product Gallery -->
        <div class="col-md-6">
            <div class="product-gallery">
                <img src="{{ asset('storage/images/products/' . $product->brand->slug . '/' . $product->slug . '.jpg') }}" 
                     alt="{{ $product->name }}" 
                     class="product-main-image"
                     id="mainImage">
                <div class="product-thumbnails">
                    <img src="{{ asset('storage/images/products/' . $product->brand->slug . '/' . $product->slug . '.jpg') }}" 
                         alt="{{ $product->name }}" 
                         class="product-thumbnail active"
                         onclick="changeImage(this.src)">
                    <!-- Add more thumbnails if available -->
                </div>
            </div>
        </div>

        <!-- Product Info -->
        <div class="col-md-6">
            <div class="product-info">
                <h1 class="product-title">{{ $product->name }}</h1>
                <p class="product-brand">
                    <a href="{{ route('brands.show', $product->brand) }}" class="text-decoration-none">
                        {{ $product->brand->name }}
                    </a>
                </p>
                
                <div class="product-rating">
                    @for($i = 1; $i <= 5; $i++)
                        <i class="fas fa-star{{ $i <= $product->rating ? '' : '-o' }}"></i>
                    @endfor
                    <span class="ms-2">({{ $product->reviews_count ?? 0 }} reviews)</span>
                </div>

                <div class="product-price">₱{{ number_format($product->price, 2) }}</div>

                <div class="product-description">
                    {{ $product->description }}
                </div>

                <div class="product-meta">
                    <div class="product-meta-item">
                        <i class="fas fa-wine-bottle"></i>
                        <span>{{ $product->alcohol_content }}% ABV</span>
                    </div>
                    <div class="product-meta-item">
                        <i class="fas fa-box"></i>
                        <span>{{ $product->stock }} in stock</span>
                    </div>
                </div>

                <form action="{{ route('cart.add', $product) }}" method="POST" class="d-flex gap-3">
                    @csrf
                    <input type="number" 
                           name="quantity" 
                           value="1" 
                           min="1" 
                           max="{{ $product->stock }}" 
                           class="form-control quantity-input">
                    <button type="submit" class="btn btn-warning flex-grow-1">
                        <i class="fas fa-shopping-cart me-2"></i>Add to Cart
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Reviews Section -->
    <div class="reviews-section">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Customer Reviews</h2>
            @auth
                <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#reviewModal">
                    Write a Review
                </button>
            @endauth
        </div>

        @forelse($product->reviews as $review)
            <div class="review-card">
                <div class="review-header">
                    <div class="reviewer-info">
                        <img src="{{ $review->user->profile_photo_url }}" 
                             alt="{{ $review->user->name }}" 
                             class="reviewer-avatar">
                        <div>
                            <h5 class="mb-0">{{ $review->user->name }}</h5>
                            <div class="review-rating">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star{{ $i <= $review->rating ? '' : '-o' }}"></i>
                                @endfor
                            </div>
                        </div>
                    </div>
                    <span class="review-date">{{ $review->created_at->diffForHumans() }}</span>
                </div>
                <p class="review-content">{{ $review->comment }}</p>
            </div>
        @empty
            <div class="text-center py-5">
                <i class="fas fa-comments fa-3x text-muted mb-3"></i>
                <p class="lead">No reviews yet. Be the first to review this product!</p>
            </div>
        @endforelse
    </div>
</div>

<!-- Review Modal -->
@auth
<div class="modal fade" id="reviewModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Write a Review</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('products.reviews.store', $product) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Rating</label>
                        <div class="rating-input">
                            @for($i = 5; $i >= 1; $i--)
                                <input type="radio" name="rating" value="{{ $i }}" id="star{{ $i }}" required>
                                <label for="star{{ $i }}"><i class="fas fa-star"></i></label>
                            @endfor
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Your Review</label>
                        <textarea name="comment" rows="4" class="form-control" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning">Submit Review</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endauth
@endsection

@push('scripts')
<script>
function changeImage(src) {
    document.getElementById('mainImage').src = src;
    document.querySelectorAll('.product-thumbnail').forEach(thumb => {
        thumb.classList.remove('active');
        if (thumb.src === src) {
            thumb.classList.add('active');
        }
    });
}

// Initialize rating input in review modal
document.addEventListener('DOMContentLoaded', function() {
    const ratingInputs = document.querySelectorAll('.rating-input input');
    const ratingLabels = document.querySelectorAll('.rating-input label');

    ratingInputs.forEach((input, index) => {
        input.addEventListener('change', () => {
            ratingLabels.forEach((label, i) => {
                if (i <= index) {
                    label.classList.add('active');
                } else {
                    label.classList.remove('active');
                }
            });
        });
    });
});
</script>
@endpush 