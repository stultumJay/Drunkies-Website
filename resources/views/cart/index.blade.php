@extends('layouts.app')

@section('title', 'Shopping Cart - Drunkies')

@section('content')
<div class="container py-5">
    <h1 class="mb-4">Shopping Cart</h1>

    @if(count($items) > 0)
        <div class="card bg-dark text-light">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-dark table-hover">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Subtotal</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($items as $item)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $item['product']->image_url }}" alt="{{ $item['product']->name }}" class="img-thumbnail me-3" style="width: 80px;">
                                            <div>
                                                <h5 class="mb-1">{{ $item['product']->name }}</h5>
                                                <small class="text-muted">{{ $item['product']->brand->name }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>${{ number_format($item['product']->price, 2) }}</td>
                                    <td>
                                        <div class="input-group" style="width: 120px;">
                                            <button class="btn btn-outline-light btn-sm quantity-btn" data-action="decrease" data-product-id="{{ $item['product']->id }}">-</button>
                                            <input type="number" class="form-control form-control-sm bg-dark text-light text-center quantity-input" value="{{ $item['quantity'] }}" min="1" data-product-id="{{ $item['product']->id }}">
                                            <button class="btn btn-outline-light btn-sm quantity-btn" data-action="increase" data-product-id="{{ $item['product']->id }}">+</button>
                                        </div>
                                    </td>
                                    <td>${{ number_format($item['subtotal'], 2) }}</td>
                                    <td>
                                        <button class="btn btn-danger btn-sm remove-item" data-product-id="{{ $item['product']->id }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="text-end"><strong>Total:</strong></td>
                                <td colspan="2"><strong>${{ number_format($total, 2) }}</strong></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('products.index') }}" class="btn btn-outline-light">
                        <i class="fas fa-arrow-left me-2"></i>Continue Shopping
                    </a>
                    <div>
                        <button class="btn btn-danger me-2" id="clear-cart">
                            <i class="fas fa-trash me-2"></i>Clear Cart
                        </button>
                        <a href="{{ route('checkout.index') }}" class="btn btn-primary">
                            <i class="fas fa-shopping-cart me-2"></i>Proceed to Checkout
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="text-center py-5">
            <i class="fas fa-shopping-cart fa-4x mb-3 text-muted"></i>
            <h3>Your cart is empty</h3>
            <p class="text-muted">Add some products to your cart to continue shopping.</p>
            <a href="{{ route('products.index') }}" class="btn btn-primary mt-3">
                <i class="fas fa-arrow-left me-2"></i>Continue Shopping
            </a>
        </div>
    @endif
</div>

@push('scripts')
<script>
$(document).ready(function() {
    // Handle quantity changes
    $('.quantity-btn').click(function() {
        const action = $(this).data('action');
        const productId = $(this).data('product-id');
        const input = $(`.quantity-input[data-product-id="${productId}"]`);
        let quantity = parseInt(input.val());

        if (action === 'increase') {
            quantity++;
        } else if (action === 'decrease' && quantity > 1) {
            quantity--;
        }

        input.val(quantity);
        updateCart(productId, quantity);
    });

    // Handle manual quantity input
    $('.quantity-input').change(function() {
        const productId = $(this).data('product-id');
        const quantity = parseInt($(this).val());

        if (quantity < 1) {
            $(this).val(1);
            updateCart(productId, 1);
        } else {
            updateCart(productId, quantity);
        }
    });

    // Handle remove item
    $('.remove-item').click(function() {
        const productId = $(this).data('product-id');
        removeFromCart(productId);
    });

    // Handle clear cart
    $('#clear-cart').click(function() {
        if (confirm('Are you sure you want to clear your cart?')) {
            window.location.href = '{{ route("cart.clear") }}';
        }
    });

    function updateCart(productId, quantity) {
        $.ajax({
            url: '{{ route("cart.update") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                product_id: productId,
                quantity: quantity
            },
            success: function(response) {
                updateCartCount(response.cartCount);
                location.reload(); // Refresh to update totals
            },
            error: function() {
                showToast('Error updating cart', 'error');
            }
        });
    }

    function removeFromCart(productId) {
        $.ajax({
            url: '{{ route("cart.remove") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                product_id: productId
            },
            success: function(response) {
                updateCartCount(response.cartCount);
                location.reload(); // Refresh to update totals
            },
            error: function() {
                showToast('Error removing item from cart', 'error');
            }
        });
    }

    function updateCartCount(count) {
        $('#cart-count').text(count);
    }
});
</script>
@endpush
@endsection 