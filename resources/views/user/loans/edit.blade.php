@extends('layouts.app')

@section('title', 'Edit Peminjaman')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header">
                    <h5 class="mb-0">✏️ Edit Peminjaman</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('loans.update', $loan->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="peminjam" class="form-label">Peminjam <span class="text-danger">*</span></label>
                            <input type="text"
                                class="form-control @error('peminjam') is-invalid @enderror"
                                id="peminjam"
                                name="peminjam"
                                value="{{ old('peminjam', $loan->peminjam) }}"
                                required>
                            @error('peminjam')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="buku" class="form-label">Buku <span class="text-danger">*</span></label>
                            <input type="text"
                                class="form-control @error('buku') is-invalid @enderror"
                                id="buku"
                                name="buku"
                                value="{{ old('buku', $loan->buku) }}"
                                required>
                            @error('buku')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="tanggal_pinjam" class="form-label">Tanggal Pinjam <span class="text-danger">*</span></label>
                            <input type="date"
                                class="form-control @error('tanggal_pinjam') is-invalid @enderror"
                                id="tanggal_pinjam"
                                name="tanggal_pinjam"
                                value="{{ old('tanggal_pinjam', $loan->tanggal_pinjam ? $loan->tanggal_pinjam->format('Y-m-d') : '') }}"
                                required>
                            @error('tanggal_pinjam')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                            <select class="form-select @error('status') is-invalid @enderror"
                                id="status"
                                name="status"
                                required>
                                <option value="Dipinjam" {{ old('status', $loan->status) == 'Dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                                <option value="Dikembalikan" {{ old('status', $loan->status) == 'Dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
                            </select>
                            @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('loans.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection