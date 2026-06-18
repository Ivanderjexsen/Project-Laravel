@extends('layouts.app')

@section('title','Data Peminjaman')

@section('content')

<h1 class="h3 mb-4 text-gray-800">
    Data Peminjaman
</h1>

<a href="/loans/create" class="btn btn-primary mb-3">

    <i class="fas fa-plus"></i>

    Tambah Peminjaman

</a>

<div class="card shadow">

    <div class="card-header py-3">

        <h6 class="m-0 font-weight-bold text-primary">

            Daftar Peminjaman

        </h6>

    </div>

    <div class="card-body">

        <table class="table table-bordered">

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

            <tr>

                <td>1</td>

                <td>Admin</td>

                <td>Laravel 12</td>

                <td>18 Juni 2026</td>

                <td>

                    <span class="badge badge-warning">

                        Dipinjam

                    </span>

                </td>

                <td>

                    <a href="/loans/edit"
                       class="btn btn-warning btn-sm">

                        Edit

                    </a>

                    <button class="btn btn-danger btn-sm">

                        Hapus

                    </button>

                </td>

            </tr>

            </tbody>

        </table>

    </div>

</div>

@endsection