<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'LIBRARY MINI')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- SB Admin 2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/startbootstrap-sb-admin-2@4.1.4/css/sb-admin-2.min.css" rel="stylesheet">

    @stack('styles')
</head>

<body id="page-top">

    <div id="wrapper">

        <!-- Sidebar -->
        @include('layouts.sidebar')

        <div id="content-wrapper" class="d-flex flex-column">

            <div id="content">

                <!-- Topbar -->
                @include('layouts.topbar')

                <!-- Main Content -->
                <div class="container-fluid">
                    @yield('content')
                </div>

            </div>

            <!-- Footer -->
            @include('layouts.footer')

        </div>

    </div>

    <!-- ========================================== -->
    <!-- JAVASCRIPT (WAJIB UNTUK DROPDOWN)          -->
    <!-- ========================================== -->
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap Bundle JS (dengan Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- SB Admin 2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/startbootstrap-sb-admin-2@4.1.4/js/sb-admin-2.min.js"></script>

    <!-- ========================================== -->
    <!-- SCRIPT UNTUK DROPDOWN (MANUAL)             -->
    <!-- ========================================== -->
    <script>
        $(document).ready(function() {
            // Inisialisasi dropdown manual
            $('.dropdown-toggle').dropdown();

            // Atau jika pakai data-toggle
            $('[data-toggle="dropdown"]').on('click', function(e) {
                e.preventDefault();
                var $dropdown = $(this).next('.dropdown-menu');
                $dropdown.toggleClass('show');
                $(this).attr('aria-expanded', $dropdown.hasClass('show'));
            });
        });

        // Alternatif: Pakai vanilla JS
        document.addEventListener('DOMContentLoaded', function() {
            var dropdownToggles = document.querySelectorAll('[data-toggle="dropdown"]');
            dropdownToggles.forEach(function(toggle) {
                toggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    var menu = this.nextElementSibling;
                    if (menu.classList.contains('show')) {
                        menu.classList.remove('show');
                        this.setAttribute('aria-expanded', 'false');
                    } else {
                        menu.classList.add('show');
                        this.setAttribute('aria-expanded', 'true');
                    }
                });
            });
        });
    </script>

    @stack('scripts')
</body>

</html>