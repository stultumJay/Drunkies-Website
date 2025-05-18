@extends('layouts.admin')

@section('title', 'Analytics')

@section('content')
<div class="space-y-6">
    <!-- Sales by Category -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b">
            <h2 class="text-lg font-semibold">Sales by Category</h2>
        </div>
        <div class="p-6">
            <div class="h-80">
                <canvas id="categorySalesChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Top Selling Products -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b">
            <h2 class="text-lg font-semibold">Top Selling Products</h2>
        </div>
        <div class="p-6">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="text-left border-b">
                            <th class="pb-3">Product</th>
                            <th class="pb-3">Brand</th>
                            <th class="pb-3">Units Sold</th>
                            <th class="pb-3">Revenue</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($topSellingProducts as $product)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-3">
                                <div class="flex items-center">
                                    <img src="{{ Storage::url($product->image_url) }}" 
                                         alt="{{ $product->name }}"
                                         class="w-10 h-10 object-cover rounded">
                                    <span class="ml-3">{{ $product->name }}</span>
                                </div>
                            </td>
                            <td class="py-3">{{ $product->brand->name }}</td>
                            <td class="py-3">{{ $product->units_sold }}</td>
                            <td class="py-3">₱{{ number_format($product->revenue, 2) }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="py-4 text-center text-gray-500">
                                No sales data available.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Sales by Category Chart
    const categoryCtx = document.getElementById('categorySalesChart').getContext('2d');
    new Chart(categoryCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($salesByCategory->pluck('category_name')) !!},
            datasets: [{
                label: 'Sales (₱)',
                data: {!! json_encode($salesByCategory->pluck('total_sales')) !!},
                backgroundColor: 'rgba(79, 70, 229, 0.2)',
                borderColor: 'rgba(79, 70, 229, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return '₱' + value.toLocaleString();
                        }
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
});
</script>
@endpush
@endsection 