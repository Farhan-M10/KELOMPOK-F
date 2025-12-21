@extends('admin.layouts.app')

@section('title', 'Tambah Jenis Barang')
@section('page-title', 'Tambah Jenis Barang')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.kategori.index') }}" class="text-decoration-none">
                            <i class="fas fa-tags me-1"></i> Kategori
                        </a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.jenis_barang.index') }}" class="text-decoration-none">
                            <i class="fas fa-boxes me-1"></i> Jenis Barang
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Tambah Baru</li>
                </ol>
            </nav>

            <!-- Form Card -->
            <div class="card border-0 shadow-sm">
                <!-- Header -->
                <div class="card-header bg-primary text-white border-0 py-4">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle bg-white bg-opacity-25 p-2 me-3">
                            <i class="fas fa-plus-circle fs-4"></i>
                        </div>
                        <div>
                            <h4 class="mb-1 fw-bold">Tambah Jenis Barang Baru</h4>
                            <p class="mb-0 small opacity-75">Lengkapi informasi jenis barang</p>
                        </div>
                    </div>
                </div>

                <!-- Form Body -->
                <div class="card-body p-4">
                    <form action="{{ route('admin.jenis_barang.store') }}" method="POST">
                        @csrf

                        <!-- Kategori -->
                        <div class="mb-4">
                            <label for="kategori_id" class="form-label fw-semibold">
                                Kategori <span class="text-danger">*</span>
                            </label>
                            <select name="kategori_id"
                                    id="kategori_id"
                                    class="form-select form-select-lg @error('kategori_id') is-invalid @enderror"
                                    required>
                                <option value="">Pilih Kategori</option>
                                @foreach($kategoris as $kategori)
                                    <option value="{{ $kategori->id }}"
                                        {{ old('kategori_id', request('kategori_id')) == $kategori->id ? 'selected' : '' }}>
                                        {{ $kategori->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kategori_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Kode Jenis -->
                        {{-- <div class="mb-4">
                            <label for="kode_jenis" class="form-label fw-semibold">
                                Kode Jenis <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                   name="kode_jenis"
                                   id="kode_jenis"
                                   value="{{ old('kode_jenis') }}"
                                   placeholder="Contoh: OB123456"
                                   class="form-control form-control-lg @error('kode_jenis') is-invalid @enderror"
                                   style="font-family: 'Courier New', monospace;"
                                   required>
                            @error('kode_jenis')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                <i class="fas fa-info-circle me-1"></i>
                                Kode unik untuk identifikasi jenis barang
                            </div>
                        </div> --}}

                        <!-- Nama Jenis -->
                        <div class="mb-4">
                            <label for="nama_jenis" class="form-label fw-semibold">
                                Nama Jenis <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                   name="nama_jenis"
                                   id="nama_jenis"
                                   value="{{ old('nama_jenis') }}"
                                   placeholder="Contoh: Obat Hewan"
                                   class="form-control form-control-lg @error('nama_jenis') is-invalid @enderror"
                                   required>
                            @error('nama_jenis')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Deskripsi -->
                        <div class="mb-4">
                            <label for="deskripsi" class="form-label fw-semibold">
                                Deskripsi
                            </label>
                            <textarea name="deskripsi"
                                      id="deskripsi"
                                      rows="4"
                                      placeholder="Deskripsi singkat tentang jenis barang ini..."
                                      class="form-control @error('deskripsi') is-invalid @enderror">{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                <i class="fas fa-info-circle me-1"></i>
                                Opsional - Tambahkan deskripsi untuk informasi lebih detail
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex gap-2 pt-4 border-top">
                            <button type="submit" class="btn btn-primary btn-lg flex-fill">
                                <i class="fas fa-save me-2"></i>
                                Simpan Data
                            </button>
                            <a href="{{ route('admin.jenis_barang.index', ['kategori_id' => request('kategori_id')]) }}"
                               class="btn btn-secondary btn-lg flex-fill">
                                <i class="fas fa-times me-2"></i>
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Info Card -->
            <div class="alert alert-info mt-4" role="alert">
                <div class="d-flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-info-circle fs-5"></i>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="alert-heading fw-bold mb-2">
                            <i class="fas fa-lightbulb me-1"></i>
                            Informasi Penting
                        </h6>
                        <ul class="mb-0 small">
                            {{-- <li class="mb-1">Kode jenis harus unik dan tidak boleh sama dengan jenis barang lain</li> --}}
                            <li class="mb-1">Pastikan memilih kategori yang sesuai dengan jenis barang</li>
                            <li class="mb-0">Deskripsi bersifat opsional namun disarankan untuk diisi</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .breadcrumb-item + .breadcrumb-item::before {
        content: "›";
        font-weight: bold;
    }

    .card {
        border-radius: 0.75rem;
        overflow: hidden;
    }

    .card-header {
        border-radius: 0.75rem 0.75rem 0 0 !important;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
    }

    .form-control-lg,
    .form-select-lg {
        padding: 0.75rem 1rem;
        font-size: 1rem;
    }

    .btn {
        transition: all 0.2s ease;
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
    }

    .alert {
        border-radius: 0.5rem;
        border: none;
    }

    .alert-info {
        background-color: #cfe2ff;
        color: #084298;
    }

    .invalid-feedback {
        display: block;
        margin-top: 0.25rem;
    }

    .form-text {
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }

    @media (max-width: 768px) {
        .d-flex.gap-2 {
            flex-direction: column;
        }

        .btn-lg {
            padding: 0.75rem 1rem;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Auto-focus pada field pertama
        const firstInput = document.getElementById('kategori_id');
        if (firstInput) {
            firstInput.focus();
        }

        // Format kode jenis menjadi uppercase
        // const kodeJenisInput = document.getElementById('kode_jenis');
        // if (kodeJenisInput) {
        //     kodeJenisInput.addEventListener('input', function(e) {
        //         this.value = this.value.toUpperCase();
        //     });
        // }

        // Konfirmasi sebelum kembali jika ada perubahan
        const form = document.querySelector('form');
        const btnBatal = document.querySelector('.btn-secondary');
        let formChanged = false;

        form.addEventListener('input', function() {
            formChanged = true;
        });

        btnBatal.addEventListener('click', function(e) {
            if (formChanged) {
                if (!confirm('Ada perubahan yang belum disimpan. Yakin ingin membatalkan?')) {
                    e.preventDefault();
                }
            }
        });

        // Validasi form sebelum submit
        form.addEventListener('submit', function(e) {
            const kategoriId = document.getElementById('kategori_id').value;
            const kodeJenis = document.getElementById('kode_jenis').value;
            const namaJenis = document.getElementById('nama_jenis').value;

            if (!kategoriId || !kodeJenis || !namaJenis) {
                e.preventDefault();
                alert('Mohon lengkapi semua field yang wajib diisi (*)');
                return false;
            }
        });
    });
</script>
@endpush
@endsection
