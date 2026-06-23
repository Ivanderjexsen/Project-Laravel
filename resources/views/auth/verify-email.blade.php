@extends('layouts.guest')

@section('title', 'Verifikasi Email')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-primary text-white text-center py-3">
                    <h4 class="mb-0">
                        <i class="fas fa-envelope me-2"></i> Verifikasi Email
                    </h4>
                </div>
                <div class="card-body p-4 text-center">

                    @if(session('message'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i> {{ session('message') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="mb-4">
                        <i class="fas fa-envelope-open-text fa-4x text-primary"></i>
                    </div>

                    <h5 class="mb-3">Verifikasi Alamat Email Anda</h5>

                    <p class="text-muted mb-4">
                        Kami telah mengirimkan link verifikasi ke alamat email Anda.
                        <br>
                        <strong>{{ Auth::user()->email ?? '' }}</strong>
                        <br>
                        <small class="text-muted">Silakan cek inbox atau folder spam Anda.</small>
                    </p>

                    <p class="text-muted mb-4">
                        Jika Anda tidak menerima email, klik tombol di bawah untuk mengirim ulang.
                    </p>

                    <form action="{{ route('verification.send') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-redo me-2"></i> Kirim Ulang Link Verifikasi
                        </button>
                    </form>

                    <div class="mt-4">
                        <a href="{{ route('logout') }}"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                           class="text-muted text-decoration-none">
                            <i class="fas fa-sign-out-alt me-1"></i> Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection