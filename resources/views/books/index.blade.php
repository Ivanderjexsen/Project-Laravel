@extends('layouts.app')

@section('title', 'Data Buku')

@section('content')

<h1 class="h3 mb-4 text-gray-800">
    <i class="fas fa-book-open me-2"></i>Data Buku
</h1>

<a href="{{ route('buku.create') }}" class="btn btn-primary mb-3">
    <i class="fas fa-plus me-1"></i> Tambah Buku
</a>

<div class="card shadow">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">
            <i class="fas fa-list me-1"></i> Daftar Buku
        </h6>
        @isset($bukus)
        <span class="badge bg-primary">
            <i class="fas fa-database me-1"></i> Total: {{ $bukus->total() }}
        </span>
        @endisset
    </div>

    <div class="card-body">
        <!-- Search Form -->
        <form action="{{ route('buku.index') }}" method="GET" class="mb-3">
            <div class="input-group">
                <input
                    type="text"
                    name="search"
                    class="form-control"
                    placeholder="Cari berdasarkan judul, pengarang, penerbit, atau kode buku..."
                    value="{{ $keyword ?? '' }}">
                <button class="btn btn-primary" type="submit">
                    <i class="fas fa-search me-1"></i> Cari
                </button>
                @if(isset($keyword) && $keyword)
                <a href="{{ route('buku.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times me-1"></i> Reset
                </a>
                @endif
            </div>
        </form>

        <!-- Table -->
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
                <thead class="bg-primary text-white">
                    <tr>
                        <th width="5%">No</th>
                        <th width="15%">Kode Buku</th>
                        <th width="25%">Judul</th>
                        <th width="18%">Pengarang</th>
                        <th width="15%">Penerbit</th>
                        <th width="10%">Stok</th>
                        <th width="12%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bukus ?? [] as $index => $buku)
                    <tr>
                        <td class="text-center">{{ $loop->iteration + (($bukus->currentPage() - 1) * $bukus->perPage()) }}</td>
                        <td>
                            <span class="badge bg-info text-dark">
                                <i class="fas fa-tag me-1"></i>{{ $buku->kode_buku }}
                            </span>
                        </td>
                        <td>
                            <strong>{{ $buku->judul_buku }}</strong>
                        </td>
                        <td>
                            <i class="fas fa-user me-1 text-primary"></i>{{ $buku->pengarang }}
                        </td>
                        <td>
                            <i class="fas fa-building me-1 text-success"></i>{{ $buku->penerbit }}
                        </td>
                        <td class="text-center">
                            @if($buku->stok > 0)
                            <span class="badge bg-success">{{ $buku->stok }}</span>
                            @else
                            <span class="badge bg-danger">{{ $buku->stok }}</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm" role="group">
                                <!-- Tombol Detail -->
                                <a href="{{ route('buku.show', $buku->id) }}"
                                    class="btn btn-info text-white"
                                    title="Detail">
                                    <i class="fas fa-eye"></i>
                                </a>

                                <!-- Tombol Edit -->
                                <a href="{{ route('buku.edit', $buku->id) }}"
                                    class="btn btn-warning text-white"
                                    title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <!-- Tombol Hapus dengan SweetAlert -->
                                <form action="{{ route('buku.destroy', $buku->id) }}"
                                    method="POST"
                                    id="delete-form-{{ $buku->id }}"
                                    class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button"
                                        class="btn btn-danger"
                                        title="Hapus"
                                        onclick="confirmDelete('Apakah Anda yakin ingin menghapus buku \'{{ $buku->judul_buku }}\' oleh {{ $buku->pengarang }}? Data yang dihapus tidak dapat dikembalikan!', 'delete-form-{{ $buku->id }}')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4">
                            <i class="fas fa-inbox fa-3x text-muted d-block mb-3"></i>
                            <h5 class="text-muted">Belum ada data buku</h5>
                            <p class="text-muted">Silakan tambahkan buku baru</p>
                            <a href="{{ route('buku.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-1"></i> Tambah Buku
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if(isset($bukus) && $bukus->hasPages())
        <div class="d-flex justify-content-between align-items-center mt-3">
            <div class="text-muted">
                <small>
                    <i class="fas fa-info-circle me-1"></i>
                    Menampilkan {{ $bukus->firstItem() }} - {{ $bukus->lastItem() }}
                    dari {{ $bukus->total() }} data
                </small>
            </div>
            <div>
                {{ $bukus->appends(request()->query())->links() }}
            </div>
        </div>
        @endif
    </div>
</div>

@endsection