@extends('layouts.app')

@section('title', 'Pinjam Buku')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header">
                    <h5 class="mb-0">📖 Pinjam Buku</h5>
                </div>
                <div class="card-body">
                    @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    @endif

                    <form action="{{ route('user.loans.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="buku_id" class="form-label">Pilih Buku <span class="text-danger">*</span></label>
                            <select class="form-select @error('buku_id') is-invalid @enderror"
                                id="buku_id"
                                name="buku_id"
                                required>
                                <option value="">-- Pilih Buku --</option>
                                @foreach($bukus as $buku)
                                @php
                                $dipinjam = App\Models\Loan::where('buku', $buku->judul_buku)->where('status', 'Dipinjam')->count();
                                $stokTersedia = $buku->stok - $dipinjam;
                                @endphp
                                <option value="{{ $buku->id }}"
                                    {{ old('buku_id') == $buku->id ? 'selected' : '' }}>
                                    {{ $buku->kode_buku }} - {{ $buku->judul_buku }}
                                    (Stok: {{ $stokTersedia }})
                                </option>
                                @endforeach
                            </select>
                            @error('buku_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tanggal Pinjam</label>
                            <input type="text" class="form-control" value="{{ now()->format('d-m-Y') }}" disabled>
                            <small class="text-muted">Tanggal pinjam otomatis hari ini</small>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('user.loans.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Pinjam Buku
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection