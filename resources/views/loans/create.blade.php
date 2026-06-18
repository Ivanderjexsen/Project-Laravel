@extends('layouts.app')

@section('title','Tambah Peminjaman')

@section('content')

<h1 class="h3 mb-4 text-gray-800">

Tambah Peminjaman

</h1>

<div class="card shadow">

    <div class="card-body">

        <form>

            <div class="form-group">

                <label>Nama Peminjam</label>

                <select class="form-control">

                    <option>Admin</option>
                    <option>User 1</option>

                </select>

            </div>

            <div class="form-group">

                <label>Buku</label>

                <select class="form-control">

                    <option>Laravel 12</option>
                    <option>Basis Data</option>

                </select>

            </div>

            <div class="form-group">

                <label>Tanggal Pinjam</label>

                <input
                    type="date"
                    class="form-control">

            </div>

            <button class="btn btn-primary">

                Simpan

            </button>

            <a href="/loans"
               class="btn btn-secondary">

                Kembali

            </a>

        </form>

    </div>

</div>

@endsection