@extends('layouts.admin')

@section('title', 'Promotions Management')
@section('header-title', 'Promotions')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <h1 class="h3 mb-0">Promotions Management</h1>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPromoModal">
                <i class="fas fa-plus me-1"></i> Add New Promotion
            </button>
        </div>
    </div>

    <!-- Carousel Banner Management -->
    <div class="card mb-4">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Carousel Banners</h5>
            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addBannerModal">
                <i class="fas fa-plus me-1"></i> Add Banner
            </button>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <img src="https://placehold.co/500x200/FFD600/222?text=Banner+1" class="card-img-top" alt="Banner 1">
                        <div class="card-body">
                            <h6 class="card-title">Summer Sale Banner</h6>
                            <p class="card-text small text-muted">Active: Apr 15 - May 15, 2023</p>
                            <div class="d-flex justify-content-between">
                                <button class="btn btn-sm btn-warning">Edit</button>
                                <button class="btn btn-sm btn-danger">Remove</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <img src="https://placehold.co/500x200/1976D2/fff?text=Banner+2" class="card-img-top" alt="Banner 2">
                        <div class="card-body">
                            <h6 class="card-title">New Arrivals Banner</h6>
                            <p class="card-text small text-muted">Active: Apr 1 - Dec 31, 2023</p>
                            <div class="d-flex justify-content-between">
                                <button class="btn btn-sm btn-warning">Edit</button>
                                <button class="btn btn-sm btn-danger">Remove</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <img src="https://placehold.co/500x200/FF1744/fff?text=Banner+3" class="card-img-top" alt="Banner 3">
                        <div class="card-body">
                            <h6 class="card-title">Special Offers Banner</h6>
                            <p class="card-text small text-muted">Active: May 1 - May 31, 2023</p>
                            <div class="d-flex justify-content-between">
                                <button class="btn btn-sm btn-warning">Edit</button>
                                <button class="btn btn-sm btn-danger">Remove</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Discount Codes -->
    <div class="card">
        <div class="card-header bg-white">
            <h5 class="mb-0">Discount Codes</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>Code</th>
                            <th>Discount</th>
                            <th>Type</th>
                            <th>Min. Purchase</th>
                            <th>Valid From</th>
                            <th>Valid To</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>SUMMER10</strong></td>
                            <td>10%</td>
                            <td>Percentage</td>
                            <td>₱1,000</td>
                            <td>Apr 15, 2023</td>
                            <td>May 15, 2023</td>
                            <td><span class="badge bg-success">Active</span></td>
                            <td>
                                <div class="btn-group">
                                    <button class="btn btn-sm btn-warning">Edit</button>
                                    <button class="btn btn-sm btn-danger">Disable</button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>WELCOME50</strong></td>
                            <td>₱50</td>
                            <td>Fixed Amount</td>
                            <td>₱500</td>
                            <td>Jan 1, 2023</td>
                            <td>Dec 31, 2023</td>
                            <td><span class="badge bg-success">Active</span></td>
                            <td>
                                <div class="btn-group">
                                    <button class="btn btn-sm btn-warning">Edit</button>
                                    <button class="btn btn-sm btn-danger">Disable</button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>FLASH25</strong></td>
                            <td>25%</td>
                            <td>Percentage</td>
                            <td>₱1,500</td>
                            <td>Mar 1, 2023</td>
                            <td>Mar 15, 2023</td>
                            <td><span class="badge bg-secondary">Expired</span></td>
                            <td>
                                <div class="btn-group">
                                    <button class="btn btn-sm btn-warning">Edit</button>
                                    <button class="btn btn-sm btn-success">Reactivate</button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Add Banner Modal -->
<div class="modal fade" id="addBannerModal" tabindex="-1" aria-labelledby="addBannerModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addBannerModalLabel">Add Carousel Banner</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label for="bannerTitle" class="form-label">Banner Title</label>
                        <input type="text" class="form-control" id="bannerTitle" required>
                    </div>
                    <div class="mb-3">
                        <label for="bannerImage" class="form-label">Banner Image</label>
                        <input type="file" class="form-control" id="bannerImage" accept="image/*" required>
                        <div class="form-text">Recommended size: 1200x400px. Max file size: 2MB</div>
                    </div>
                    <div class="mb-3">
                        <label for="bannerLink" class="form-label">Link URL</label>
                        <input type="url" class="form-control" id="bannerLink" placeholder="https://">
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="validFrom" class="form-label">Valid From</label>
                            <input type="date" class="form-control" id="validFrom" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="validTo" class="form-label">Valid To</label>
                            <input type="date" class="form-control" id="validTo" required>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary">Add Banner</button>
            </div>
        </div>
    </div>
</div>

<!-- Add Promo Modal -->
<div class="modal fade" id="addPromoModal" tabindex="-1" aria-labelledby="addPromoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addPromoModalLabel">Add Discount Code</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label for="promoCode" class="form-label">Discount Code</label>
                        <input type="text" class="form-control" id="promoCode" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="discountType" class="form-label">Discount Type</label>
                            <select class="form-select" id="discountType" required>
                                <option value="percentage">Percentage</option>
                                <option value="fixed">Fixed Amount</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="discountValue" class="form-label">Discount Value</label>
                            <div class="input-group">
                                <input type="number" class="form-control" id="discountValue" required>
                                <span class="input-group-text" id="discountSymbol">%</span>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="minPurchase" class="form-label">Minimum Purchase (₱)</label>
                        <input type="number" class="form-control" id="minPurchase" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="promoValidFrom" class="form-label">Valid From</label>
                            <input type="date" class="form-control" id="promoValidFrom" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="promoValidTo" class="form-label">Valid To</label>
                            <input type="date" class="form-control" id="promoValidTo" required>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary">Create Discount</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Change the discount symbol based on the selected discount type
    document.getElementById('discountType').addEventListener('change', function() {
        const symbol = this.value === 'percentage' ? '%' : '₱';
        document.getElementById('discountSymbol').textContent = symbol;
    });
</script>
@endpush 