@extends('layouts.app')

@section('title', 'Dashboard User')

@section('content')

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-tachometer-alt me-2"></i>Dashboard User
    </h1>
    <span class="text-muted small">
        <i class="fas fa-user me-1"></i> {{ Auth::user()->name }}
    </span>
</div>

<!-- Content Row -->
<div class="row">

    <!-- Total Buku -->
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            <i class="fas fa-book me-1"></i> Total Buku
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $totalBuku }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-book fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Buku Tersedia -->
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            <i class="fas fa-check me-1"></i> Buku Tersedia
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $totalTersedia }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Buku Sedang Dipinjam -->
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            <i class="fas fa-handshake me-1"></i> Sedang Dipinjam
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $totalDipinjam }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-handshake fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Info Tambahan -->
<div class="row">
    <div class="col-lg-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-info-circle me-2"></i> Informasi Perpustakaan
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="text-center">
                            <h5 class="text-primary">{{ $totalBuku }}</h5>
                            <small class="text-muted">Total Koleksi Buku</small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-center">
                            <h5 class="text-success">{{ $totalTersedia }}</h5>
                            <small class="text-muted">Buku Tersedia untuk Dipinjam</small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-center">
                            <h5 class="text-warning">{{ $totalDipinjam }}</h5>
                            <small class="text-muted">Buku Sedang Dipinjam</small>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="text-center">
                    <a href="{{ route('user.buku.index') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-book me-1"></i> Lihat Data Buku
                    </a>
                    <a href="{{ route('user.loans.create') }}" class="btn btn-success btn-sm">
                        <i class="fas fa-handshake me-1"></i> Pinjam Buku
                    </a>
                    <a href="{{ route('user.loans.index') }}" class="btn btn-info btn-sm">
                        <i class="fas fa-clock me-1"></i> Histori Peminjaman
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection