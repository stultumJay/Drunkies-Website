<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Drunkies')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        main {
            flex: 1 0 auto;
            margin-top: 76px;
        }
        .navbar {
            position: fixed;
            top: 0;
            right: 0;
            left: 0;
            z-index: 1030;
        }
        .toast-container {
            z-index: 9999;
        }
        .toast {
            min-width: 300px;
        }
        .toast-body {
            font-size: 0.95rem;
        }
        .product-card {
            transition: transform 0.2s;
        }
        .product-card:hover {
            transform: translateY(-5px);
        }
        .product-card img {
            height: 200px;
            object-fit: cover;
        }
    </style>
    @stack('styles')
</head>
<body class="bg-light">
    @include('partials.navbar')
    
    <main>
        @yield('content')
    </main>

    @include('partials.footer')

    <!-- Toast Container -->
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="userToast" class="toast align-items-center text-white border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    <i class="fas fa-info-circle me-2"></i>
                    <span id="toastMessage">Placeholder</span>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
        // Toast Function
        function showToast(message, type = 'info') {
            const toast = new bootstrap.Toast(document.getElementById('userToast'));
            const toastElement = $('#userToast');
            const messageElement = $('#toastMessage');
            
            let bgColor = 'bg-primary';
            let icon = 'fa-info-circle';
            
            if (type === 'success') {
                bgColor = 'bg-success';
                icon = 'fa-check-circle';
            } else if (type === 'error') {
                bgColor = 'bg-danger';
                icon = 'fa-exclamation-circle';
            } else if (type === 'warning') {
                bgColor = 'bg-warning text-dark';
                icon = 'fa-exclamation-triangle';
            }
            
            toastElement.removeClass('bg-primary bg-success bg-danger bg-warning text-dark')
                .addClass(bgColor);
            messageElement.html(`<i class="fas ${icon} me-2"></i>${message}`);
            
            toast.show();
        }

        // Handle Flash Messages
        $(document).ready(function() {
            @if(session('success'))
                showToast('{{ session('success') }}', 'success');
            @endif

            @if(session('error'))
                showToast('{{ session('error') }}', 'error');
            @endif

            @if(session('warning'))
                showToast('{{ session('warning') }}', 'warning');
            @endif
        });

        // AJAX Setup
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    @stack('scripts')
</body>
</html> 