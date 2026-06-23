@extends('layouts.app')

@section('title', 'Daftar User')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">👥 Daftar User</h5>
                    <a href="{{ route('user.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-user-plus"></i> Registrasi User
                    </a>
                </div>
                <div class="card-body">
                    <!-- Form Pencarian -->
                    <form action="{{ route('user.index') }}" method="GET" class="mb-4">
                        <div class="row g-2">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control"
                                        placeholder="Cari user (nama, email)..."
                                        value="{{ $keyword ?? '' }}">
                                    <button class="btn btn-primary" type="submit">
                                        <i class="fas fa-search"></i> Cari
                                    </button>
                                    @if(isset($keyword) && $keyword)
                                    <a href="{{ route('user.index') }}" class="btn btn-danger">
                                        <i class="fas fa-times"></i>
                                    </a>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-3">
                                <select name="role" class="form-select" onchange="this.form.submit()">
                                    <option value="">Semua Role</option>
                                    <option value="admin" {{ ($roleFilter ?? '') == 'admin' ? 'selected' : '' }}>Admin</option>
                                    <option value="user" {{ ($roleFilter ?? '') == 'user' ? 'selected' : '' }}>User</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <a href="{{ route('user.index') }}" class="btn btn-outline-secondary w-100">
                                    <i class="fas fa-sync"></i> Reset
                                </a>
                            </div>
                        </div>
                    </form>

                    <!-- Statistik (Hanya 3 Card: Total, Admin, User) -->
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="card bg-primary text-white">
                                <div class="card-body text-center">
                                    <h5 class="mb-0">{{ $totalUsers }}</h5>
                                    <small>Total User</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-danger text-white">
                                <div class="card-body text-center">
                                    <h5 class="mb-0">{{ $totalAdmins }}</h5>
                                    <small>Admin</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-info text-white">
                                <div class="card-body text-center">
                                    <h5 class="mb-0">{{ $totalUsersRole }}</h5>
                                    <small>User</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Alert -->
                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    @endif

                    @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    @endif

                    <!-- Tabel User -->
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Tanggal Daftar</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($users as $index => $user)
                                <tr>
                                    <td>{{ $users->firstItem() + $index }}</td>
                                    <td><strong>{{ $user->name }}</strong></td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @if($user->role == 'admin')
                                        <span class="badge bg-danger">Admin</span>
                                        @else
                                        <span class="badge bg-info">User</span>
                                        @endif
                                    </td>
                                    <td>{{ $user->created_at ? $user->created_at->format('d-m-Y H:i') : '-' }}</td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('user.show', $user->id) }}"
                                                class="btn btn-info" title="Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('user.edit', $user->id) }}"
                                                class="btn btn-warning" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('user.destroy', $user->id) }}"
                                                method="POST" class="d-inline"
                                                onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger" title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">
                                        <i class="fas fa-users fa-2x text-muted d-block mb-2"></i>
                                        <span class="text-muted">Belum ada user terdaftar</span>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center">
                        {{ $users->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection