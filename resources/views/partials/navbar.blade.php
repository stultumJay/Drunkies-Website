<nav class="navbar navbar-expand-lg sticky-top bg-dark navbar-dark shadow">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('home') }}">
            <img src="{{ asset('storage/images/logo/drunkies.png') }}" alt="Drunkies Logo" style="height: 45px; width: 45px; object-fit: contain;" onerror="this.onerror=null; this.src='{{ asset('storage/images/placeholder.jpg') }}';">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <!-- Brands Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-light" href="#" id="brandsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Brands
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="brandsDropdown">
                        @foreach($brands as $brand)
                            <li><a class="dropdown-item text-light" href="{{ route('brands.show', $brand) }}">{{ $brand->name }}</a></li>
                        @endforeach
                    </ul>
                </li>
                <!-- Categories Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-light" href="#" id="categoriesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Categories
                    </a>
                    <div class="dropdown-menu dropdown-menu-dark p-3" aria-labelledby="categoriesDropdown" style="min-width: 300px;">
                        <div class="row">
                            @foreach($categories->chunk(ceil($categories->count() / 2)) as $chunk)
                                <div class="col-6">
                                    @foreach($chunk as $category)
                                        <a class="dropdown-item text-light" href="{{ route('categories.show', $category) }}">{{ strtoupper($category->name) }}</a>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    </div>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto align-items-center gap-3">
                @auth
                    <li class="nav-item">
                        <a class="nav-link position-relative text-light" href="{{ route('cart.index') }}">
                            <i class="fas fa-shopping-cart fa-lg"></i>
                            <span class="cart-badge badge rounded-pill bg-danger position-absolute top-0 start-100 translate-middle">{{ $cartCount ?? 0 }}</span>
                        </a>
                    </li>
                    @if(auth()->user()->is_admin)
                    <li class="nav-item">
                        <a class="nav-link text-light" href="{{ route('admin.dashboard') }}">
                            <i class="fas fa-cogs"></i> Admin Dashboard
                        </a>
                    </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link text-light" href="{{ route('profile.settings') }}">
                            <i class="fas fa-user-cog"></i> Profile Settings
                        </a>
                    </li>
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-link nav-link text-light">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </button>
                        </form>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link text-light me-3" href="{{ route('login') }}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-warning px-4 fw-semibold" href="{{ route('register') }}">Create an Account</a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav> 