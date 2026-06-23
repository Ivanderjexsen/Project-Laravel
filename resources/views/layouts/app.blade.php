<!DOCTYPE html>
<html lang="en">

<head>


    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <!-- font poppins -->
     <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap"
      rel="stylesheet">

    <!--font awesome-->
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}"
          rel="stylesheet">

    <link href="{{ asset('css/sb-admin-2.min.css') }}"
          rel="stylesheet">
    
    <link href="{{ asset('css/custom.css') }}"
      rel="stylesheet">
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">

    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    

</head>

<body id="page-top">

    <div id="wrapper">

        {{-- Sidebar --}}
        @include('layouts.sidebar')

        <div id="content-wrapper" class="d-flex flex-column">

            <div id="content">

                {{-- Topbar --}}
                @include('layouts.topbar')

                <div class="container-fluid">

                    @yield('content')

                </div>

            </div>

            {{-- Footer --}}
            @include('layouts.footer')

        </div>

    </div>

    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>

    <!-- SweetAlert Notifikasi -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Notifikasi Success (Toast)
            @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                timer: 3000,
                showConfirmButton: false,
                toast: true,
                position: 'top-end'
            });
            @endif

            // Notifikasi Error (Toast)
            @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: "{{ session('error') }}",
                timer: 5000,
                showConfirmButton: false,
                toast: true,
                position: 'top-end'
            });
            @endif

            // Notifikasi Warning (Toast)
            @if(session('warning'))
            Swal.fire({
                icon: 'warning',
                title: 'Peringatan!',
                text: "{{ session('warning') }}",
                timer: 4000,
                showConfirmButton: false,
                toast: true,
                position: 'top-end'
            });
            @endif
        });

        // Fungsi SweetAlert Konfirmasi Hapus
        function confirmDelete(message, formId) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: message || 'Data yang dihapus tidak dapat dikembalikan!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Submit form jika user klik "Ya, Hapus!"
                    document.getElementById(formId).submit();
                } else {
                    // Tampilkan notifikasi batal (opsional)
                    Swal.fire({
                        icon: 'info',
                        title: 'Dibatalkan',
                        text: 'Penghapusan buku dibatalkan.',
                        timer: 2000,
                        showConfirmButton: false,
                        toast: true,
                        position: 'top-end'
                    });
                }
            });
        }
    </script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

@yield('script')
    @stack('scripts')

</body>

</html>