<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <title>@yield('title')</title>

    <link rel="preconnect"
      href="https://fonts.googleapis.com">

    <link rel="preconnect"
      href="https://fonts.googleapis.com">

      <link rel="preconnect"
      href="https://fonts.gstatic.com"
      crossorigin>

      <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap"
      rel="stylesheet">

      <link href="{{ asset('css/custom.css') }}"
      rel="stylesheet">

    <link rel="preconnect"href="https://fonts.gstatic.com"
      crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
      rel="stylesheet">

    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}"
          rel="stylesheet">

    <link href="{{ asset('css/sb-admin-2.min.css') }}"
          rel="stylesheet">

</head>

<body>

    <div class="circle circle1"></div>
    <div class="circle circle2"></div>
    <div class="circle circle3"></div>
    <div class="circle circle4"></div>

    <div class="auth-container">
        @yield('content')
    </div>

<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('js/sb-admin-2.min.js') }}"></script>

</body>
</html>