@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-tachometer-alt me-2"></i>Dashboard
    </h1>
    <span class="text-muted small">
        <i class="fas fa-user me-1"></i> {{ Auth::user()->name }}
        <span class="badge bg-{{ Auth::user()->role == 'admin' ? 'danger' : 'info' }} ms-1">
            {{ ucfirst(Auth::user()->role) }}
        </span>
    </span>
</div>

<!-- ========================================== -->
<!-- DASHBOARD ADMIN                            -->
<!-- ========================================== -->
@if($isAdmin)

<!-- Content Row -->
<div class="row">

    <!-- Total Buku -->
    <div class="col-xl-3 col-md-6 mb-4">
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
    <div class="col-xl-3 col-md-6 mb-4">
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

    <!-- Sedang Dipinjam -->
    <div class="col-xl-3 col-md-6 mb-4">
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

    <!-- Total User -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-danger shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                            <i class="fas fa-users me-1"></i> Total User
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $totalUser }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Statistik Grafik -->
<div class="row">
    <div class="col-lg-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-chart-bar me-2"></i> Statistik Peminjaman Buku
                </h6>
                <span class="badge bg-primary text-white">
                    {{ count($months) }} Bulan
                </span>
            </div>
            <div class="card-body">
                <canvas id="loanChart" height="250"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Tabel Peminjaman Terbaru -->
<div class="row">
    <div class="col-lg-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-clock me-2"></i> Peminjaman Terbaru
                </h6>
                <a href="{{ route('admin.loans.index') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-eye me-1"></i> Lihat Semua
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Peminjam</th>
                                <th>Buku</th>
                                <th>Tanggal Pinjam</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentLoans as $index => $loan)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td><strong>{{ $loan->peminjam }}</strong></td>
                                <td>{{ $loan->buku }}</td>
                                <td>{{ $loan->tanggal_pinjam ? $loan->tanggal_pinjam->format('d-m-Y') : '-' }}</td>
                                <td>
                                    @if($loan->status == 'Dipinjam')
                                    <span class="badge bg-warning text-dark">Dipinjam</span>
                                    @else
                                    <span class="badge bg-success">Dikembalikan</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center">Belum ada peminjaman</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ========================================== -->
<!-- DASHBOARD USER                            -->
<!-- ========================================== -->
@else

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

    <!-- Sedang Dipinjam -->
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

<!-- Statistik Peminjaman User -->
<div class="row">
    <div class="col-lg-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-chart-pie me-2"></i> Statistik Peminjaman Saya
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="text-center">
                            <h5 class="text-primary">{{ $totalUserPinjam }}</h5>
                            <small class="text-muted">Total Peminjaman</small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-center">
                            <h5 class="text-warning">{{ $totalUserDipinjam }}</h5>
                            <small class="text-muted">Masih Dipinjam</small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-center">
                            <h5 class="text-success">{{ $totalUserDikembalikan }}</h5>
                            <small class="text-muted">Dikembalikan</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Histori Peminjaman User -->
<div class="row">
    <div class="col-lg-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-clock me-2"></i> Histori Peminjaman Saya
                </h6>
                <a href="{{ route('user.loans.index') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-eye me-1"></i> Lihat Semua
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Buku</th>
                                <th>Tanggal Pinjam</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($userLoans as $index => $loan)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td><strong>{{ $loan->buku }}</strong></td>
                                <td>{{ $loan->tanggal_pinjam ? $loan->tanggal_pinjam->format('d-m-Y') : '-' }}</td>
                                <td>
                                    @if($loan->status == 'Dipinjam')
                                    <span class="badge bg-warning text-dark">Dipinjam</span>
                                    @else
                                    <span class="badge bg-success">Dikembalikan</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center">Belum ada peminjaman</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tombol Aksi User -->
<div class="row">
    <div class="col-lg-12">
        <div class="card shadow mb-4">
            <div class="card-body text-center">
                <a href="{{ route('user.buku.index') }}" class="btn btn-primary">
                    <i class="fas fa-book me-1"></i> Lihat Data Buku
                </a>
                <a href="{{ route('user.loans.create') }}" class="btn btn-success">
                    <i class="fas fa-handshake me-1"></i> Pinjam Buku
                </a>
                <a href="{{ route('user.loans.index') }}" class="btn btn-info">
                    <i class="fas fa-clock me-1"></i> Histori Peminjaman
                </a>
            </div>
        </div>
    </div>
</div>

@endif

@push('scripts')
@if($isAdmin)
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('loanChart').getContext('2d');

        const months = {
            !!json_encode($months) !!
        };
        const counts = {
            !!json_encode($counts) !!
        };

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: months,
                datasets: [{
                    label: 'Jumlah Peminjaman',
                    data: counts,
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.6)',
                        'rgba(75, 192, 192, 0.6)',
                        'rgba(255, 206, 86, 0.6)',
                        'rgba(153, 102, 255, 0.6)',
                        'rgba(255, 99, 132, 0.6)',
                        'rgba(255, 159, 64, 0.6)'
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 2,
                    borderRadius: 8,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return 'Total: ' + context.parsed.y + ' peminjaman';
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        },
                        grid: {
                            color: 'rgba(0,0,0,0.05)'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    });
</script>
@endif
@endpush

@endsection