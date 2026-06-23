@extends('layouts.guest')

@section('title', 'Verifikasi OTP')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-primary text-white text-center py-3">
                    <h4 class="mb-0">
                        <i class="fas fa-shield-alt me-2"></i> Verifikasi Email
                    </h4>
                </div>
                <div class="card-body p-4 text-center">

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
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

                    <h5 class="mb-3">Masukkan Kode Verifikasi</h5>

                    <p class="text-muted mb-3">
                        Kami telah mengirimkan kode OTP 6 digit ke alamat email Anda.
                        <br>
                        <strong>{{ Auth::user()->email ?? '' }}</strong>
                    </p>

                    <form action="{{ route('otp.verify') }}" method="POST">
                        @csrf

                        <div class="row justify-content-center g-2 mb-3">
                            @for($i = 1; $i <= 6; $i++)
                            <div class="col-2">
                                <input type="text"
                                       name="otp"
                                       id="otp_{{ $i }}"
                                       class="form-control text-center otp-input"
                                       maxlength="1"
                                       pattern="[0-9]"
                                       inputmode="numeric"
                                       style="font-size: 24px; height: 60px;"
                                       required>
                            </div>
                            @endfor
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-2 fw-bold">
                            <i class="fas fa-check me-2"></i> Verifikasi
                        </button>
                    </form>

                    <div class="mt-3">
                        <form action="{{ route('otp.resend') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-link text-muted">
                                <i class="fas fa-redo me-1"></i> Kirim Ulang Kode
                            </button>
                        </form>
                    </div>

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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const inputs = document.querySelectorAll('.otp-input');

        inputs.forEach((input, index) => {
            input.addEventListener('input', function() {
                if (this.value.length === 1 && index < inputs.length - 1) {
                    inputs[index + 1].focus();
                }
            });


            
            input.addEventListener('keydown', function(e) {
                if (e.key === 'Backspace' && this.value.length === 0 && index > 0) {
                    inputs[index - 1].focus();
                }
            });

            input.addEventListener('keypress', function(e) {
                if (!/[0-9]/.test(e.key)) {
                    e.preventDefault();
                }
            });
        });
    });
</script>
@endsection