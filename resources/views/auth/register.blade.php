@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card bg-dark text-light shadow">
                <div class="card-body p-4">
                    <div class="text-center mb-4">
                        <img src="{{ asset('storage/images/logo/drunkies.png') }}" 
                             alt="Drunkies Logo" 
                             class="mb-3" 
                             style="height: 80px; width: 80px; object-fit: contain;"
                             onerror="this.onerror=null; this.src='{{ asset('storage/images/placeholder.jpg') }}';">
                        <h2 class="fw-bold text-warning mb-2">Create an Account</h2>
                        <p class="text-light-emphasis">Join Drunkies and start shopping for your favorite drinks</p>
                    </div>

                    <form method="POST" action="{{ route('register') }}" class="space-y-4">
                        @csrf
                        <div class="row g-3">
                            <!-- Account Information -->
                            <div class="col-12 mb-3">
                                <h4 class="text-warning mb-3">Account Information</h4>
                                <div class="row g-3">
                                    <div class="col-12">
                                        <div class="form-floating">
                                            <input type="text" name="username" class="form-control bg-dark text-light border-secondary @error('username') is-invalid @enderror" 
                                                   id="username" value="{{ old('username') }}" required autofocus autocomplete="username" 
                                                   placeholder="Username">
                                            <label for="username" class="text-light-emphasis">Username</label>
                                        </div>
                                        @error('username')
                                            <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" name="first_name" class="form-control bg-dark text-light border-secondary @error('first_name') is-invalid @enderror" 
                                                   id="first_name" value="{{ old('first_name') }}" required autocomplete="given-name" 
                                                   placeholder="First Name">
                                            <label for="first_name" class="text-light-emphasis">First Name</label>
                                        </div>
                                        @error('first_name')
                                            <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" name="last_name" class="form-control bg-dark text-light border-secondary @error('last_name') is-invalid @enderror" 
                                                   id="last_name" value="{{ old('last_name') }}" required autocomplete="family-name" 
                                                   placeholder="Last Name">
                                            <label for="last_name" class="text-light-emphasis">Last Name</label>
                                        </div>
                                        @error('last_name')
                                            <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="email" name="email" class="form-control bg-dark text-light border-secondary @error('email') is-invalid @enderror" 
                                                   id="email" value="{{ old('email') }}" required autocomplete="email" 
                                                   placeholder="email@example.com">
                                            <label for="email" class="text-light-emphasis">Email Address</label>
                                        </div>
                                        @error('email')
                                            <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="date" name="birthdate" class="form-control bg-dark text-light border-secondary @error('birthdate') is-invalid @enderror" 
                                                   id="birthdate" value="{{ old('birthdate') }}" required 
                                                   placeholder="Birthdate">
                                            <label for="birthdate" class="text-light-emphasis">Birthdate</label>
                                        </div>
                                        @error('birthdate')
                                            <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Address Information -->
                            <div class="col-12 mb-3">
                                <h4 class="text-warning mb-3">Address Information</h4>
                                <div class="row g-3">
                                    <div class="col-12">
                                        <div class="form-floating">
                                            <input type="text" name="street" class="form-control bg-dark text-light border-secondary @error('street') is-invalid @enderror" 
                                                   id="street" value="{{ old('street') }}" required 
                                                   placeholder="Street Address">
                                            <label for="street" class="text-light-emphasis">Street Address</label>
                                        </div>
                                        @error('street')
                                            <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" name="city" class="form-control bg-dark text-light border-secondary @error('city') is-invalid @enderror" 
                                                   id="city" value="{{ old('city') }}" required 
                                                   placeholder="City">
                                            <label for="city" class="text-light-emphasis">City</label>
                                        </div>
                                        @error('city')
                                            <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" name="state" class="form-control bg-dark text-light border-secondary @error('state') is-invalid @enderror" 
                                                   id="state" value="{{ old('state') }}" required 
                                                   placeholder="State/Province">
                                            <label for="state" class="text-light-emphasis">State/Province</label>
                                        </div>
                                        @error('state')
                                            <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" name="postal_code" class="form-control bg-dark text-light border-secondary @error('postal_code') is-invalid @enderror" 
                                                   id="postal_code" value="{{ old('postal_code') }}" required 
                                                   placeholder="Postal Code">
                                            <label for="postal_code" class="text-light-emphasis">Postal Code</label>
                                        </div>
                                        @error('postal_code')
                                            <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" name="country" class="form-control bg-dark text-light border-secondary @error('country') is-invalid @enderror" 
                                                   id="country" value="{{ old('country') }}" required 
                                                   placeholder="Country">
                                            <label for="country" class="text-light-emphasis">Country</label>
                                        </div>
                                        @error('country')
                                            <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Password Section -->
                            <div class="col-12 mb-3">
                                <h4 class="text-warning mb-3">Security</h4>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="password" name="password" class="form-control bg-dark text-light border-secondary @error('password') is-invalid @enderror" 
                                                   id="password" required autocomplete="new-password" 
                                                   placeholder="Password">
                                            <label for="password" class="text-light-emphasis">Password</label>
                                        </div>
                                        @error('password')
                                            <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="password" name="password_confirmation" class="form-control bg-dark text-light border-secondary" 
                                                   id="password_confirmation" required autocomplete="new-password" 
                                                   placeholder="Confirm Password">
                                            <label for="password_confirmation" class="text-light-emphasis">Confirm Password</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <button type="submit" class="btn btn-warning w-100 py-3 fw-semibold">
                                    Create Account
                                </button>
                            </div>
                        </div>
                    </form>

                    <div class="text-center mt-4">
                        <p class="text-light-emphasis mb-0">
                            Already have an account? 
                            <a href="{{ route('login') }}" class="text-warning text-decoration-none">Log in</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 