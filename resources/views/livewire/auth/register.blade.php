<?php

namespace App\Livewire\Auth;

use App\Models\User;
use App\Models\Role;
use App\Models\Address;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;

new #[Layout('layouts.app')] class extends Component {
    #[Validate('required|string|max:255')]
    public string $username = '';

    #[Validate('required|string|max:255')]
    public string $first_name = '';

    #[Validate('required|string|max:255')]
    public string $last_name = '';

    #[Validate('required|string|email|max:255|unique:users')]
    public string $email = '';

    #[Validate('required|date')]
    public string $birthdate = '';

    #[Validate('required|string|min:8|confirmed')]
    public string $password = '';

    public string $password_confirmation = '';

    // Address fields
    #[Validate('required|string|max:255')]
    public string $street = '';

    #[Validate('required|string|max:255')]
    public string $city = '';

    #[Validate('required|string|max:255')]
    public string $state = '';

    #[Validate('required|string|max:20')]
    public string $postal_code = '';

    #[Validate('required|string|max:255')]
    public string $country = '';

    protected $rules = [
        'username' => 'required|min:3|max:20|unique:users',
        'first_name' => 'required|min:2|max:50',
        'last_name' => 'required|min:2|max:50',
        'email' => 'required|email|unique:users',
        'birthdate' => 'required|date|before:-18 years',
        'password' => 'required|min:8|confirmed',
        'street' => 'required|min:5|max:100',
        'city' => 'required|min:2|max:50',
        'state' => 'required|min:2|max:50',
        'postal_code' => 'required|min:4|max:10',
        'country' => 'required|min:2|max:50',
    ];

    /**
     * Handle an incoming registration request.
     */
    public function register()
    {
        try {
            $this->validate();

            $user = User::create([
                'username' => $this->username,
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'name' => $this->first_name . ' ' . $this->last_name,
                'email' => $this->email,
                'birthdate' => $this->birthdate,
                'password' => Hash::make($this->password),
                'email_verified_at' => now(),
            ]);

            // Create address
            $address = Address::create([
                'user_id' => $user->id,
                'street' => $this->street,
                'city' => $this->city,
                'state' => $this->state,
                'postal_code' => $this->postal_code,
                'country' => $this->country,
                'is_default' => true
            ]);

            // Assign customer role
            $customerRole = Role::firstOrCreate(
                ['role_name' => 'customer'],
                ['description' => 'Customer']
            );
            $user->roles()->attach($customerRole->role_id);

            event(new Registered($user));

            Auth::login($user);

            session()->flash('success', 'Welcome to Drunkies! Your account has been created successfully.');
            return redirect()->route('home');

        } catch (\Exception $e) {
            session()->flash('error', 'Registration failed. Please try again.');
            throw $e;
        }
    }

    public function render(): mixed
    {
        return view('livewire.auth.register');
    }
}; ?>

<div>
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

                        <form wire:submit="register" class="space-y-4">
                            <div class="row g-3">
                                <!-- Account Information -->
                                <div class="col-12 mb-3">
                                    <h4 class="text-warning mb-3">Account Information</h4>
                                    <div class="row g-3">
                                        <div class="col-12">
                                            <div class="form-floating">
                                                <input wire:model.live="username" type="text" class="form-control bg-dark text-light border-secondary" 
                                                       id="username" required autofocus autocomplete="username" 
                                                       placeholder="Username">
                                                <label for="username" class="text-light-emphasis">Username</label>
                                            </div>
                                            @error('username') <span class="text-danger small">{{ $message }}</span> @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <input wire:model.live="first_name" type="text" class="form-control bg-dark text-light border-secondary" 
                                                       id="first_name" required autocomplete="given-name" 
                                                       placeholder="First Name">
                                                <label for="first_name" class="text-light-emphasis">First Name</label>
                                            </div>
                                            @error('first_name') <span class="text-danger small">{{ $message }}</span> @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <input wire:model.live="last_name" type="text" class="form-control bg-dark text-light border-secondary" 
                                                       id="last_name" required autocomplete="family-name" 
                                                       placeholder="Last Name">
                                                <label for="last_name" class="text-light-emphasis">Last Name</label>
                                            </div>
                                            @error('last_name') <span class="text-danger small">{{ $message }}</span> @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <input wire:model.live="email" type="email" class="form-control bg-dark text-light border-secondary" 
                                                       id="email" required autocomplete="email" 
                                                       placeholder="email@example.com">
                                                <label for="email" class="text-light-emphasis">Email Address</label>
                                            </div>
                                            @error('email') <span class="text-danger small">{{ $message }}</span> @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <input wire:model.live="birthdate" type="date" class="form-control bg-dark text-light border-secondary" 
                                                       id="birthdate" required 
                                                       placeholder="Birthdate">
                                                <label for="birthdate" class="text-light-emphasis">Birthdate</label>
                                            </div>
                                            @error('birthdate') <span class="text-danger small">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Address Information -->
                                <div class="col-12 mb-3">
                                    <h4 class="text-warning mb-3">Address Information</h4>
                                    <div class="row g-3">
                                        <div class="col-12">
                                            <div class="form-floating">
                                                <input wire:model.live="street" type="text" class="form-control bg-dark text-light border-secondary" 
                                                       id="street" required 
                                                       placeholder="Street Address">
                                                <label for="street" class="text-light-emphasis">Street Address</label>
                                            </div>
                                            @error('street') <span class="text-danger small">{{ $message }}</span> @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <input wire:model.live="city" type="text" class="form-control bg-dark text-light border-secondary" 
                                                       id="city" required 
                                                       placeholder="City">
                                                <label for="city" class="text-light-emphasis">City</label>
                                            </div>
                                            @error('city') <span class="text-danger small">{{ $message }}</span> @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <input wire:model.live="state" type="text" class="form-control bg-dark text-light border-secondary" 
                                                       id="state" required 
                                                       placeholder="State/Province">
                                                <label for="state" class="text-light-emphasis">State/Province</label>
                                            </div>
                                            @error('state') <span class="text-danger small">{{ $message }}</span> @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <input wire:model.live="postal_code" type="text" class="form-control bg-dark text-light border-secondary" 
                                                       id="postal_code" required 
                                                       placeholder="Postal Code">
                                                <label for="postal_code" class="text-light-emphasis">Postal Code</label>
                                            </div>
                                            @error('postal_code') <span class="text-danger small">{{ $message }}</span> @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <input wire:model.live="country" type="text" class="form-control bg-dark text-light border-secondary" 
                                                       id="country" required 
                                                       placeholder="Country">
                                                <label for="country" class="text-light-emphasis">Country</label>
                                            </div>
                                            @error('country') <span class="text-danger small">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Password Section -->
                                <div class="col-12 mb-3">
                                    <h4 class="text-warning mb-3">Security</h4>
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <input wire:model.live="password" type="password" class="form-control bg-dark text-light border-secondary" 
                                                       id="password" required autocomplete="new-password" 
                                                       placeholder="Password">
                                                <label for="password" class="text-light-emphasis">Password</label>
                                            </div>
                                            @error('password') <span class="text-danger small">{{ $message }}</span> @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <input wire:model.live="password_confirmation" type="password" class="form-control bg-dark text-light border-secondary" 
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
</div>
