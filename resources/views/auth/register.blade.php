@extends('layouts.guest')

@section('title','Register')

@section('content')

<div class="auth-card">

    <div class="text-center mb-4">

        <i class="fas fa-user-plus auth-logo"></i>

        <h1 class="auth-title">
            REGISTER
        </h1>

        <p class="auth-subtitle">
            Buat akun baru untuk menggunakan Library Mini
        </p>

    </div>

    <form method="POST" action="{{ route('register') }}">

        @csrf

        <div class="form-group mb-3">

            <label class="auth-label">
                Nama Lengkap
            </label>

            <input
                type="text"
                name="name"
                class="form-control form-control-user"
                placeholder="Masukkan nama lengkap"
                required>

        </div>


        <div class="form-group mb-3">

            <label class="auth-label">
                Email
            </label>

            <input
                type="email"
                name="email"
                class="form-control form-control-user"
                placeholder="Masukkan email"
                required>

        </div>


        <div class="form-group mb-3">

            <label class="auth-label">
                Password
            </label>

            <input
                type="password"
                name="password"
                class="form-control form-control-user"
                placeholder="Masukkan password"
                required>

        </div>


        <div class="form-group mb-4">

            <label class="auth-label">
                Konfirmasi Password
            </label>

            <input
                type="password"
                name="password_confirmation"
                class="form-control form-control-user"
                placeholder="Ulangi password"
                required>

        </div>


        <button type="submit" class="btn btn-register btn-block">

            <i class="fas fa-user-plus"></i>
            Register

        </button>

    </form>


    <div class="text-center mt-4">

        <span class="auth-link">
            Sudah punya akun?
        </span>

        <a href="{{ route('login') }}" class="auth-link">

            Login

        </a>

    </div>

</div>

@endsection