@extends('layouts.app')

@section('title','Riwayat Peminjaman')

@section('content')

<h1 class="h3 mb-4 text-gray-800">

Riwayat Peminjaman Saya

</h1>

<div class="card shadow">

    <div class="card-body">

        <table class="table table-bordered">

            <thead>

            <tr>

                <th>No</th>
                <th>Buku</th>
                <th>Tanggal Pinjam</th>
                <th>Status</th>

            </tr>

            </thead>

            <tbody>

            <tr>

                <td>1</td>
                <td>Laravel 12</td>
                <td>18 Juni 2026</td>

                <td>

                    <span class="badge badge-success">

                        Dikembalikan

                    </span>

                </td>

            </tr>

            </tbody>

        </table>

    </div>

</div>

@endsection