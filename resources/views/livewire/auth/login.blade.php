<?php

namespace App\Livewire\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;

new #[Layout('layouts.app')] class extends Component {
    #[Validate('required|string|email')]
    public string $email = '';

    #[Validate('required|string')]
    public string $password = '';

    public bool $remember = false;

    /**
     * Handle an incoming authentication request.
     */
    public function login()
    {
        try {
            $this->validate();

            if (!Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
                throw ValidationException::withMessages([
                    'email' => [trans('auth.failed')],
                ]);
            }

            $user = Auth::user();

            if ($user->hasRole('admin')) {
                session()->flash('success', 'Welcome back, Admin!');
                return redirect()->route('admin.dashboard');
            }

            session()->flash('success', 'Welcome back, ' . $user->first_name . '!');
            return redirect()->intended(route('home'));

        } catch (ValidationException $e) {
            session()->flash('error', 'Invalid email or password.');
            throw $e;
        } catch (\Exception $e) {
            session()->flash('error', 'An error occurred during login. Please try again.');
            throw $e;
        }
    }

    /**
     * Get the authentication rate limiting throttle key.
     */
    protected function throttleKey(): string
    {
        return strtolower($this->email) . '|' . request()->ip();
    }

    public function render(): mixed
    {
        return view('livewire.auth.login');
    }
}; ?>

<div>
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

                        <!-- Session Status -->
                        @if (session('status'))
                            <div class="alert alert-info text-center">{{ session('status') }}</div>
                        @endif

                        <form wire:submit="login" class="space-y-4">
                            <div class="row g-3">
                                <!-- Email Address -->
                                <div class="col-12">
                                    <div class="form-floating">
                                        <input wire:model.live="email" type="email" class="form-control bg-dark text-light border-secondary" 
                                               id="email" required autofocus autocomplete="email" 
                                               placeholder="email@example.com">
                                        <label for="email" class="text-light-emphasis">Email Address</label>
                                    </div>
                                    @error('email') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>

                                <!-- Password -->
                                <div class="col-12">
                                    <div class="form-floating">
                                        <input wire:model.live="password" type="password" class="form-control bg-dark text-light border-secondary" 
                                               id="password" required autocomplete="current-password" 
                                               placeholder="Password">
                                        <label for="password" class="text-light-emphasis">Password</label>
                                    </div>
                                    @error('password') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>

                                <!-- Remember Me & Forgot Password -->
                                <div class="col-12 d-flex justify-content-between align-items-center">
                                    <div class="form-check">
                                        <input wire:model.live="remember" class="form-check-input" type="checkbox" id="remember">
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
</div>
