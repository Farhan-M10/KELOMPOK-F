@extends('admin.layouts.app')

@section('title', 'Edit Jenis Barang')
@section('page-title', 'Edit Jenis Barang')

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
                    <li class="breadcrumb-item active" aria-current="page">Edit</li>
                </ol>
            </nav>

            <!-- Form Card -->
            <div class="card border-0 shadow-sm">
                <!-- Header -->
                <div class="card-header bg-success text-white border-0 py-4">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle bg-white bg-opacity-25 p-2 me-3">
                            <i class="fas fa-edit fs-4"></i>
                        </div>
                        <div>
                            <h4 class="mb-1 fw-bold">Edit Jenis Barang</h4>
                            <p class="mb-0 small opacity-75">Perbarui informasi jenis barang</p>
                        </div>
                    </div>
                </div>

                <!-- Form Body -->
                <div class="card-body p-4">
                    <form action="{{ route('admin.jenis_barang.update', $jenisBarang) }}" method="POST">
                        @csrf
                        @method('PUT')

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
                                        {{ old('kategori_id', $jenisBarang->kategori_id) == $kategori->id ? 'selected' : '' }}>
                                        {{ $kategori->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kategori_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Nama Jenis -->
                        <div class="mb-4">
                            <label for="nama_jenis" class="form-label fw-semibold">
                                Nama Jenis <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                   name="nama_jenis"
                                   id="nama_jenis"
                                   value="{{ old('nama_jenis', $jenisBarang->nama_jenis) }}"
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
                                      class="form-control @error('deskripsi') is-invalid @enderror">{{ old('deskripsi', $jenisBarang->deskripsi) }}</textarea>
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
                            <button type="submit" class="btn btn-success btn-lg flex-fill">
                                <i class="fas fa-save me-2"></i>
                                Perbarui Data
                            </button>
                            <a href="{{ route('admin.jenis_barang.index') }}"
                               class="btn btn-secondary btn-lg flex-fill">
                                <i class="fas fa-times me-2"></i>
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Warning Card -->
            <div class="alert alert-warning mt-4 border-0 shadow-sm" role="alert">
                <div class="d-flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-triangle fs-5"></i>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="alert-heading fw-bold mb-2">
                            <i class="fas fa-exclamation-circle me-1"></i>
                            Perhatian
                        </h6>
                        <ul class="mb-0 small">
                            <li class="mb-1">Pastikan nama jenis tidak bentrok dengan jenis barang lain</li>
                            <li class="mb-1">Perubahan data akan mempengaruhi semua data terkait</li>
                            <li class="mb-0">Periksa kembali data sebelum menyimpan</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Info Data -->
            <div class="card border-0 shadow-sm mt-4 bg-light">
                <div class="card-body">
                    <h6 class="fw-bold mb-3">
                        <i class="fas fa-info-circle text-primary me-2"></i>
                        Informasi Data Saat Ini
                    </h6>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <small class="text-muted d-block mb-1">Dibuat pada:</small>
                            <span class="fw-medium">
                                <i class="fas fa-calendar-alt text-muted me-1"></i>
                                {{ $jenisBarang->created_at->format('d M Y, H:i') }}
                            </span>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted d-block mb-1">Terakhir diubah:</small>
                            <span class="fw-medium">
                                <i class="fas fa-clock text-muted me-1"></i>
                                {{ $jenisBarang->updated_at->format('d M Y, H:i') }}
                            </span>
                        </div>
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
        border-color: #198754;
        box-shadow: 0 0 0 0.25rem rgba(25, 135, 84, 0.15);
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
    }

    .alert-warning {
        background-color: #fff3cd;
        color: #856404;
    }

    .invalid-feedback {
        display: block;
        margin-top: 0.25rem;
    }

    .form-text {
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }

    .bg-light {
        background-color: #f8f9fa !important;
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

        // Track form changes
        const form = document.querySelector('form');
        const btnBatal = document.querySelector('.btn-secondary');
        let originalFormData = new FormData(form);
        let formChanged = false;

        // Detect changes
        form.addEventListener('input', function() {
            formChanged = true;
        });

        form.addEventListener('change', function() {
            formChanged = true;
        });

        // Confirm before leaving if changed
        btnBatal.addEventListener('click', function(e) {
            if (formChanged) {
                if (!confirm('Ada perubahan yang belum disimpan. Yakin ingin membatalkan?')) {
                    e.preventDefault();
                }
            }
        });

        // Prevent accidental navigation
        window.addEventListener('beforeunload', function(e) {
            if (formChanged) {
                e.preventDefault();
                e.returnValue = '';
            }
        });

        // Clear flag when submitting
        form.addEventListener('submit', function() {
            formChanged = false;
        });

        // Validasi form
        form.addEventListener('submit', function(e) {
            const kategoriId = document.getElementById('kategori_id').value;
            const namaJenis = document.getElementById('nama_jenis').value;

            if (!kategoriId || !namaJenis) {
                e.preventDefault();
                alert('Mohon lengkapi semua field yang wajib diisi (*)');
                return false;
            }
        });

        // Auto-grow textarea
        const textarea = document.getElementById('deskripsi');
        if (textarea) {
            textarea.addEventListener('input', function() {
                this.style.height = 'auto';
                this.style.height = (this.scrollHeight) + 'px';
            });
        }
    });
</script>
@endpush
@endsection
