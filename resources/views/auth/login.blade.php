@extends('layouts.guest')

@section('title','Login')

@section('content')

<!-- Bola Background -->
<div class="circle circle1"></div>
<div class="circle circle2"></div>
<div class="circle circle3"></div>
<div class="circle circle4"></div>

<div class="container d-flex justify-content-center align-items-center"
     style="min-height:100vh;">

    <div class="auth-card">

        <!-- Logo -->
        <div class="text-center mb-4">

            <i class="fas fa-book-open"
               style="
               font-size:80px;
               color:#5eead4;
               text-shadow:0 0 20px #5eead4;
               ">
            </i>

        </div>

        <!-- Judul -->
        <h1 class="auth-title text-center">
            LIBRARY MINI
        </h1>

        <p class="auth-subtitle text-center">
            Sistem Manajemen Perpustakaan Digital
        </p>

        <!-- Form Login -->
        <form method="POST"
              action="{{ route('login') }}">

            @csrf

            <div class="form-group mb-4">

                <label class="auth-label">
                    Email
                </label>

                <input type="email"
                       name="email"
                       class="form-control form-control-user"
                       placeholder="Masukkan email"
                       required>

            </div>

            <div class="form-group mb-5">

                <label class="auth-label">
                    Password
                </label>

                <input type="password"
                       name="password"
                       class="form-control form-control-user"
                       placeholder="Masukkan password"
                       required>

            </div>

            <button type="submit"
                    class="btn btn-login btn-block">

                <i class="fas fa-sign-in-alt"></i>

                Login

            </button>

        </form>

        <hr style="border-color:rgba(255,255,255,.2);">

        <!-- Link Register -->
        <div class="text-center">

            <span class="text-light">

                Belum punya akun?

            </span>

            <a href="{{ route('register') }}"
               class="auth-link">

                Register

            </a>

        </div>

    </div>

</div>

@endsection