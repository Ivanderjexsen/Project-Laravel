@extends('layouts.app')

@section('title', 'Data Peminjaman')

@section('content')

<h1 class="h3 mb-4 text-gray-800">Data Peminjaman</h1>

{{-- Tombol Tambah --}}
<a href="{{ route('loans.create') }}" class="btn btn-primary mb-3">
    <i class="fas fa-plus"></i> Tambah Peminjaman
</a>

{{-- Pesan sukses --}}
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

{{-- TABEL DAFTAR PEMINJAMAN --}}
<div class="card shadow">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Peminjaman</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Peminjam</th>
                        <th>Buku</th>
                        <th>Tanggal Pinjam</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($loans as $key => $loan)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $loan->peminjam }}</td>
                        <td>{{ $loan->buku }}</td>
                        <td>{{ \Carbon\Carbon::parse($loan->tanggal_pinjam)->format('d F Y') }}</td>
                        <td>
                            <span class="badge badge-{{ $loan->status == 'Dipinjam' ? 'warning' : 'success' }}">
                                {{ $loan->status }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('loans.edit', $loan->id) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form action="{{ route('loans.destroy', $loan->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?')">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">Belum ada data peminjaman.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- GRAFIK / CHART --}}
@extends('layouts.app')

@section('title', 'Data Peminjaman')

@section('content')

<h1 class="h3 mb-4 text-gray-800">Data Peminjaman</h1>

{{-- Tombol Tambah --}}
<a href="{{ route('loans.create') }}" class="btn btn-primary mb-3">
    <i class="fas fa-plus"></i> Tambah Peminjaman
</a>

{{-- Pesan sukses --}}
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

{{-- TABEL --}}
<div class="card shadow">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Peminjaman</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Peminjam</th>
                        <th>Buku</th>
                        <th>Tanggal Pinjam</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($loans as $key => $loan)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $loan->peminjam }}</td>
                        <td>{{ $loan->buku }}</td>
                        <td>{{ \Carbon\Carbon::parse($loan->tanggal_pinjam)->format('d F Y') }}</td>
                        <td>
                            <span class="badge badge-{{ $loan->status == 'Dipinjam' ? 'warning' : 'success' }}">
                                {{ $loan->status }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('loans.edit', $loan->id) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form action="{{ route('loans.destroy', $loan->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?')">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">Belum ada data peminjaman.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- GRAFIK --}}
<div class="card shadow mt-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
            <i class="fas fa-chart-bar mr-2"></i> Jumlah Peminjaman per Bulan
        </h6>
    </div>
    <div class="card-body">
        <div class="chart-area" style="height: 300px;">
            <canvas id="loanChart"></canvas>
        </div>
        <hr>
        <a href="#" class="btn btn-sm btn-primary">
            <i class="fas fa-eye"></i> View Details
        </a>
    </div>
</div>

{{-- SCRIPT --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const canvas = document.getElementById('loanChart');
        if (!canvas) return;
        const ctx = canvas.getContext('2d');

        const months = @json($months);
        const counts = @json($counts);

        // Selalu buat grafik, meskipun data hanya 1 atau 0
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: months,
                datasets: [{
                    label: 'Jumlah Peminjaman',
                    data: counts,
                    backgroundColor: 'rgba(78, 115, 223, 0.7)',
                    borderColor: 'rgba(78, 115, 223, 1)',
                    borderWidth: 2,
                    borderRadius: 6,
                    barPercentage: 0.6,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: true, position: 'top' },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.dataset.label + ': ' + context.parsed.y + ' peminjaman';
                            }
                        }
                    }
                },
                scales: {
                    y: { beginAtZero: true, stepSize: 1, ticks: { precision: 0 } },
                    x: { grid: { display: false } }
                },
                animation: { duration: 1000, easing: 'easeOutQuart' }
            }
        });
    });
</script>

@endsection

{{-- DEBUG: Tampilkan data yang dikirim controller (untuk memastikan ada data) --}}
{{-- <pre>Months: {{ json_encode($months ?? 'tidak ada') }}</pre> --}}
{{-- <pre>Counts: {{ json_encode($counts ?? 'tidak ada') }}</pre> --}}

{{-- SCRIPT LANGSUNG DI SINI (PASTI MUNCUL) --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    // Jalankan setelah semua konten dimuat
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM siap - mencoba membuat grafik...');

        const canvas = document.getElementById('loanChart');
        if (!canvas) {
            console.error('Canvas dengan id "loanChart" tidak ditemukan!');
            return;
        }

        // Ambil data dari variabel PHP
        const months = @json($months ?? []);
        const counts = @json($counts ?? []);

        console.log('Data months:', months);
        console.log('Data counts:', counts);

        // Jika data kosong atau semua 0, tampilkan pesan di canvas
        if (!months.length || !counts.length || counts.every(v => v === 0)) {
            const ctx = canvas.getContext('2d');
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            ctx.font = '18px Arial';
            ctx.fillStyle = '#999';
            ctx.textAlign = 'center';
            ctx.textBaseline = 'middle';
            ctx.fillText('Belum ada data peminjaman untuk grafik.', canvas.width/2, canvas.height/2);
            return;
        }

        // Buat grafik
        const ctx = canvas.getContext('2d');
        const gradient = ctx.createLinearGradient(0, 0, 0, 300);
        gradient.addColorStop(0, 'rgba(78, 115, 223, 0.8)');
        gradient.addColorStop(1, 'rgba(78, 115, 223, 0.2)');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: months,
                datasets: [{
                    label: 'Jumlah Peminjaman',
                    data: counts,
                    backgroundColor: gradient,
                    borderColor: 'rgba(78, 115, 223, 1)',
                    borderWidth: 2,
                    borderRadius: 6,
                    barPercentage: 0.6,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: true, position: 'top' },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.dataset.label + ': ' + context.parsed.y + ' peminjaman';
                            }
                        }
                    }
                },
                scales: {
                    y: { beginAtZero: true, stepSize: 1, ticks: { precision: 0 } },
                    x: { grid: { display: false } }
                },
                animation: { duration: 1000, easing: 'easeOutQuart' }
            }
        });

        console.log('Grafik berhasil dibuat!');
    });
</script>

@endsection