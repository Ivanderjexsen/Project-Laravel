@extends('layouts.app')

@section('title', 'Data Peminjaman')

@section('content')

<h1 class="h3 mb-4 text-gray-800">Data Peminjaman</h1>

<a href="{{ route('loans.create') }}" class="btn btn-primary mb-3">
    <i class="fas fa-plus"></i> Tambah Peminjaman
</a>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
            Daftar Peminjaman
        </h6>
    </div>

    <div class="card-body">
        <div class="table-responsive">

            <table class="table table-bordered" width="100%" cellspacing="0">

                <thead>
                    <tr>
                        <th>No</th>
                        <th>Peminjam</th>
                        <th>Buku</th>
                        <th>Tanggal Pinjam</th>
                        <th>Status</th>
                        <th width="180">Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($loans as $key => $loan)

                    <tr>
                        <td>{{ $key + 1 }}</td>

                        <td>{{ $loan->peminjam }}</td>

                        <td>{{ $loan->buku }}</td>

                        <td>
                            {{ \Carbon\Carbon::parse($loan->tanggal_pinjam)->format('d F Y') }}
                        </td>

                        <td>
                            @if($loan->status == 'Dipinjam')
                                <span class="badge badge-warning">
                                    Dipinjam
                                </span>
                            @else
                                <span class="badge badge-success">
                                    Dikembalikan
                                </span>
                            @endif
                        </td>

                        <td>

                            <a href="{{ route('loans.edit', $loan->id) }}"
                               class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i>
                                Edit
                            </a>

                            <form action="{{ route('loans.destroy', $loan->id) }}"
                                  method="POST"
                                  class="d-inline">

                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('Yakin ingin menghapus data ini?')">

                                    <i class="fas fa-trash"></i>
                                    Hapus

                                </button>

                            </form>

                        </td>
                    </tr>

                    @empty

                    <tr>
                        <td colspan="6" class="text-center">
                            Belum ada data peminjaman.
                        </td>
                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>
    </div>
</div>

<div class="card shadow mb-4">

    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
            <i class="fas fa-chart-bar mr-2"></i>
            Jumlah Peminjaman per Bulan
        </h6>
    </div>

    <div class="card-body">

        <div style="height:350px;">
            <canvas id="loanChart"></canvas>
        </div>

    </div>

</div>

@endsection

@section('script')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const canvas = document.getElementById('loanChart');

    if (!canvas) return;

    const months = @json($months ?? []);
    const counts = @json($counts ?? []);

    new Chart(canvas, {

        type: 'bar',

        data: {
            labels: months,
            datasets: [{
                label: 'Jumlah Peminjaman',
                data: counts,
                backgroundColor: 'rgba(78,115,223,0.7)',
                borderColor: 'rgba(78,115,223,1)',
                borderWidth: 2
            }]
        },

        options: {
            responsive: true,
            maintainAspectRatio: false,

            plugins: {
                legend: {
                    display: true
                }
            },

            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    }
                }
            }
        }

    });

});
</script>

@endsection