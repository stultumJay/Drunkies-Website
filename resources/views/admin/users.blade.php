@extends('layouts.admin')

@section('title', 'User Management')
@section('header-title', 'Users')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="h3 mb-0">User Management</h1>
        </div>
    </div>

    <!-- Overview Stats -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="me-3 bg-primary text-white rounded-3 p-3">
                        <i class="fas fa-users fa-2x"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Total Users</div>
                        <div class="h3 mb-0">{{ $users->total() ?? 0 }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="me-3 bg-success text-white rounded-3 p-3">
                        <i class="fas fa-user-tag fa-2x"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Customer Accounts</div>
                        <div class="h3 mb-0">{{ ($users->total() ?? 0) - 1 }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="me-3 bg-warning text-white rounded-3 p-3">
                        <i class="fas fa-user-shield fa-2x"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Admin Accounts</div>
                        <div class="h3 mb-0">1</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="me-3 bg-info text-white rounded-3 p-3">
                        <i class="fas fa-user-clock fa-2x"></i>
                    </div>
                    <div>
                        <div class="text-muted small">New This Month</div>
                        <div class="h3 mb-0">0</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Users Table -->
    <div class="card">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">User List</h5>
            <div class="d-flex">
                <form action="{{ route('admin.users') }}" method="GET" class="me-2">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Search users..." value="{{ request('search') }}">
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
                        <li><a class="dropdown-item" href="{{ route('admin.users', ['role' => 'admin']) }}">Admins</a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.users', ['role' => 'customer']) }}">Customers</a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.users') }}">All Users</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Joined</th>
                            <th>Orders</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users ?? [] as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <span class="badge bg-{{ $user->isAdmin() ? 'warning' : 'success' }}">
                                    {{ $user->isAdmin() ? 'Admin' : 'Customer' }}
                                </span>
                            </td>
                            <td>{{ $user->created_at->format('M d, Y') }}</td>
                            <td>{{ $user->orders_count ?? 0 }}</td>
                            <td>
                                <div class="btn-group">
                                    <a href="#" class="btn btn-sm btn-primary">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-secondary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                                        <span class="visually-hidden">Toggle Dropdown</span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="#">View Orders</a></li>
                                        <li><a class="dropdown-item" href="#">Edit User</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item text-danger" href="#">Delete User</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">No users found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        @if(isset($users) && method_exists($users, 'links'))
        <div class="card-footer">
            <div class="d-flex justify-content-end">
                {{ $users->links() }}
            </div>
        </div>
        @endif
    </div>
</div>
@endsection 