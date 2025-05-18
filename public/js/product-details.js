$(document).ready(function() {
    // Quantity plus/minus
    $('.btn-minus').click(function() {
        let $input = $(this).siblings('input');
        let val = parseInt($input.val()) || 1;
        if (val > 1) $input.val(val - 1);
    });

    $('.btn-plus').click(function() {
        let $input = $(this).siblings('input');
        let val = parseInt($input.val()) || 1;
        let max = parseInt($input.attr('max'));
        if (val < max) $input.val(val + 1);
    });

    // Add to Cart AJAX
    $('#add-to-cart-form').submit(function(e) {
        e.preventDefault();
        let qty = $(this).find('input[name=quantity]').val();
        
        $.ajax({
            url: '/cart/add',
            method: 'POST',
            data: {
                product_id: $('#product-id').val(),
                quantity: qty,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                Swal.fire({ 
                    icon: 'success', 
                    title: 'Added to Cart!', 
                    text: 'Product has been added to your cart.',
                    timer: 2000,
                    timerProgressBar: true 
                });
                // Update cart badge
                if (response.cartCount) {
                    $('#cart-badge').text(response.cartCount);
                }
            },
            error: function() {
                Swal.fire({ 
                    icon: 'error', 
                    title: 'Oops...', 
                    text: 'Something went wrong! Please try again.' 
                });
            }
        });
    });
}); 