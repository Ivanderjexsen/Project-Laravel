@extends('layouts.app')

@section('title', 'Data Buku')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header">
                    <h5 class="mb-0">📚 Data Buku</h5>
                </div>
                <div class="card-body">
                    <!-- Form Pencarian -->
                    <form action="{{ route('user.buku.index') }}" method="GET" class="mb-4">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control"
                                placeholder="Cari buku (judul, pengarang, penerbit, kode)..."
                                value="{{ $keyword ?? '' }}">
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-search"></i> Cari
                            </button>
                            @if(isset($keyword) && $keyword)
                            <a href="{{ route('user.buku.index') }}" class="btn btn-danger">
                                <i class="fas fa-times"></i>
                            </a>
                            @endif
                        </div>
                    </form>

                    <!-- Statistik -->
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="card bg-primary text-white">
                                <div class="card-body text-center">
                                    <h5 class="mb-0">{{ $totalBuku }}</h5>
                                    <small>Total Buku</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-success text-white">
                                <div class="card-body text-center">
                                    <h5 class="mb-0">{{ $totalTersedia }}</h5>
                                    <small>Tersedia</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-danger text-white">
                                <div class="card-body text-center">
                                    <h5 class="mb-0">{{ $totalTidakTersedia }}</h5>
                                    <small>Tidak Tersedia</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Informasi Jumlah Data -->
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <small class="text-muted">
                            Menampilkan {{ $bukus->firstItem() ?? 0 }} - {{ $bukus->lastItem() ?? 0 }}
                            dari {{ $bukus->total() }} buku
                        </small>
                        <small class="text-muted">
                            Halaman {{ $bukus->currentPage() }} dari {{ $bukus->lastPage() }}
                        </small>
                    </div>

                    <!-- Grid Buku (8 per halaman) -->
                    <div class="row">
                        @forelse($bukus as $buku)
                        @php
                        $stokTersedia = $buku->getStokTersedia();
                        $isAvailable = $stokTersedia > 0;
                        @endphp
                        <div class="col-md-3 col-sm-6 mb-4">
                            <div class="card h-100 {{ $isAvailable ? 'border-success' : 'border-danger' }}">
                                <div class="card-body text-center">
                                    <!-- Icon Buku -->
                                    <div class="mb-3">
                                        @if($isAvailable)
                                        <i class="fas fa-book-open text-success" style="font-size: 48px;"></i>
                                        @else
                                        <i class="fas fa-book text-danger" style="font-size: 48px;"></i>
                                        @endif
                                    </div>

                                    <!-- Status -->
                                    <div class="mb-2">
                                        @if($isAvailable)
                                        <span class="badge bg-success">✓ Tersedia</span>
                                        @else
                                        <span class="badge bg-danger">✗ Tidak Tersedia</span>
                                        @endif
                                    </div>

                                    <!-- Judul Buku -->
                                    <h6 class="card-title text-truncate" title="{{ $buku->judul_buku }}">
                                        {{ $buku->judul_buku }}
                                    </h6>

                                    <!-- Informasi -->
                                    <p class="card-text small text-muted mb-1">
                                        <i class="fas fa-user me-1"></i> {{ $buku->pengarang }}
                                    </p>
                                    <p class="card-text small text-muted mb-1">
                                        <i class="fas fa-building me-1"></i> {{ $buku->penerbit }}
                                    </p>
                                    <p class="card-text small">
                                        <i class="fas fa-code me-1"></i> {{ $buku->kode_buku }}
                                    </p>

                                    <!-- Stok -->
                                    <div class="mt-2">
                                        @if($isAvailable)
                                        <span class="text-success">
                                            <i class="fas fa-boxes me-1"></i> Stok: {{ $stokTersedia }}
                                        </span>
                                        @else
                                        <span class="text-danger">
                                            <i class="fas fa-boxes me-1"></i> Stok Habis
                                        </span>
                                        @endif
                                    </div>

                                    <!-- Tombol Detail -->
                                    <a href="{{ route('user.buku.show', $buku->id) }}"
                                        class="btn btn-sm btn-outline-primary mt-3 w-100">
                                        <i class="fas fa-eye me-1"></i> Detail
                                    </a>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-12">
                            <div class="text-center py-5">
                                <i class="fas fa-book fa-3x text-muted d-block mb-3"></i>
                                <h5 class="text-muted">Belum ada data buku</h5>
                            </div>
                        </div>
                        @endforelse
                    </div>

                    <!-- Pagination dengan Sebelumnya dan Selanjutnya -->
                    <div class="d-flex justify-content-center mt-4">
                        {{ $bukus->appends(request()->query())->links() }}
                    </div>

                    <!-- Pagination Manual (Opsional) -->
                    @if($bukus->hasPages())
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div>
                            @if($bukus->onFirstPage())
                            <button class="btn btn-secondary btn-sm" disabled>
                                <i class="fas fa-arrow-left"></i> Sebelumnya
                            </button>
                            @else
                            <a href="{{ $bukus->previousPageUrl() }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-arrow-left"></i> Sebelumnya
                            </a>
                            @endif
                        </div>

                        <div>
                            <span class="text-muted">
                                Halaman {{ $bukus->currentPage() }} dari {{ $bukus->lastPage() }}
                            </span>
                        </div>

                        <div>
                            @if($bukus->hasMorePages())
                            <a href="{{ $bukus->nextPageUrl() }}" class="btn btn-primary btn-sm">
                                Selanjutnya <i class="fas fa-arrow-right"></i>
                            </a>
                            @else
                            <button class="btn btn-secondary btn-sm" disabled>
                                Selanjutnya <i class="fas fa-arrow-right"></i>
                            </button>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection