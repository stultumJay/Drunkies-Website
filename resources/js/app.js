// Import dependencies
import './bootstrap';
import $ from 'jquery';
import Swal from 'sweetalert2';

// Global Variables
const CURRENCY_SYMBOL = '₱';

// Cart Functions
function updateCartCount(count) {
    $('.cart-badge').text(count);
}

function updateCartTotal(total) {
    $('.cart-total').text(`${CURRENCY_SYMBOL}${total.toFixed(2)}`);
}

// Product Quantity Handlers
$(document).on('click', '.quantity-btn', function() {
    const input = $(this).siblings('.quantity-input');
    const currentVal = parseInt(input.val());
    const isPlus = $(this).hasClass('plus');
    
    if (isPlus) {
        input.val(currentVal + 1);
    } else if (currentVal > 1) {
        input.val(currentVal - 1);
    }
    
    updateProductTotal(input);
});

function updateProductTotal(input) {
    const row = input.closest('tr');
    const price = parseFloat(row.find('.product-price').data('price'));
    const quantity = parseInt(input.val());
    const total = price * quantity;
    
    row.find('.product-total').text(`${CURRENCY_SYMBOL}${total.toFixed(2)}`);
    updateCartSubtotal();
}

function updateCartSubtotal() {
    let subtotal = 0;
    $('.product-total').each(function() {
        subtotal += parseFloat($(this).text().replace(CURRENCY_SYMBOL, ''));
    });
    
    $('.cart-subtotal').text(`${CURRENCY_SYMBOL}${subtotal.toFixed(2)}`);
    
    // Update total with shipping if applicable
    const shipping = parseFloat($('.shipping-cost').data('cost')) || 0;
    const total = subtotal + shipping;
    $('.cart-total').text(`${CURRENCY_SYMBOL}${total.toFixed(2)}`);
}

// Product Filtering
$('.filter-option').on('change', function() {
    const filters = {
        category: $('#categoryFilter').val(),
        brand: $('#brandFilter').val(),
        price: $('#priceFilter').val(),
        sort: $('#sortFilter').val()
    };
    
    $.get('/products/filter', filters, function(response) {
        $('#productsGrid').html(response);
    });
});

// Search Autocomplete
let searchTimeout;
$('#searchInput').on('input', function() {
    clearTimeout(searchTimeout);
    const query = $(this).val();
    
    if (query.length >= 2) {
        searchTimeout = setTimeout(() => {
            $.get('/search/suggestions', { query }, function(response) {
                const suggestions = response.suggestions;
                let html = '';
                
                suggestions.forEach(item => {
                    html += `
                        <div class="suggestion-item">
                            <img src="${item.image}" alt="${item.name}" class="suggestion-img">
                            <div class="suggestion-details">
                                <div class="suggestion-name">${item.name}</div>
                                <div class="suggestion-price">${CURRENCY_SYMBOL}${item.price}</div>
                            </div>
                        </div>
                    `;
                });
                
                $('#searchSuggestions').html(html).show();
            });
        }, 300);
    } else {
        $('#searchSuggestions').hide();
    }
});

// Rating System
$('.rating-stars i').on('click', function() {
    const rating = $(this).data('rating');
    const productId = $(this).closest('.rating-container').data('product-id');
    
    $.ajax({
        url: '/products/rate',
        method: 'POST',
        data: {
            product_id: productId,
            rating: rating,
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            Swal.fire({
                icon: 'success',
                title: 'Thank you!',
                text: 'Your rating has been submitted.',
                timer: 2000,
                timerProgressBar: true
            });
            
            // Update the visual rating
            const stars = $(`.rating-container[data-product-id="${productId}"] .rating-stars i`);
            stars.each(function(index) {
                $(this).toggleClass('fas far', index < rating);
            });
        }
    });
});

// Image Gallery
$('.product-gallery-thumb').on('click', function() {
    const mainImg = $(this).data('main-img');
    $('.product-main-image').attr('src', mainImg);
    $('.product-gallery-thumb').removeClass('active');
    $(this).addClass('active');
});

// Lazy Loading Images
document.addEventListener('DOMContentLoaded', function() {
    const lazyImages = document.querySelectorAll('img[data-src]');
    
    const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src;
                img.removeAttribute('data-src');
                observer.unobserve(img);
            }
        });
    });
    
    lazyImages.forEach(img => imageObserver.observe(img));
});

// Infinite Scroll
let page = 1;
let loading = false;

$(window).scroll(function() {
    if ($(window).scrollTop() + $(window).height() >= $(document).height() - 100) {
        if (!loading) {
            loading = true;
            page++;
            
            $.get(`/products?page=${page}`, function(response) {
                $('#productsGrid').append(response);
                loading = false;
            });
        }
    }
});

// Mobile Menu
$('.mobile-menu-toggle').on('click', function() {
    $('.mobile-menu').toggleClass('active');
    $('body').toggleClass('menu-open');
});

// Initialize Tooltips
$(function () {
    $('[data-bs-toggle="tooltip"]').tooltip();
});

// Export functions for use in other files
window.updateCartCount = updateCartCount;
window.updateCartTotal = updateCartTotal;
