@extends('layouts.admin')

@section('title', 'Orders')

@section('content')
<div class="bg-white rounded-lg shadow">
    <div class="p-6 border-b">
        <h2 class="text-xl font-semibold">Manage Orders</h2>
    </div>

    <div class="p-6">
        <!-- Search and Filter -->
        <div class="mb-6">
            <form action="{{ route('admin.orders.index') }}" method="GET" class="flex gap-4">
                <div class="flex-1">
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}"
                           placeholder="Search by order ID or customer name..."
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>
                <div>
                    <select name="status" 
                            class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">All Status</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="processing" {{ request('status') === 'processing' ? 'selected' : '' }}>Processing</option>
                        <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
                <div>
                    <button type="submit" 
                            class="bg-gray-100 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-200">
                        Filter
                    </button>
                </div>
            </form>
        </div>

        <!-- Orders Table -->
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="text-left border-b">
                        <th class="pb-3">Order ID</th>
                        <th class="pb-3">Customer</th>
                        <th class="pb-3">Date</th>
                        <th class="pb-3">Total</th>
                        <th class="pb-3">Status</th>
                        <th class="pb-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-3">#{{ $order->id }}</td>
                        <td class="py-3">
                            <div class="font-medium">{{ $order->user->name }}</div>
                            <div class="text-sm text-gray-500">{{ $order->user->email }}</div>
                        </td>
                        <td class="py-3">{{ $order->created_at->format('M d, Y H:i') }}</td>
                        <td class="py-3">₱{{ number_format($order->total, 2) }}</td>
                        <td class="py-3">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full
                                {{ $order->status === 'completed' ? 'bg-green-100 text-green-800' : '' }}
                                {{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                {{ $order->status === 'processing' ? 'bg-blue-100 text-blue-800' : '' }}
                                {{ $order->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td class="py-3">
                            <div class="flex gap-2">
                                <a href="{{ route('admin.orders.show', $order) }}" 
                                   class="text-indigo-600 hover:text-indigo-900">
                                    View
                                </a>
                                <form action="{{ route('admin.orders.update', $order) }}" 
                                      method="POST" 
                                      class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" 
                                            onchange="this.form.submit()"
                                            class="text-sm border-gray-300 rounded-md focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing</option>
                                        <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                        <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    </select>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-4 text-center text-gray-500">
                            No orders found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $orders->links() }}
        </div>
    </div>
</div>
@endsection 