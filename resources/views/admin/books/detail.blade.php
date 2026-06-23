@extends('layouts.app')

@section('title', 'Detail Buku')

@section('content')

<h1 class="h3 mb-4 text-gray-800">
    <i class="fas fa-info-circle me-2"></i>Detail Buku
</h1>

<div class="card shadow">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">
            <i class="fas fa-book me-1"></i> Informasi Buku
        </h6>
        <span class="badge bg-info">
            <i class="fas fa-tag me-1"></i> {{ $buku->kode_buku }}
        </span>
    </div>

    <div class="card-body">
        <div class="text-center mb-4">
            <div class="display-1 text-primary">
                <i class="fas fa-book"></i>
            </div>
            <h2 class="mt-2 fw-bold">{{ $buku->judul_buku }}</h2>
            <p class="text-muted">
                <i class="fas fa-user me-1"></i> {{ $buku->pengarang }}
                <span class="mx-2">|</span>
                <i class="fas fa-building me-1"></i> {{ $buku->penerbit }}
            </p>
            <div class="mt-2">
                @if($buku->stok > 0)
                <span class="badge bg-success fs-6">
                    <i class="fas fa-check-circle me-1"></i> Tersedia
                </span>
                @else
                <span class="badge bg-danger fs-6">
                    <i class="fas fa-times-circle me-1"></i> Habis
                </span>
                @endif
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <th width="30%" class="bg-light">
                            <i class="fas fa-tag me-1"></i> Kode Buku
                        </th>
                        <td>
                            <span class="badge bg-info text-dark">{{ $buku->kode_buku }}</span>
                        </td>
                    </tr>
                    <tr>
                        <th class="bg-light">
                            <i class="fas fa-book me-1"></i> Judul Buku
                        </th>
                        <td class="fw-bold">{{ $buku->judul_buku }}</td>
                    </tr>
                    <tr>
                        <th class="bg-light">
                            <i class="fas fa-user me-1"></i> Pengarang
                        </th>
                        <td>{{ $buku->pengarang }}</td>
                    </tr>
                    <tr>
                        <th class="bg-light">
                            <i class="fas fa-building me-1"></i> Penerbit
                        </th>
                        <td>{{ $buku->penerbit }}</td>
                    </tr>
                    <tr>
                        <th class="bg-light">
                            <i class="fas fa-boxes me-1"></i> Stok
                        </th>
                        <td>
                            @if($buku->stok > 0)
                            <span class="badge bg-success">{{ $buku->stok }}</span>
                            @else
                            <span class="badge bg-danger">{{ $buku->stok }}</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="bg-light">
                            <i class="fas fa-info-circle me-1"></i> Status
                        </th>
                        <td>
                            @if($buku->stok > 0)
                            <span class="badge bg-success">
                                <i class="fas fa-check-circle me-1"></i> Tersedia
                            </span>
                            @else
                            <span class="badge bg-danger">
                                <i class="fas fa-times-circle me-1"></i> Habis
                            </span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="bg-light">
                            <i class="fas fa-calendar-plus me-1"></i> Ditambahkan
                        </th>
                        <td>
                            {{ $buku->created_at->format('d F Y H:i:s') }}
                            <br>
                            <small class="text-muted">({{ $buku->created_at->diffForHumans() }})</small>
                        </td>
                    </tr>
                    <tr>
                        <th class="bg-light">
                            <i class="fas fa-calendar-edit me-1"></i> Terakhir Diperbarui
                        </th>
                        <td>
                            {{ $buku->updated_at->format('d F Y H:i:s') }}
                            <br>
                            <small class="text-muted">({{ $buku->updated_at->diffForHumans() }})</small>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Tombol Aksi -->
        <div class="d-flex gap-2 mt-3">
            <a href="{{ route('buku.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Kembali
            </a>
            <a href="{{ route('buku.edit', $buku->id) }}" class="btn btn-warning text-white">
                <i class="fas fa-edit me-1"></i> Edit Buku
            </a>
            <form action="{{ route('buku.destroy', $buku->id) }}"
                method="POST"
                id="delete-form"
                class="d-inline">
                @csrf
                @method('DELETE')
                <button type="button"
                    class="btn btn-danger"
                    onclick="confirmDelete('Apakah Anda yakin ingin menghapus buku \'{{ $buku->judul_buku }}\' oleh {{ $buku->pengarang }}? Data yang dihapus tidak dapat dikembalikan!', 'delete-form')">
                    <i class="fas fa-trash me-1"></i> Hapus Buku
                </button>
            </form>
        </div>
    </div>
</div>

@endsection