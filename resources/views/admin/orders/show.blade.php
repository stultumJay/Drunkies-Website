@extends('layouts.admin')

@section('title', 'Order Details')

@section('content')
<div class="space-y-6">
    <!-- Order Header -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b flex justify-between items-center">
            <div>
                <h2 class="text-xl font-semibold">Order #{{ $order->id }}</h2>
                <p class="text-gray-500">{{ $order->created_at->format('F d, Y H:i') }}</p>
            </div>
            <div class="flex items-center gap-4">
                <span class="px-3 py-1 text-sm font-semibold rounded-full
                    {{ $order->status === 'completed' ? 'bg-green-100 text-green-800' : '' }}
                    {{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                    {{ $order->status === 'processing' ? 'bg-blue-100 text-blue-800' : '' }}
                    {{ $order->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}">
                    {{ ucfirst($order->status) }}
                </span>
                <form action="{{ route('admin.orders.update', $order) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <select name="status" 
                            onchange="this.form.submit()"
                            class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing</option>
                        <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </form>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Order Details -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Order Items -->
            <div class="bg-white rounded-lg shadow">
                <div class="p-6 border-b">
                    <h3 class="text-lg font-semibold">Order Items</h3>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        @foreach($order->items as $item)
                        <div class="flex items-center gap-4">
                            <img src="{{ Storage::url($item->product->image_url) }}" 
                                 alt="{{ $item->product->name }}"
                                 class="w-16 h-16 object-cover rounded">
                            <div class="flex-1">
                                <h4 class="font-medium">{{ $item->product->name }}</h4>
                                <p class="text-sm text-gray-500">{{ $item->product->brand->name }}</p>
                            </div>
                            <div class="text-right">
                                <p class="font-medium">₱{{ number_format($item->price, 2) }}</p>
                                <p class="text-sm text-gray-500">Qty: {{ $item->quantity }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="mt-6 pt-6 border-t">
                        <div class="flex justify-between text-sm">
                            <span>Subtotal</span>
                            <span>₱{{ number_format($order->subtotal, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-sm mt-2">
                            <span>Shipping</span>
                            <span>₱{{ number_format($order->shipping_cost, 2) }}</span>
                        </div>
                        <div class="flex justify-between font-semibold mt-2">
                            <span>Total</span>
                            <span>₱{{ number_format($order->total, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Customer & Shipping Info -->
        <div class="space-y-6">
            <!-- Customer Information -->
            <div class="bg-white rounded-lg shadow">
                <div class="p-6 border-b">
                    <h3 class="text-lg font-semibold">Customer Information</h3>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        <div>
                            <p class="text-sm text-gray-500">Name</p>
                            <p class="font-medium">{{ $order->user->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Email</p>
                            <p class="font-medium">{{ $order->user->email }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Phone</p>
                            <p class="font-medium">{{ $order->user->phone ?? 'Not provided' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Shipping Address -->
            <div class="bg-white rounded-lg shadow">
                <div class="p-6 border-b">
                    <h3 class="text-lg font-semibold">Shipping Address</h3>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        <div>
                            <p class="text-sm text-gray-500">Address</p>
                            <p class="font-medium">{{ $order->shipping_address }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">City</p>
                            <p class="font-medium">{{ $order->shipping_city }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Postal Code</p>
                            <p class="font-medium">{{ $order->shipping_postal_code }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 