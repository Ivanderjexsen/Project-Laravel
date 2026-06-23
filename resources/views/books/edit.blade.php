@extends('layouts.app')

@section('title', 'Edit Buku')

@section('content')

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-edit me-2"></i>Edit Buku
    </h1>
    <a href="{{ route('buku.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
        <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
    </a>
</div>

<!-- Content Row -->
<div class="row">
    <div class="col-lg-8 mx-auto">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-edit me-1"></i> Form Edit Buku
                </h6>
            </div>
            <div class="card-body">
                <!-- Peringatan Duplikat -->
                <div class="alert alert-warning">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-exclamation-triangle fa-2x me-3"></i>
                        <div>
                            <strong>Perhatian!</strong><br>
                            <small>
                                Sistem tidak akan mengizinkan perubahan jika ada buku lain dengan
                                <strong>judul, pengarang, dan penerbit</strong> yang sama.
                            </small>
                        </div>
                    </div>
                </div>

                <form action="{{ route('buku.update', $buku->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group mb-3">
                        <label class="fw-bold">
                            <i class="fas fa-tag me-1"></i> Kode Buku
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-info text-white">
                                <i class="fas fa-lock"></i>
                            </span>
                            <input
                                type="text"
                                class="form-control"
                                value="{{ $buku->kode_buku }}"
                                readonly>
                        </div>
                        <small class="text-muted">
                            <i class="fas fa-info-circle me-1"></i> Kode buku tidak dapat diubah
                        </small>
                    </div>

                    <div class="form-group mb-3">
                        <label for="judul_buku" class="fw-bold">
                            <i class="fas fa-book me-1"></i> Judul Buku <span class="text-danger">*</span>
                        </label>
                        <input
                            type="text"
                            name="judul_buku"
                            id="judul_buku"
                            class="form-control @error('judul_buku') is-invalid @enderror"
                            value="{{ old('judul_buku', $buku->judul_buku) }}"
                            placeholder="Masukkan judul buku"
                            required>
                        @error('judul_buku')
                        <div class="invalid-feedback">
                            <i class="fas fa-exclamation-circle me-1"></i> {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="pengarang" class="fw-bold">
                            <i class="fas fa-user me-1"></i> Pengarang <span class="text-danger">*</span>
                        </label>
                        <input
                            type="text"
                            name="pengarang"
                            id="pengarang"
                            class="form-control @error('pengarang') is-invalid @enderror"
                            value="{{ old('pengarang', $buku->pengarang) }}"
                            placeholder="Masukkan nama pengarang"
                            required>
                        @error('pengarang')
                        <div class="invalid-feedback">
                            <i class="fas fa-exclamation-circle me-1"></i> {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="penerbit" class="fw-bold">
                            <i class="fas fa-building me-1"></i> Penerbit <span class="text-danger">*</span>
                        </label>
                        <input
                            type="text"
                            name="penerbit"
                            id="penerbit"
                            class="form-control @error('penerbit') is-invalid @enderror"
                            value="{{ old('penerbit', $buku->penerbit) }}"
                            placeholder="Masukkan nama penerbit"
                            required>
                        @error('penerbit')
                        <div class="invalid-feedback">
                            <i class="fas fa-exclamation-circle me-1"></i> {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="form-group mb-4">
                        <label for="stok" class="fw-bold">
                            <i class="fas fa-boxes me-1"></i> Stok <span class="text-danger">*</span>
                        </label>
                        <input
                            type="number"
                            name="stok"
                            id="stok"
                            class="form-control @error('stok') is-invalid @enderror"
                            value="{{ old('stok', $buku->stok) }}"
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

                    <div class="alert alert-info mb-4">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-clock fa-2x me-3"></i>
                            <div>
                                <strong>Informasi Buku</strong><br>
                                <small>
                                    Ditambahkan: {{ $buku->created_at->format('d F Y H:i:s') }}<br>
                                    Terakhir diperbarui: {{ $buku->updated_at->format('d F Y H:i:s') }}
                                </small>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-warning text-white">
                            <i class="fas fa-save me-1"></i> Update
                        </button>
                        <a href="{{ route('buku.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Kembali
                        </a>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

@endsection