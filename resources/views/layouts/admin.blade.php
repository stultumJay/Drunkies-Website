<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - @yield('title', 'Dashboard')</title>
    
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @stack('styles')
</head>
<body class="bg-gray-100">
    <!-- Admin Navigation -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <div class="flex-shrink-0 flex items-center">
                        <a href="{{ route('admin.dashboard') }}" class="text-xl font-bold">
                            {{ config('app.name') }} Admin
                        </a>
                    </div>
                </div>
                
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="text-gray-500 hover:text-gray-700">View Site</a>
                    <form method="POST" action="{{ route('logout') }}" class="ml-4">
                        @csrf
                        <button type="submit" class="text-gray-500 hover:text-gray-700">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div class="flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-white shadow-lg h-screen">
            <nav class="mt-5 px-2">
                <a href="{{ route('admin.dashboard') }}" class="group flex items-center px-2 py-2 text-base leading-6 font-medium rounded-md text-gray-900 hover:bg-gray-50">
                    Dashboard
                </a>
                <a href="{{ route('admin.products.index') }}" class="mt-1 group flex items-center px-2 py-2 text-base leading-6 font-medium rounded-md text-gray-900 hover:bg-gray-50">
                    Products
                </a>
                <a href="{{ route('admin.orders.index') }}" class="mt-1 group flex items-center px-2 py-2 text-base leading-6 font-medium rounded-md text-gray-900 hover:bg-gray-50">
                    Orders
                </a>
                <a href="{{ route('admin.users.index') }}" class="mt-1 group flex items-center px-2 py-2 text-base leading-6 font-medium rounded-md text-gray-900 hover:bg-gray-50">
                    Users
                </a>
                <a href="{{ route('admin.settings') }}" class="mt-1 group flex items-center px-2 py-2 text-base leading-6 font-medium rounded-md text-gray-900 hover:bg-gray-50">
                    Settings
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-6">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    @stack('scripts')
</body>
</html> 