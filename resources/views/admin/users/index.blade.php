@extends('layouts.admin')

@section('title', 'Users')

@section('content')
<div class="bg-white rounded-lg shadow">
    <div class="p-6 border-b">
        <h2 class="text-xl font-semibold">Manage Users</h2>
    </div>

    <div class="p-6">
        <!-- Search and Filter -->
        <div class="mb-6">
            <form action="{{ route('admin.users.index') }}" method="GET" class="flex gap-4">
                <div class="flex-1">
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}"
                           placeholder="Search by name or email..."
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>
                <div>
                    <select name="role" 
                            class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">All Roles</option>
                        <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="user" {{ request('role') === 'user' ? 'selected' : '' }}>User</option>
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

        <!-- Users Table -->
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="text-left border-b">
                        <th class="pb-3">Name</th>
                        <th class="pb-3">Email</th>
                        <th class="pb-3">Role</th>
                        <th class="pb-3">Joined</th>
                        <th class="pb-3">Status</th>
                        <th class="pb-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-3">
                            <div class="font-medium">{{ $user->name }}</div>
                            <div class="text-sm text-gray-500">{{ $user->phone ?? 'No phone' }}</div>
                        </td>
                        <td class="py-3">{{ $user->email }}</td>
                        <td class="py-3">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full
                                {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td class="py-3">{{ $user->created_at->format('M d, Y') }}</td>
                        <td class="py-3">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full
                                {{ $user->email_verified_at ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ $user->email_verified_at ? 'Verified' : 'Unverified' }}
                            </span>
                        </td>
                        <td class="py-3">
                            <div class="flex gap-2">
                                <a href="{{ route('admin.users.show', $user) }}" 
                                   class="text-indigo-600 hover:text-indigo-900">
                                    View
                                </a>
                                <form action="{{ route('admin.users.update', $user) }}" 
                                      method="POST" 
                                      class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <select name="role" 
                                            onchange="this.form.submit()"
                                            class="text-sm border-gray-300 rounded-md focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>User</option>
                                        <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                    </select>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-4 text-center text-gray-500">
                            No users found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection 