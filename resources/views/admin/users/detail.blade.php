@extends('layouts.app')

@section('title', 'Detail User')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header">
                    <h5 class="mb-0">👤 Detail User</h5>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <div class="avatar-circle bg-primary text-white mx-auto"
                            style="width: 80px; height: 80px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 32px;">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <h4 class="mt-2">{{ $user->name }}</h4>
                        <p class="text-muted">{{ $user->email }}</p>
                    </div>

                    <table class="table table-bordered">
                        <tr>
                            <th style="width: 150px;">ID</th>
                            <td>#{{ $user->id }}</td>
                        </tr>
                        <tr>
                            <th>Nama Lengkap</th>
                            <td>{{ $user->name }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $user->email }}</td>
                        </tr>
                        <tr>
                            <th>Role</th>
                            <td>
                                @if($user->role == 'admin')
                                <span class="badge bg-danger">Admin</span>
                                @else
                                <span class="badge bg-info">User</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Tanggal Daftar</th>
                            <td>{{ $user->created_at ? $user->created_at->format('d-m-Y H:i:s') : '-' }}</td>
                        </tr>
                        <tr>
                            <th>Terakhir Update</th>
                            <td>{{ $user->updated_at ? $user->updated_at->format('d-m-Y H:i:s') : '-' }}</td>
                        </tr>
                    </table>

                    <div class="d-flex justify-content-between mt-3">
                        <a href="{{ route('user.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                        <div>
                            <a href="{{ route('user.edit', $user->id) }}" class="btn btn-warning">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form action="{{ route('user.destroy', $user->id) }}" method="POST" class="d-inline"
                                onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection