<a href="{{ route('products.show', $product->slug) }}" class="text-decoration-none text-dark">
    <div class="card h-100 product-card shadow-sm">
        <img src="{{ Storage::url($product->image_url) }}" 
             class="card-img-top" 
             alt="{{ $product->name }}"
             onerror="this.onerror=null; this.src='{{ asset('storage/images/products/'.$product->brand->slug.'/'.$product->slug.'.png') }}'; this.onerror=function(){this.src='{{ asset('storage/images/placeholder.jpg') }}';};"
             loading="lazy">
        <div class="card-body">
            <h5 class="card-title mb-1">{{ $product->name }}</h5>
            <div class="mb-1 text-muted small">{{ $product->brand->name ?? 'Unknown Brand' }}</div>
            <div class="fw-bold text-warning mb-1">₱{{ number_format($product->price, 2) }}</div>
            <div class="text-success small">Available: {{ $product->stock }}</div>
        </div>
    </div>
</a> 