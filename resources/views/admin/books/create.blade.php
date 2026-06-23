@extends('layouts.app')

@section('title', 'Tambah Buku')

@section('content')

<div class="row">
    <div class="col-12">
        <h1 class="h3 mb-4 text-gray-800">
            <i class="fas fa-plus-circle me-2 text-primary"></i>Tambah Buku
        </h1>
    </div>
</div>

<div class="row">
    <!-- FORM UTAMA -->
    <div class="col-lg-8">
        <div class="card shadow">
            <div class="card-header py-3 d-flex align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-book-open me-2"></i>Formulir Tambah Buku
                </h6>
                <span class="ms-auto badge bg-primary text-white">
                    <i class="fas fa-tag me-1"></i> Kode Otomatis
                </span>
            </div>
            <div class="card-body">
                <form action="{{ route('buku.store') }}" method="POST" id="formTambahBuku" novalidate>
                    @csrf

                    <!-- FITUR CARI DARI OPENLIBRARY -->
                    <div class="card bg-light border-0 mb-4">
                        <div class="card-body py-3">
                            <div class="row g-2 align-items-center">
                                <div class="col-12">
                                    <div class="input-group">
                                        <span class="input-group-text bg-white border-end-0">
                                            <i class="fas fa-cloud-upload-alt text-primary"></i>
                                        </span>
                                        <input
                                            type="text"
                                            id="cariBukuOnline"
                                            class="form-control border-start-0"
                                            placeholder="Cari buku dari OpenLibrary (ketik judul)..."
                                            aria-label="Cari buku online">
                                        <button class="btn btn-primary" type="button" id="btnCariBuku">
                                            <i class="fas fa-search me-1"></i> Cari
                                        </button>
                                    </div>
                                    <small class="text-muted">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Isi otomatis dari OpenLibrary - Cukup ketik judul buku
                                    </small>
                                    <div id="loadingIndicator" class="d-none mt-1">
                                        <span class="spinner-border spinner-border-sm text-primary me-1" role="status"></span>
                                        <span class="text-muted small">Mencari...</span>
                                    </div>
                                    <div id="hasilPencarian" class="dropdown-menu w-100 mt-2" style="display: none;"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- FORM FIELDS -->
                    <div class="row">
                        <!-- Kolom Kiri -->
                        <div class="col-md-7">
                            <!-- Judul Buku -->
                            <div class="form-group mb-3">
                                <label for="judul_buku" class="fw-bold">
                                    <i class="fas fa-book text-primary me-1"></i> Judul Buku
                                    <span class="text-danger">*</span>
                                </label>
                                <input
                                    type="text"
                                    name="judul_buku"
                                    id="judul_buku"
                                    class="form-control @error('judul_buku') is-invalid @enderror"
                                    value="{{ old('judul_buku') }}"
                                    placeholder="Masukkan judul buku"
                                    required
                                    autofocus>
                                @error('judul_buku')
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-circle me-1"></i> {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <!-- Pengarang -->
                            <div class="form-group mb-3">
                                <label for="pengarang" class="fw-bold">
                                    <i class="fas fa-user text-primary me-1"></i> Pengarang
                                    <span class="text-danger">*</span>
                                </label>
                                <input
                                    type="text"
                                    name="pengarang"
                                    id="pengarang"
                                    class="form-control @error('pengarang') is-invalid @enderror"
                                    value="{{ old('pengarang') }}"
                                    placeholder="Masukkan nama pengarang"
                                    required>
                                @error('pengarang')
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-circle me-1"></i> {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <!-- Penerbit -->
                            <div class="form-group mb-3">
                                <label for="penerbit" class="fw-bold">
                                    <i class="fas fa-building text-primary me-1"></i> Penerbit
                                    <span class="text-danger">*</span>
                                </label>
                                <input
                                    type="text"
                                    name="penerbit"
                                    id="penerbit"
                                    class="form-control @error('penerbit') is-invalid @enderror"
                                    value="{{ old('penerbit') }}"
                                    placeholder="Masukkan nama penerbit"
                                    required>
                                @error('penerbit')
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-circle me-1"></i> {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>

                        <!-- Kolom Kanan -->
                        <div class="col-md-5">
                            <!-- Stok -->
                            <div class="form-group mb-3">
                                <label for="stok" class="fw-bold">
                                    <i class="fas fa-boxes text-primary me-1"></i> Stok
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <button type="button" class="btn btn-outline-secondary" id="stokMinus">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <input
                                        type="number"
                                        name="stok"
                                        id="stok"
                                        class="form-control text-center @error('stok') is-invalid @enderror"
                                        value="{{ old('stok', 1) }}"
                                        placeholder="0"
                                        min="0"
                                        required>
                                    <button type="button" class="btn btn-outline-secondary" id="stokPlus">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                                @error('stok')
                                <div class="invalid-feedback d-block">
                                    <i class="fas fa-exclamation-circle me-1"></i> {{ $message }}
                                </div>
                                @enderror
                                <small class="text-muted">
                                    <i class="fas fa-info-circle me-1"></i> Stok minimal 0 (boleh kosong)
                                </small>
                            </div>

                            <!-- Kode Buku (otomatis) -->
                            <div class="form-group mb-3">
                                <label class="fw-bold">
                                    <i class="fas fa-code text-primary me-1"></i> Kode Buku
                                </label>
                                <div class="form-control bg-light text-dark fw-semibold" style="cursor: default;">
                                    <i class="fas fa-sync-alt fa-fw text-primary me-1"></i>
                                    B-{{ date('Y') }}{{ date('m') }}-XXX
                                </div>
                                <small class="text-muted">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Otomatis dibuat sistem dengan format <code>B-YYYYMM-XXX</code>
                                </small>
                            </div>
                        </div>
                    </div>

                    <!-- TOMBOL AKSI -->
                    <div class="d-flex flex-wrap gap-2 mt-4 pt-3 border-top">
                        <button type="submit" class="btn btn-primary px-5" id="btnSimpan">
                            <i class="fas fa-save me-2"></i> Simpan Buku
                        </button>
                        <button type="reset" class="btn btn-outline-secondary">
                            <i class="fas fa-undo me-1"></i> Reset
                        </button>
                        <a href="{{ route('buku.index') }}" class="btn btn-link text-muted ms-auto">
                            <i class="fas fa-times me-1"></i> Batal
                        </a>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <!-- SIDEBAR INFO -->
    <div class="col-lg-4">
        <!-- Informasi -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-info-circle me-2"></i>Informasi
                </h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <small class="text-muted d-block">
                        <i class="fas fa-check-circle text-success me-1"></i>
                        <strong>Kode Buku</strong>
                    </small>
                    <p class="small mb-0">Otomatis dibuat sistem dengan format <code>B-YYYYMM-XXX</code></p>
                </div>
                <div class="mb-3">
                    <small class="text-muted d-block">
                        <i class="fas fa-shield-alt text-warning me-1"></i>
                        <strong>Cegah Duplikat</strong>
                    </small>
                    <p class="small mb-0">Sistem akan menolak jika kombinasi <strong>judul, pengarang, penerbit</strong> sudah ada.</p>
                </div>
                <div>
                    <small class="text-muted d-block">
                        <i class="fas fa-cloud text-primary me-1"></i>
                        <strong>OpenLibrary</strong>
                    </small>
                    <p class="small mb-0">Gunakan fitur pencarian untuk mengisi data otomatis dari OpenLibrary.</p>
                </div>
            </div>
        </div>

        <!-- Tips -->
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-lightbulb me-2"></i>Tips
                </h6>
            </div>
            <div class="card-body">
                <ul class="small list-unstyled mb-0">
                    <li class="mb-2">
                        <i class="fas fa-check-circle text-success me-1"></i>
                        Pastikan data buku sudah benar
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-check-circle text-success me-1"></i>
                        Cek apakah buku sudah ada di database
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-check-circle text-success me-1"></i>
                        Gunakan fitur OpenLibrary untuk menghemat waktu
                    </li>
                    <li>
                        <i class="fas fa-check-circle text-success me-1"></i>
                        Stok minimal 0 (boleh kosong)
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        let searchTimeout;

        // === SEARCH BUKU DARI OPENLIBRARY ===
        function searchBooks(query) {
            $('#loadingIndicator').removeClass('d-none');
            $('#hasilPencarian').hide().empty();

            $.ajax({
                url: '{{ route("buku.search") }}',
                method: 'GET',
                data: {
                    q: query
                },
                success: function(response) {
                    $('#loadingIndicator').addClass('d-none');

                    if (response.docs && response.docs.length > 0) {
                        let html = '<div class="dropdown-item text-muted small fw-bold">📚 Hasil Pencarian:</div>';
                        html += '<div class="dropdown-divider"></div>';

                        response.docs.slice(0, 5).forEach(book => {
                            const title = book.title || 'Judul tidak diketahui';
                            const author = book.author_name ? book.author_name.join(', ') : 'Tidak diketahui';
                            const publisher = book.publisher ? book.publisher[0] : '';

                            html += `
                                <a href="#" class="dropdown-item pilih-buku" 
                                   data-title="${title.replace(/"/g, '&quot;')}"
                                   data-author="${author.replace(/"/g, '&quot;')}"
                                   data-publisher="${publisher.replace(/"/g, '&quot;')}">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-book me-2 text-primary"></i>
                                        <div>
                                            <div class="fw-bold small">${title}</div>
                                            <div class="text-muted small">${author} ${publisher ? '| '+publisher : ''}</div>
                                        </div>
                                    </div>
                                </a>
                            `;
                        });

                        $('#hasilPencarian').html(html).show();
                    } else {
                        $('#hasilPencarian').html(`
                            <div class="dropdown-item text-muted text-center py-3">
                                <i class="fas fa-search me-1"></i> Buku tidak ditemukan
                            </div>
                        `).show();
                    }
                },
                error: function() {
                    $('#loadingIndicator').addClass('d-none');
                    $('#hasilPencarian').html(`
                        <div class="dropdown-item text-danger text-center py-3">
                            <i class="fas fa-exclamation-circle me-1"></i> Gagal mencari buku
                        </div>
                    `).show();
                }
            });
        }

        // === EVENT: KETIK DI INPUT PENCARIAN ===
        $('#cariBukuOnline').on('keyup', function() {
            clearTimeout(searchTimeout);
            const query = $(this).val().trim();

            if (query.length < 2) {
                $('#hasilPencarian').hide().empty();
                return;
            }

            searchTimeout = setTimeout(() => {
                searchBooks(query);
            }, 500);
        });

        // === EVENT: KLIK TOMBOL CARI ===
        $('#btnCariBuku').on('click', function() {
            const query = $('#cariBukuOnline').val().trim();
            if (query.length >= 2) {
                searchBooks(query);
            } else {
                Swal.fire({
                    icon: 'info',
                    title: 'Masukkan Judul Buku',
                    text: 'Ketik minimal 2 karakter untuk mencari buku',
                    confirmButtonColor: '#3085d6'
                });
            }
        });

        // === EVENT: PILIH HASIL PENCARIAN ===
        $(document).on('click', '.pilih-buku', function(e) {
            e.preventDefault();

            $('#judul_buku').val($(this).data('title')).trigger('change');
            $('#pengarang').val($(this).data('author')).trigger('change');
            const publisher = $(this).data('publisher');
            if (publisher) {
                $('#penerbit').val(publisher).trigger('change');
            }

            $('#hasilPencarian').hide();
            $('#cariBukuOnline').val('');

            Swal.fire({
                icon: 'success',
                title: 'Data Terisi!',
                text: 'Data buku berhasil diisi otomatis dari OpenLibrary',
                timer: 1500,
                showConfirmButton: false,
                toast: true,
                position: 'top-end'
            });
        });

        // === CLICK OUTSIDE: Sembunyikan hasil pencarian ===
        $(document).on('click', function(e) {
            if (!$(e.target).closest('#cariBukuOnline, #btnCariBuku, #hasilPencarian').length) {
                $('#hasilPencarian').hide();
            }
        });

        // === STOK COUNTER ===
        $('#stokMinus').on('click', function() {
            let stok = parseInt($('#stok').val()) || 0;
            if (stok > 0) {
                $('#stok').val(stok - 1).trigger('input');
            }
        });

        $('#stokPlus').on('click', function() {
            let stok = parseInt($('#stok').val()) || 0;
            $('#stok').val(stok + 1).trigger('input');
        });

        $('#stok').on('input', function() {
            let val = parseInt($(this).val()) || 0;
            if (val < 0) $(this).val(0);
        });

        // === VALIDASI SEBELUM SUBMIT ===
        $('#formTambahBuku').on('submit', function(e) {
            const judul = $('#judul_buku').val().trim();
            const pengarang = $('#pengarang').val().trim();
            const penerbit = $('#penerbit').val().trim();

            if (!judul || !pengarang || !penerbit) {
                e.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Data Belum Lengkap!',
                    text: 'Mohon isi semua field yang bertanda * (wajib)',
                    confirmButtonColor: '#3085d6'
                });
                return false;
            }

            $('#btnSimpan').html(`
                <span class="spinner-border spinner-border-sm me-2" role="status"></span>
                Menyimpan...
            `).prop('disabled', true);
        });
    });
</script>
@endpush