@extends('layouts.app')

@section('title', 'Detail Buku')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header">
                    <h5 class="mb-0">📖 Detail Buku</h5>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        @if($isAvailable)
                        <i class="fas fa-book-open text-success" style="font-size: 64px;"></i>
                        @else
                        <i class="fas fa-book text-danger" style="font-size: 64px;"></i>
                        @endif
                    </div>

                    <table class="table table-bordered">
                        <tr>
                            <th style="width: 150px;">Kode Buku</th>
                            <td><span class="badge bg-primary">{{ $buku->kode_buku }}</span></td>
                        </tr>
                        <tr>
                            <th>Judul Buku</th>
                            <td><strong>{{ $buku->judul_buku }}</strong></td>
                        </tr>
                        <tr>
                            <th>Pengarang</th>
                            <td>{{ $buku->pengarang }}</td>
                        </tr>
                        <tr>
                            <th>Penerbit</th>
                            <td>{{ $buku->penerbit }}</td>
                        </tr>
                        <tr>
                            <th>Stok</th>
                            <td>
                                @if($isAvailable)
                                <span class="badge bg-success">{{ $stokTersedia }} tersedia</span>
                                <small class="text-muted d-block">(Total stok: {{ $buku->stok }})</small>
                                @else
                                <span class="badge bg-danger">Stok Habis</span>
                                <small class="text-muted d-block">(Total stok: {{ $buku->stok }})</small>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                @if($isAvailable)
                                <span class="badge bg-success">✓ Tersedia</span>
                                @else
                                <span class="badge bg-danger">✗ Tidak Tersedia</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Dibuat pada</th>
                            <td>{{ $buku->created_at ? $buku->created_at->format('d-m-Y H:i:s') : '-' }}</td>
                        </tr>
                        <tr>
                            <th>Terakhir diupdate</th>
                            <td>{{ $buku->updated_at ? $buku->updated_at->format('d-m-Y H:i:s') : '-' }}</td>
                        </tr>
                    </table>

                    <div class="d-flex justify-content-between mt-3">
                        <a href="{{ route('user.buku.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                        @if($isAvailable)
                        <a href="{{ route('user.loans.create') }}" class="btn btn-success">
                            <i class="fas fa-handshake"></i> Pinjam Buku
                        </a>
                        @else
                        <button class="btn btn-secondary" disabled>
                            <i class="fas fa-times"></i> Tidak Tersedia
                        </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection