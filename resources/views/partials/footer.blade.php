<footer class="footer mt-5 bg-dark text-light pt-5 pb-3">
    <div class="container">
        <div class="row g-4">
            <!-- Logo -->
            <div class="col-12 col-md-3 text-center text-md-start mb-4">
                <img src="{{ asset('storage/images/logo/drunkies.png') }}" alt="Drunkies Logo" style="height: 120px; width: 120px; object-fit: contain;" class="mb-3" onerror="this.onerror=null; this.src='{{ asset('storage/images/placeholder.jpg') }}';">
                <h4 class="text-warning fw-bold mb-2">DRUNKIES</h4>
                <p class="text-light-emphasis mb-0">Your premier destination for Philippine craft and commercial beers.</p>
            </div>
            <!-- Quick Links -->
            <div class="col-6 col-md-3">
                <h5 class="fw-bold text-warning mb-3">QUICK LINKS</h5>
                <div class="d-flex flex-column gap-2">
                    <a href="{{ route('about') }}" class="text-light text-decoration-none hover-warning">About Us</a>
                    <a href="{{ route('brands.index') }}" class="text-light text-decoration-none hover-warning">Our Brands</a>
                    <a href="{{ route('categories.index') }}" class="text-light text-decoration-none hover-warning">Beer Categories</a>
                    <a href="{{ route('terms') }}" class="text-light text-decoration-none hover-warning">Terms of Service</a>
                </div>
            </div>
            <!-- Contact Info -->
            <div class="col-6 col-md-3">
                <h5 class="fw-bold text-warning mb-3">CONTACT US</h5>
                <div class="d-flex flex-column gap-2">
                    <div class="d-flex align-items-center gap-2">
                        <i class="fas fa-envelope text-warning"></i>
                        <span>drunkies.customerservice@gmail.com</span>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <i class="fas fa-phone text-warning"></i>
                        <span>+63 12 345 67 89</span>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <i class="fas fa-map-marker-alt text-warning"></i>
                        <span>Xavier University – Ateneo de Cagayan<br>Corrales Avenue, CDO 9000</span>
                    </div>
                </div>
            </div>
            <!-- Social Media -->
            <div class="col-12 col-md-3">
                <h5 class="fw-bold text-warning mb-3">FOLLOW US</h5>
                <div class="d-flex flex-column gap-3">
                    <a href="#" class="text-light text-decoration-none d-flex align-items-center gap-3 hover-warning">
                        <i class="fab fa-facebook fa-lg text-warning"></i>
                        <span>Facebook</span>
                    </a>
                    <a href="#" class="text-light text-decoration-none d-flex align-items-center gap-3 hover-warning">
                        <i class="fab fa-instagram fa-lg text-warning"></i>
                        <span>Instagram</span>
                    </a>
                    <a href="#" class="text-light text-decoration-none d-flex align-items-center gap-3 hover-warning">
                        <i class="fab fa-linkedin fa-lg text-warning"></i>
                        <span>LinkedIn</span>
                    </a>
                </div>
            </div>
        </div>
        <hr class="border-secondary mt-4">
        <div class="text-center text-light-emphasis mt-3">
            <small class="fw-semibold">COPYRIGHT &copy; 2025 DRUNKIES. ALL RIGHTS RESERVED.</small>
        </div>
    </div>
</footer> 