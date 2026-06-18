@extends('layouts.app')

@section('title','Tambah Buku')

@section('content')

<h1 class="h3 mb-4 text-gray-800">

Tambah Buku

</h1>

<div class="card shadow">

    <div class="card-body">

        <form>

            <div class="form-group">

                <label>Judul Buku</label>

                <input
                    type="text"
                    class="form-control">

            </div>

            <div class="form-group">

                <label>Pengarang</label>

                <input
                    type="text"
                    class="form-control">

            </div>

            <div class="form-group">

                <label>Penerbit</label>

                <input
                    type="text"
                    class="form-control">

            </div>

            <div class="form-group">

                <label>Stok</label>

                <input
                    type="number"
                    class="form-control">

            </div>

            <button class="btn btn-primary">

                Simpan

            </button>

            <a href="/books"
               class="btn btn-secondary">

                Kembali

            </a>

        </form>

    </div>

</div>

@endsection