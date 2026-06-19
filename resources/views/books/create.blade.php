@extends('layouts.app')

@section('title', 'Tambah Buku')

@section('content')

<h1 class="h3 mb-4 text-gray-800">
    <i class="fas fa-plus-circle me-2"></i>Tambah Buku
</h1>

<div class="card shadow">
    <div class="card-body">
        <!-- Informasi Kode Buku Otomatis -->
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <div class="d-flex align-items-center">
                <i class="fas fa-info-circle fa-2x me-3"></i>
                <div>
                    <strong><i class="fas fa-tag me-1"></i> Kode Buku Otomatis</strong><br>
                    Kode buku akan dibuat otomatis oleh sistem dengan format:
                    <code class="fw-bold">B-YYYYMM-XXX</code>
                    <small class="d-block text-muted mt-1">
                        <i class="fas fa-clock me-1"></i> Contoh: B-202406-001 (untuk buku pertama di bulan Juni 2024)
                    </small>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>

        <!-- Alert Peringatan Duplikat -->
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <div class="d-flex align-items-center">
                <i class="fas fa-exclamation-triangle fa-2x me-3"></i>
                <div>
                    <strong><i class="fas fa-exclamation-circle me-1"></i> Perhatian!</strong><br>
                    <small>
                        Sistem tidak akan mengizinkan penambahan buku dengan
                        <strong>judul, pengarang, dan penerbit</strong> yang sama.
                        Pastikan data buku yang Anda masukkan belum pernah ditambahkan sebelumnya.
                    </small>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>

        <!-- Form -->
        <form action="{{ route('buku.store') }}" method="POST">
            @csrf

            <!-- Judul Buku -->
            <div class="form-group mb-3">
                <label for="judul_buku" class="fw-bold">
                    <i class="fas fa-book me-1"></i> Judul Buku <span class="text-danger">*</span>
                </label>
                <input
                    type="text"
                    name="judul_buku"
                    id="judul_buku"
                    class="form-control @error('judul_buku') is-invalid @enderror"
                    value="{{ old('judul_buku') }}"
                    placeholder="Masukkan judul buku"
                    required>
                @error('judul_buku')
                <div class="invalid-feedback">
                    <i class="fas fa-exclamation-circle me-1"></i> {{ $message }}
                </div>
                @enderror
            </div>

            <!-- Pengarang -->
            <div class="form-group mb-3">
                <label for="pengarang" class="fw-bold">
                    <i class="fas fa-user me-1"></i> Pengarang <span class="text-danger">*</span>
                </label>
                <input
                    type="text"
                    name="pengarang"
                    id="pengarang"
                    class="form-control @error('pengarang') is-invalid @enderror"
                    value="{{ old('pengarang') }}"
                    placeholder="Masukkan nama pengarang"
                    required>
                @error('pengarang')
                <div class="invalid-feedback">
                    <i class="fas fa-exclamation-circle me-1"></i> {{ $message }}
                </div>
                @enderror
            </div>

            <!-- Penerbit -->
            <div class="form-group mb-3">
                <label for="penerbit" class="fw-bold">
                    <i class="fas fa-building me-1"></i> Penerbit <span class="text-danger">*</span>
                </label>
                <input
                    type="text"
                    name="penerbit"
                    id="penerbit"
                    class="form-control @error('penerbit') is-invalid @enderror"
                    value="{{ old('penerbit') }}"
                    placeholder="Masukkan nama penerbit"
                    required>
                @error('penerbit')
                <div class="invalid-feedback">
                    <i class="fas fa-exclamation-circle me-1"></i> {{ $message }}
                </div>
                @enderror
            </div>

            <!-- Stok -->
            <div class="form-group mb-4">
                <label for="stok" class="fw-bold">
                    <i class="fas fa-boxes me-1"></i> Stok <span class="text-danger">*</span>
                </label>
                <input
                    type="number"
                    name="stok"
                    id="stok"
                    class="form-control @error('stok') is-invalid @enderror"
                    value="{{ old('stok', 0) }}"
                    placeholder="Masukkan jumlah stok"
                    min="0"
                    required>
                @error('stok')
                <div class="invalid-feedback">
                    <i class="fas fa-exclamation-circle me-1"></i> {{ $message }}
                </div>
                @enderror
                <small class="text-muted">
                    <i class="fas fa-info-circle me-1"></i> Stok minimal 0
                </small>
            </div>

            <!-- Tombol -->
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i> Simpan
                </button>
                <a href="{{ route('buku.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
            </div>

        </form>
    </div>
</div>

@endsection