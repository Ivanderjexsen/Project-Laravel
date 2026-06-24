@extends('layouts.app')

@section('title', 'Data Peminjaman')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header">
                    <h5 class="mb-0">📋 Data Peminjaman</h5>
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
                    <form action="{{ route('admin.loans.index') }}" method="GET" class="mb-4">
                        <div class="row g-2">
                            <div class="col-md-4">
                                <select name="status" class="form-select" onchange="this.form.submit()">
                                    <option value="">Semua Status</option>
                                    <option value="Dipinjam" {{ ($status ?? '') == 'Dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                                    <option value="Dikembalikan" {{ ($status ?? '') == 'Dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <select name="user" class="form-select" onchange="this.form.submit()">
                                    <option value="">Semua User</option>
                                    @foreach($users as $user)
                                    <option value="{{ $user->name }}" {{ ($userFilter ?? '') == $user->name ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <a href="{{ route('admin.loans.index') }}" class="btn btn-outline-secondary w-100">
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
                                    <small>Dipinjam</small>
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

                    <!-- Chart -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h6 class="mb-0">📊 Grafik Peminjaman per Bulan</h6>
                        </div>
                        <div class="card-body">
                            <canvas id="loanChart" height="100"></canvas>
                        </div>
                    </div>

                    <!-- Tabel -->
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Peminjam</th>
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
                                    <td><strong>{{ $loan->peminjam }}</strong></td>
                                    <td>{{ $loan->buku }}</td>
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
                                            <a href="{{ route('admin.loans.edit', $loan->id) }}"
                                                class="btn btn-warning" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-primary"
                                                data-bs-toggle="modal"
                                                data-bs-target="#statusModal{{ $loan->id }}"
                                                title="Ubah Status">
                                                <i class="fas fa-exchange-alt"></i>
                                            </button>
                                            <form action="{{ route('admin.loans.destroy', $loan->id) }}"
                                                method="POST" class="d-inline"
                                                onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger" title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Modal Update Status -->
                                <div class="modal fade" id="statusModal{{ $loan->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="{{ route('admin.loans.update-status', $loan->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Ubah Status Peminjaman</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label class="form-label">Status</label>
                                                        <select name="status" class="form-select" required>
                                                            <option value="Dipinjam" {{ $loan->status == 'Dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                                                            <option value="Dikembalikan" {{ $loan->status == 'Dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
                                                        </select>
                                                    </div>
                                                    <small class="text-muted">
                                                        <i class="fas fa-info-circle me-1"></i>
                                                        Mengubah status akan mempengaruhi stok buku.
                                                    </small>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">
                                        <i class="fas fa-book-open fa-2x text-muted d-block mb-2"></i>
                                        <span class="text-muted">Belum ada data peminjaman</span>
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

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('loanChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {
                    !!json_encode($months ?? []) !!
                },
                datasets: [{
                    label: 'Jumlah Peminjaman',
                    data: {
                        !!json_encode($counts ?? []) !!
                    },
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    });
</script>
@endpush
@endsection