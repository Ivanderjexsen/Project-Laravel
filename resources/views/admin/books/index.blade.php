@extends('layouts.app')

@section('title', 'Daftar Buku')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">📚 Daftar Buku</h5>
                    <div>
                        <a href="{{ route('buku.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Tambah Buku
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('buku.index') }}" method="GET" class="mb-4">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control"
                                placeholder="Cari buku di database..."
                                value="{{ $keyword ?? '' }}">
                            <button class="btn btn-outline-secondary" type="submit">
                                <i class="fas fa-search"></i> Cari
                            </button>
                            @if(isset($keyword) && $keyword)
                            <a href="{{ route('buku.index') }}" class="btn btn-outline-danger">
                                <i class="fas fa-times"></i>
                            </a>
                            @endif
                        </div>
                    </form>

                    <div id="ol-results" class="mb-4" style="display: none;">
                        <h6>Hasil Pencarian OpenLibrary:</h6>
                        <div id="ol-results-list" class="row"></div>
                    </div>

                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    @endif

                    @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Kode Buku</th>
                                    <th>Judul Buku</th>
                                    <th>Pengarang</th>
                                    <th>Penerbit</th>
                                    <th>Stok</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($bukus as $index => $buku)
                                <tr>
                                    <td>{{ $bukus->firstItem() + $index }}</td>
                                    <td><span class="badge bg-primary">{{ $buku->kode_buku }}</span></td>
                                    <td>{{ $buku->judul_buku }}</td>
                                    <td>{{ $buku->pengarang }}</td>
                                    <td>{{ $buku->penerbit }}</td>
                                    <td>{{ $buku->stok }}</td>
                                    <td>
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="{{ route('buku.show', $buku->id) }}"
                                                class="btn btn-info" title="Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('buku.edit', $buku->id) }}"
                                                class="btn btn-warning" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('buku.destroy', $buku->id) }}"
                                                method="POST" class="d-inline"
                                                onsubmit="return confirm('Yakin ingin menghapus buku ini?')">
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
                                    <td colspan="7" class="text-center">Tidak ada data buku</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center">
                        {{ $bukus->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('openlibrary-search');
        const searchBtn = document.getElementById('btn-search-ol');
        const resultsDiv = document.getElementById('ol-results');
        const resultsList = document.getElementById('ol-results-list');

        function searchOpenLibrary() {
            const query = searchInput.value.trim();

            if (query.length < 2) {
                resultsDiv.style.display = 'none';
                return;
            }

            resultsDiv.style.display = 'block';
            resultsList.innerHTML = '<div class="text-center">Loading...</div>';

            fetch(`{{ route('buku.search') }}?q=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(data => {
                    if (data.docs && data.docs.length > 0) {
                        let html = '';
                        data.docs.forEach(book => {
                            const coverUrl = book.cover_url || 'https://via.placeholder.com/100x150?text=No+Cover';
                            html += `
                                <div class="col-md-4 mb-3">
                                    <div class="card h-100">
                                        <img src="${coverUrl}" class="card-img-top" alt="${book.title}" 
                                             style="height: 200px; object-fit: cover;">
                                        <div class="card-body">
                                            <h6 class="card-title">${book.title}</h6>
                                            <p class="card-text small">
                                                <strong>Pengarang:</strong> ${book.author_name}<br>
                                                <strong>Penerbit:</strong> ${book.publisher}<br>
                                                <strong>Tahun:</strong> ${book.first_publish_year || '-'}
                                            </p>
                                            <button class="btn btn-success btn-sm btn-add-book" 
                                                    data-title="${book.title}"
                                                    data-author="${book.author_name}"
                                                    data-publisher="${book.publisher}">
                                                <i class="fas fa-plus"></i> Tambah ke Database
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            `;
                        });
                        resultsList.innerHTML = html;

                        document.querySelectorAll('.btn-add-book').forEach(btn => {
                            btn.addEventListener('click', function() {
                                const title = this.dataset.title;
                                const author = this.dataset.author;
                                const publisher = this.dataset.publisher;

                                window.location.href = `{{ route('buku.create') }}?judul_buku=${encodeURIComponent(title)}&pengarang=${encodeURIComponent(author)}&penerbit=${encodeURIComponent(publisher)}`;
                            });
                        });
                    } else {
                        resultsList.innerHTML = '<div class="col-12 text-center text-muted">Tidak ada hasil ditemukan</div>';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    resultsList.innerHTML = '<div class="col-12 text-center text-danger">Terjadi kesalahan. Silakan coba lagi.</div>';
                });
        }

        searchBtn.addEventListener('click', searchOpenLibrary);
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                searchOpenLibrary();
            }
        });
        searchInput.addEventListener('input', function() {
            if (this.value.trim().length < 2) {
                resultsDiv.style.display = 'none';
            }
        });
    });
</script>
@endpush
@endsection