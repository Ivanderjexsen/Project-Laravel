@extends('layouts.app')

@section('title', 'Histori Peminjaman Saya')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">📋 Histori Peminjaman Saya</h5>
                    <a href="{{ route('user.loans.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Pinjam Buku
                    </a>
                </div>
                <div class="card-body">
                    <!-- Alert -->
                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    @endif

                    @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    @endif

                    <!-- Form Filter -->
                    <form action="{{ route('user.loans.index') }}" method="GET" class="mb-4">
                        <div class="row g-2">
                            <div class="col-md-4">
                                <select name="status" class="form-select" onchange="this.form.submit()">
                                    <option value="">Semua Status</option>
                                    <option value="Dipinjam" {{ ($status ?? '') == 'Dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                                    <option value="Dikembalikan" {{ ($status ?? '') == 'Dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <a href="{{ route('user.loans.index') }}" class="btn btn-outline-secondary w-100">
                                    <i class="fas fa-sync"></i> Reset
                                </a>
                            </div>
                        </div>
                    </form>

                    <!-- Statistik -->
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="card bg-primary text-white">
                                <div class="card-body text-center">
                                    <h5 class="mb-0">{{ $totalPinjam ?? 0 }}</h5>
                                    <small>Total Pinjam</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-warning text-dark">
                                <div class="card-body text-center">
                                    <h5 class="mb-0">{{ $totalDipinjam ?? 0 }}</h5>
                                    <small>Masih Dipinjam</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-success text-white">
                                <div class="card-body text-center">
                                    <h5 class="mb-0">{{ $totalDikembalikan ?? 0 }}</h5>
                                    <small>Dikembalikan</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tabel -->
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Buku</th>
                                    <th>Tanggal Pinjam</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($loans as $index => $loan)
                                <tr>
                                    <td>{{ $loans->firstItem() + $index }}</td>
                                    <td><strong>{{ $loan->buku }}</strong></td>
                                    <td>{{ $loan->tanggal_pinjam ? $loan->tanggal_pinjam->format('d-m-Y') : '-' }}</td>
                                    <td>
                                        @if($loan->status == 'Dipinjam')
                                        <span class="badge bg-primary">Dipinjam</span>
                                        @else
                                        <span class="badge bg-success">Dikembalikan</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('user.loans.show', $loan->id) }}"
                                                class="btn btn-info" title="Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            @if($loan->status == 'Dipinjam')
                                            <form action="{{ route('user.loans.return', $loan->id) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-success"
                                                    title="Kembalikan"
                                                    onclick="return confirm('Yakin ingin mengembalikan buku ini?')">
                                                    <i class="fas fa-undo"></i>
                                                </button>
                                            </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4">
                                        <i class="fas fa-book-open fa-2x text-muted d-block mb-2"></i>
                                        <span class="text-muted">Belum ada histori peminjaman</span>
                                        <br>
                                        <a href="{{ route('user.loans.create') }}" class="btn btn-primary btn-sm mt-2">
                                            <i class="fas fa-plus"></i> Pinjam Buku Sekarang
                                        </a>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center">
                        {{ $loans->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection