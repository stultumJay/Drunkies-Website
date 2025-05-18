@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-5">
            <div class="card bg-dark text-light shadow">
                <div class="card-body p-4">
                    <div class="text-center mb-4">
                        <img src="{{ asset('storage/images/logo/drunkies.png') }}" 
                             alt="Drunkies Logo" 
                             class="mb-3" 
                             style="height: 80px; width: 80px; object-fit: contain;"
                             onerror="this.onerror=null; this.src='{{ asset('storage/images/placeholder.jpg') }}';">
                        <h2 class="fw-bold text-warning mb-2">Welcome Back!</h2>
                        <p class="text-light-emphasis">Enter your credentials to access your account</p>
                    </div>

                    @if (session('status'))
                        <div class="alert alert-info text-center">{{ session('status') }}</div>
                    @endif

                    <form method="POST" action="{{ route('login') }}" class="space-y-4">
                        @csrf
                        <div class="row g-3">
                            <!-- Email Address -->
                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="email" name="email" class="form-control bg-dark text-light border-secondary @error('email') is-invalid @enderror" 
                                           id="email" value="{{ old('email') }}" required autofocus autocomplete="email" 
                                           placeholder="email@example.com">
                                    <label for="email" class="text-light-emphasis">Email Address</label>
                                </div>
                                @error('email')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="password" name="password" class="form-control bg-dark text-light border-secondary @error('password') is-invalid @enderror" 
                                           id="password" required autocomplete="current-password" 
                                           placeholder="Password">
                                    <label for="password" class="text-light-emphasis">Password</label>
                                </div>
                                @error('password')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Remember Me & Forgot Password -->
                            <div class="col-12 d-flex justify-content-between align-items-center">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label text-light-emphasis" for="remember">
                                        Remember me
                                    </label>
                                </div>
                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" class="text-warning text-decoration-none small">
                                        Forgot your password?
                                    </a>
                                @endif
                            </div>

                            <div class="col-12">
                                <button type="submit" class="btn btn-warning w-100 py-3 fw-semibold">
                                    Log In
                                </button>
                            </div>
                        </div>
                    </form>

                    @if (Route::has('register'))
                        <div class="text-center mt-4">
                            <p class="text-light-emphasis mb-0">
                                Don't have an account? 
                                <a href="{{ route('register') }}" class="text-warning text-decoration-none">Sign up</a>
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 