@extends('layouts.app')

@section('title','Edit Buku')

@section('content')

<h1 class="h3 mb-4 text-gray-800">

Edit Buku

</h1>

<div class="card shadow">

    <div class="card-body">

        <form>

            <div class="form-group">

                <label>Judul Buku</label>

                <input
                    type="text"
                    class="form-control"
                    value="Laravel 12">

            </div>

            <div class="form-group">

                <label>Pengarang</label>

                <input
                    type="text"
                    class="form-control"
                    value="Abdul Kadir">

            </div>

            <div class="form-group">

                <label>Penerbit</label>

                <input
                    type="text"
                    class="form-control"
                    value="Informatika">

            </div>

            <div class="form-group">

                <label>Stok</label>

                <input
                    type="number"
                    class="form-control"
                    value="5">

            </div>

            <button class="btn btn-primary">

                Update

            </button>

            <a href="/books"
               class="btn btn-secondary">

                Kembali

            </a>

        </form>

    </div>

</div>

@endsection