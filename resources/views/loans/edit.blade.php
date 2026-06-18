@extends('layouts.app')

@section('title','Edit Peminjaman')

@section('content')

<h1 class="h3 mb-4 text-gray-800">

Edit Peminjaman

</h1>

<div class="card shadow">

    <div class="card-body">

        <form>

            <div class="form-group">

                <label>Nama Peminjam</label>

                <select class="form-control">

                    <option selected>Admin</option>

                </select>

            </div>

            <div class="form-group">

                <label>Buku</label>

                <select class="form-control">

                    <option selected>Laravel 12</option>

                </select>

            </div>

            <div class="form-group">

                <label>Tanggal Pinjam</label>

                <input
                    type="date"
                    class="form-control"
                    value="2026-06-18">

            </div>

            <button class="btn btn-primary">

                Update

            </button>

            <a href="/loans"
               class="btn btn-secondary">

                Kembali

            </a>

        </form>

    </div>

</div>

@endsection