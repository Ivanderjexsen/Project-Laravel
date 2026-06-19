<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1">

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

@yield('script')

</body>
</html>