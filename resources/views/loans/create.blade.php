@extends('layouts.app')

@section('title', 'Tambah Peminjaman')

@section('content')

<h1 class="h3 mb-4 text-gray-800">Tambah Peminjaman</h1>

<div class="card shadow">
    <div class="card-body">
        <form action="{{ route('loans.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label>Nama Peminjam</label>
                <select name="peminjam" class="form-control" required>
                    <option value="Admin">Admin</option>
                    <option value="User 1">User 1</option>
                    <option value="User 2">User 2</option>
                </select>
            </div>

            <div class="form-group">
                <label>Buku</label>
                <select name="buku" class="form-control" required>
                    <option value="Laravel 12">Laravel 12</option>
                    <option value="Basis Data">Basis Data</option>
                    <option value="Pemrograman Web">Pemrograman Web</option>
                </select>
            </div>

            <div class="form-group">
                <label>Tanggal Pinjam</label>
                <input type="date" name="tanggal_pinjam" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('loans.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>

@endsection