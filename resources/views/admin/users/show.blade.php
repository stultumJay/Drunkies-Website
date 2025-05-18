@extends('layouts.admin')

@section('title', 'User Details')

@section('content')
<div class="space-y-6">
    <!-- User Information -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b">
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-semibold">User Information</h2>
                <div class="flex gap-2">
                    <form action="{{ route('admin.users.update', $user) }}" method="POST" class="inline">
                        @csrf
                        @method('PATCH')
                        <select name="role" 
                                onchange="this.form.submit()"
                                class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>User</option>
                            <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                    </form>
                </div>
            </div>
        </div>

        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="text-lg font-medium mb-4">Personal Information</h3>
                    <dl class="space-y-3">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Name</dt>
                            <dd class="mt-1">{{ $user->name }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Email</dt>
                            <dd class="mt-1">{{ $user->email }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Phone</dt>
                            <dd class="mt-1">{{ $user->phone ?? 'Not provided' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Joined</dt>
                            <dd class="mt-1">{{ $user->created_at->format('M d, Y') }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Status</dt>
                            <dd class="mt-1">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full
                                    {{ $user->email_verified_at ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ $user->email_verified_at ? 'Verified' : 'Unverified' }}
                                </span>
                            </dd>
                        </div>
                    </dl>
                </div>

                <div>
                    <h3 class="text-lg font-medium mb-4">Order Statistics</h3>
                    <dl class="space-y-3">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Total Orders</dt>
                            <dd class="mt-1">{{ $user->orders->count() }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Total Spent</dt>
                            <dd class="mt-1">${{ number_format($user->orders->sum('total'), 2) }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Last Order</dt>
                            <dd class="mt-1">
                                @if($user->orders->isNotEmpty())
                                    {{ $user->orders->sortByDesc('created_at')->first()->created_at->format('M d, Y') }}
                                @else
                                    No orders yet
                                @endif
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <!-- User Orders -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b">
            <h2 class="text-xl font-semibold">Order History</h2>
        </div>

        <div class="p-6">
            @if($user->orders->isNotEmpty())
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="text-left border-b">
                                <th class="pb-3">Order ID</th>
                                <th class="pb-3">Date</th>
                                <th class="pb-3">Total</th>
                                <th class="pb-3">Status</th>
                                <th class="pb-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($user->orders->sortByDesc('created_at') as $order)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="py-3">#{{ $order->id }}</td>
                                <td class="py-3">{{ $order->created_at->format('M d, Y') }}</td>
                                <td class="py-3">${{ number_format($order->total, 2) }}</td>
                                <td class="py-3">
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full
                                        {{ $order->status === 'completed' ? 'bg-green-100 text-green-800' : 
                                           ($order->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                           ($order->status === 'processing' ? 'bg-blue-100 text-blue-800' : 
                                           'bg-red-100 text-red-800')) }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td class="py-3">
                                    <a href="{{ route('admin.orders.show', $order) }}" 
                                       class="text-indigo-600 hover:text-indigo-900">
                                        View
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-gray-500 text-center py-4">No orders found.</p>
            @endif
        </div>
    </div>
</div>
@endsection 