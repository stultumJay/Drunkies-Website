@extends('layouts.admin')

@section('title', 'Order Management')
@section('header-title', 'Orders')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="h3 mb-0">Order Management</h1>
        </div>
    </div>

    <!-- Overview Stats -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="me-3 bg-primary text-white rounded-3 p-3">
                        <i class="fas fa-shopping-cart fa-2x"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Total Orders</div>
                        <div class="h3 mb-0">{{ $orders->total() ?? 0 }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="me-3 bg-warning text-white rounded-3 p-3">
                        <i class="fas fa-clock fa-2x"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Pending Orders</div>
                        <div class="h3 mb-0">0</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="me-3 bg-success text-white rounded-3 p-3">
                        <i class="fas fa-check-circle fa-2x"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Completed Orders</div>
                        <div class="h3 mb-0">0</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="me-3 bg-info text-white rounded-3 p-3">
                        <i class="fas fa-money-bill-wave fa-2x"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Total Revenue</div>
                        <div class="h3 mb-0">₱0.00</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Orders Table -->
    <div class="card">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Order List</h5>
            <div class="d-flex">
                <form action="{{ route('admin.orders') }}" method="GET" class="me-2">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Search orders..." value="{{ request('search') }}">
                        <button class="btn btn-outline-secondary" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>
                <div class="dropdown">
                    <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="fas fa-filter me-1"></i> Filter
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('admin.orders', ['status' => 'pending']) }}">Pending</a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.orders', ['status' => 'processing']) }}">Processing</a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.orders', ['status' => 'completed']) }}">Completed</a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.orders', ['status' => 'cancelled']) }}">Cancelled</a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.orders') }}">All Orders</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>Order ID</th>
                            <th>Customer</th>
                            <th>Date</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Payment</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders ?? [] as $order)
                        <tr>
                            <td>#{{ $order->id }}</td>
                            <td>{{ $order->user->name }}</td>
                            <td>{{ $order->created_at->format('M d, Y H:i') }}</td>
                            <td>₱{{ number_format($order->total, 2) }}</td>
                            <td>
                                <span class="badge bg-{{ 
                                    $order->status == 'pending' ? 'warning' : 
                                    ($order->status == 'processing' ? 'info' : 
                                    ($order->status == 'completed' ? 'success' : 'danger'))
                                }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td>{{ ucfirst($order->payment_method) }}</td>
                            <td>
                                <div class="btn-group">
                                    <a href="#" class="btn btn-sm btn-primary">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-secondary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                                        <span class="visually-hidden">Toggle Dropdown</span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="#">Process</a></li>
                                        <li><a class="dropdown-item" href="#">Complete</a></li>
                                        <li><a class="dropdown-item" href="#">Cancel</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">No orders found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        @if(isset($orders) && method_exists($orders, 'links'))
        <div class="card-footer">
            <div class="d-flex justify-content-end">
                {{ $orders->links() }}
            </div>
        </div>
        @endif
    </div>
</div>
@endsection 