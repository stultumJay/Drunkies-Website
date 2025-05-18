@extends('layouts.app')

@section('title', 'Profile Settings - Drunkies')

@section('content')
<div class="container py-5">
    <h1 class="mb-4">Profile Settings</h1>

    <div class="row">
        <div class="col-md-3">
            <div class="list-group">
                <a href="#personal-info" class="list-group-item list-group-item-action active" data-bs-toggle="list">
                    Personal Information
                </a>
                <a href="#shipping" class="list-group-item list-group-item-action" data-bs-toggle="list">
                    Shipping Addresses
                </a>
                <a href="#orders" class="list-group-item list-group-item-action" data-bs-toggle="list">
                    Order History
                </a>
                <a href="#preferences" class="list-group-item list-group-item-action" data-bs-toggle="list">
                    Preferences
                </a>
            </div>
        </div>

        <div class="col-md-9">
            <div class="tab-content">
                <!-- Personal Information -->
                <div class="tab-pane fade show active" id="personal-info">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Personal Information</h5>
                            <form action="{{ route('profile.update') }}" method="POST">
                                @csrf
                                @method('PATCH')
                                
                                <div class="mb-3">
                                    <label for="name" class="form-label">Full Name</label>
                                    <input type="text" class="form-control" id="name" name="name" 
                                           value="{{ $user->name }}" required>
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label">Email Address</label>
                                    <input type="email" class="form-control" id="email" name="email" 
                                           value="{{ $user->email }}" required>
                                </div>

                                <div class="mb-3">
                                    <label for="phone" class="form-label">Phone Number</label>
                                    <input type="tel" class="form-control" id="phone" name="phone" 
                                           value="{{ $user->phone }}">
                                </div>

                                <div class="mb-3">
                                    <label for="birthdate" class="form-label">Birthdate</label>
                                    <input type="date" class="form-control" id="birthdate" name="birthdate" 
                                           value="{{ $user->birthdate }}" required>
                                </div>

                                <button type="submit" class="btn btn-primary">Save Changes</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Shipping Addresses -->
                <div class="tab-pane fade" id="shipping">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h5 class="card-title mb-0">Shipping Addresses</h5>
                                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addAddressModal">
                                    Add New Address
                                </button>
                            </div>

                            @foreach($user->addresses ?? [] as $address)
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <h6 class="card-subtitle mb-2 text-muted">{{ $address->label }}</h6>
                                            <div>
                                                <button class="btn btn-link btn-sm text-primary">Edit</button>
                                                <button class="btn btn-link btn-sm text-danger">Delete</button>
                                            </div>
                                        </div>
                                        <p class="card-text">
                                            {{ $address->street }}<br>
                                            {{ $address->city }}, {{ $address->province }}<br>
                                            {{ $address->postal_code }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Order History -->
                <div class="tab-pane fade" id="orders">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Order History</h5>
                            
                            @forelse($user->orders ?? [] as $order)
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h6 class="card-subtitle mb-2">Order #{{ $order->id }}</h6>
                                            <span class="badge bg-{{ $order->status_color }}">
                                                {{ $order->status }}
                                            </span>
                                        </div>
                                        <p class="card-text">
                                            <small class="text-muted">
                                                Ordered on {{ $order->created_at->format('M d, Y') }}
                                            </small>
                                        </p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span>Total: ₱{{ number_format($order->total, 2) }}</span>
                                            <a href="{{ route('orders.show', $order) }}" class="btn btn-sm btn-outline-primary">
                                                View Details
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <p class="text-muted">No orders yet.</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Preferences -->
                <div class="tab-pane fade" id="preferences">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Preferences</h5>
                            <form action="{{ route('profile.preferences') }}" method="POST">
                                @csrf
                                @method('PATCH')

                                <div class="mb-3">
                                    <label class="form-label">Email Notifications</label>
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="orderUpdates" 
                                               name="notifications[]" value="order_updates"
                                               {{ in_array('order_updates', $user->notification_preferences ?? []) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="orderUpdates">
                                            Order Updates
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="promotions" 
                                               name="notifications[]" value="promotions"
                                               {{ in_array('promotions', $user->notification_preferences ?? []) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="promotions">
                                            Promotions and Deals
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="newsletter" 
                                               name="notifications[]" value="newsletter"
                                               {{ in_array('newsletter', $user->notification_preferences ?? []) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="newsletter">
                                            Newsletter
                                        </label>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Preferred Categories</label>
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="lagers" 
                                               name="categories[]" value="lagers"
                                               {{ in_array('lagers', $user->preferred_categories ?? []) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="lagers">Lagers</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="ales" 
                                               name="categories[]" value="ales"
                                               {{ in_array('ales', $user->preferred_categories ?? []) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="ales">Ales</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="craft" 
                                               name="categories[]" value="craft"
                                               {{ in_array('craft', $user->preferred_categories ?? []) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="craft">Craft Beers</label>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary">Save Preferences</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Address Modal -->
<div class="modal fade" id="addAddressModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Address</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('profile.addresses.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="label" class="form-label">Address Label</label>
                        <input type="text" class="form-control" id="label" name="label" required>
                    </div>
                    <div class="mb-3">
                        <label for="street" class="form-label">Street Address</label>
                        <input type="text" class="form-control" id="street" name="street" required>
                    </div>
                    <div class="mb-3">
                        <label for="city" class="form-label">City</label>
                        <input type="text" class="form-control" id="city" name="city" required>
                    </div>
                    <div class="mb-3">
                        <label for="province" class="form-label">Province</label>
                        <input type="text" class="form-control" id="province" name="province" required>
                    </div>
                    <div class="mb-3">
                        <label for="postal_code" class="form-label">Postal Code</label>
                        <input type="text" class="form-control" id="postal_code" name="postal_code" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Save Address</button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle tab switching via URL hash
    let hash = window.location.hash;
    if (hash) {
        let tab = document.querySelector(`[href="${hash}"]`);
        if (tab) {
            let bsTab = new bootstrap.Tab(tab);
            bsTab.show();
        }
    }

    // Update URL hash when tabs are switched
    let tabEls = document.querySelectorAll('a[data-bs-toggle="list"]');
    tabEls.forEach(tabEl => {
        tabEl.addEventListener('shown.bs.tab', function (event) {
            window.location.hash = event.target.getAttribute('href');
        });
    });
});
</script>
@endpush
@endsection 