@extends('layouts.app')

@section('title', 'Detail Peminjaman')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header">
                    <h5 class="mb-0">📋 Detail Histori Peminjaman</h5>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <h4>{{ $loan->buku }}</h4>
                        <p class="text-muted">Dipinjam oleh: {{ $loan->peminjam }}</p>
                    </div>

                    <table class="table table-bordered">
                        <tr>
                            <th style="width: 150px;">ID Peminjaman</th>
                            <td>#{{ $loan->id }}</td>
                        </tr>
                        <tr>
                            <th>Peminjam</th>
                            <td><strong>{{ $loan->peminjam }}</strong></td>
                        </tr>
                        <tr>
                            <th>Buku</th>
                            <td>{{ $loan->buku }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal Pinjam</th>
                            <td>{{ $loan->tanggal_pinjam ? $loan->tanggal_pinjam->format('d-m-Y') : '-' }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                @if($loan->status == 'Dipinjam')
                                <span class="badge bg-primary">Dipinjam</span>
                                @else
                                <span class="badge bg-success">Dikembalikan</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Tanggal Peminjaman</th>
                            <td>{{ $loan->created_at ? $loan->created_at->format('d-m-Y H:i:s') : '-' }}</td>
                        </tr>
                        <tr>
                            <th>Terakhir Diupdate</th>
                            <td>{{ $loan->updated_at ? $loan->updated_at->format('d-m-Y H:i:s') : '-' }}</td>
                        </tr>
                    </table>

                    <div class="d-flex justify-content-between mt-3">
                        <a href="{{ route('user.loans.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali ke Histori
                        </a>
                        @if($loan->status == 'Dipinjam')
                        <form action="{{ route('user.loans.return', $loan->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-success"
                                onclick="return confirm('Yakin ingin mengembalikan buku ini?')">
                                <i class="fas fa-undo"></i> Kembalikan Buku
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection