<div class="row g-4" id="productsGrid">
    @forelse($products as $product)
        <div class="col-md-4 col-lg-3">
            <div class="product-card card h-100 bg-dark text-light">
                <img src="{{ asset('storage/' . $product->image_url) }}"
                     class="card-img-top"
                     alt="{{ $product->name }}"
                     loading="lazy">
                <div class="card-body">
                    <h5 class="card-title text-truncate">{{ $product->name }}</h5>
                    <p class="text-muted mb-2">{{ $product->brand->name }}</p>
                    <div class="rating mb-2">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star{{ $i <= $product->rating ? ' text-warning' : ' text-secondary' }}"></i>
                        @endfor
                        <small class="text-muted ms-1">({{ $product->reviews_count }})</small>
                    </div>
                    <p class="product-price mb-3">₱{{ number_format($product->price, 2) }}</p>
                    <div class="d-grid gap-2">
                        <a href="{{ route('products.show', ['brand' => $product->brand->slug, 'product' => $product->slug]) }}"
                           class="btn btn-outline-warning">
                            View Details
                        </a>
                        <button type="button" 
                                class="btn btn-warning add-to-cart" 
                                data-product-id="{{ $product->id }}"
                                data-product-name="{{ $product->name }}">
                            Add to Cart
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12 text-center">
            <div class="alert alert-info">
                <i class="fas fa-info-circle me-2"></i>
                No products match your filters.
            </div>
        </div>
    @endforelse
</div>

<!-- Pagination -->
@if($products->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $products->links() }}
    </div>
@endif

@push('scripts')
<script>
$(document).ready(function() {
    // Add to Cart
    $('.add-to-cart').on('click', function() {
        const button = $(this);
        const productId = button.data('product-id');
        const productName = button.data('product-name');

        $.ajax({
            url: '{{ route("cart.add") }}',
            method: 'POST',
            data: {
                product_id: productId,
                quantity: 1
            },
            success: function(response) {
                showToast(`${productName} added to cart`, 'success');
                // Update cart count in navbar
                $('#cartCount').text(response.cartCount);
            },
            error: function(xhr) {
                showToast(xhr.responseJSON.message || 'Failed to add to cart', 'error');
            }
        });
    });
});
</script>
@endpush 