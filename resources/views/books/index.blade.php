@extends('layouts.app')

@section('title','Data Buku')

@section('content')

<h1 class="h3 mb-4 text-gray-800">
    Data Buku
</h1>

<a href="/books/create" class="btn btn-primary mb-3">

    <i class="fas fa-plus"></i>

    Tambah Buku

</a>

<div class="card shadow">

    <div class="card-header py-3">

        <h6 class="m-0 font-weight-bold text-primary">
            Daftar Buku
        </h6>

    </div>

    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-bordered">

                <thead>

                    <tr>

                        <th>No</th>
                        <th>Judul</th>
                        <th>Pengarang</th>
                        <th>Penerbit</th>
                        <th>Stok</th>
                        <th>Status</th>
                        <th>Aksi</th>

                    </tr>

                </thead>

                <tbody>

                    <tr>

                        <td>1</td>
                        <td>Laravel 12</td>
                        <td>Abdul Kadir</td>
                        <td>Informatika</td>
                        <td>5</td>

                        <td>

                            <span class="badge badge-success">

                                Tersedia

                            </span>

                        </td>

                        <td>

                            <a href="/books/edit"
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

</div>

@endsection