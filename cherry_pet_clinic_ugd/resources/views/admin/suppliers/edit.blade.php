@extends('admin.layouts.app')

@section('title', 'Edit Supplier')
@section('page-title', 'Edit Supplier')

@section('content')
<div class="container-fluid" style="background-color: #E8F4F8; min-height: 100vh; padding: 2rem 0;">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            <!-- Back Button -->
            <div class="mb-4">
                <a href="{{ route('admin.suppliers.show', $supplier) }}"
                   class="btn btn-link text-decoration-none p-0 text-primary-custom">
                    <i class="fas fa-arrow-left me-2"></i> Kembali
                </a>
            </div>

            <!-- Success Alert -->
            @if(session('success'))
            <div class="alert alert-success-custom alert-dismissible fade show" role="alert">
                <div class="d-flex align-items-center">
                    <i class="fas fa-check-circle me-2"></i>
                    <span>{{ session('success') }}</span>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            <!-- Form Card -->
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <form action="{{ route('admin.suppliers.update', $supplier) }}" method="POST" id="editForm">
                        @csrf
                        @method('PUT')

                        <!-- ID Supplier -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-dark">ID Supplier</label>
                            <input type="text" value="#{{ $supplier->id }}" disabled
                                class="form-control bg-light-custom border-custom">
                        </div>

                        <!-- Nama Supplier -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-dark">
                                Nama Supplier <span class="text-danger-custom">*</span>
                            </label>
                            <input type="text" name="nama_supplier"
                                value="{{ old('nama_supplier', $supplier->nama_supplier) }}"
                                class="form-control border-custom @error('nama_supplier') is-invalid @enderror"
                                placeholder="PT. Sejahtera Medika">
                            @error('nama_supplier')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- NIB -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-dark">
                                NIB <span class="text-danger-custom">*</span>
                            </label>
                            <input type="text" name="nib"
                                value="{{ old('nib', $supplier->nib) }}"
                                class="form-control border-custom @error('nib') is-invalid @enderror"
                                placeholder="1276189002457">
                            @error('nib')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Kategori (Auto) -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-dark">Kategori</label>
                            <input type="text" value="{{ $supplier->kategori->nama_kategori }}" disabled
                                class="form-control bg-light-custom border-custom">
                            <div class="form-text text-secondary">
                                <i class="fas fa-info-circle me-1"></i>
                                Otomatis berdasarkan jenis barang
                            </div>
                        </div>

                        <!-- Jenis Barang -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-dark">
                                Jenis Barang <span class="text-danger-custom">*</span>
                            </label>
                            <select name="jenis_barang_id"
                                class="form-select border-custom @error('jenis_barang_id') is-invalid @enderror">
                                <option value="">Pilih jenis barang</option>
                                @foreach($jenisBarangs->groupBy('kategori.nama_kategori') as $kat => $items)
                                    <optgroup label="{{ $kat }}">
                                        @foreach($items as $j)
                                            <option value="{{ $j->id }}"
                                                {{ old('jenis_barang_id', $supplier->jenis_barang_id) == $j->id ? 'selected' : '' }}>
                                                {{ $j->nama_jenis }}
                                            </option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            </select>
                            @error('jenis_barang_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Alamat -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-dark">
                                Alamat <span class="text-danger-custom">*</span>
                            </label>
                            <textarea name="alamat" rows="3"
                                class="form-control border-custom @error('alamat') is-invalid @enderror"
                                placeholder="Jl. Kesehatan No.1">{{ old('alamat', $supplier->alamat) }}</textarea>
                            @error('alamat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Kontak -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-dark">
                                Kontak <span class="text-danger-custom">*</span>
                            </label>
                            <input type="text" name="kontak"
                                value="{{ old('kontak', $supplier->kontak) }}"
                                class="form-control border-custom @error('kontak') is-invalid @enderror"
                                placeholder="081329891201">
                            @error('kontak')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-dark">
                                Status <span class="text-danger-custom">*</span>
                            </label>
                            <select name="status"
                                class="form-select border-custom @error('status') is-invalid @enderror">
                                <option value="aktif" {{ old('status', $supplier->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="tidak_aktif" {{ old('status', $supplier->status) == 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Actions -->
                        <div class="d-flex gap-2 pt-3 border-top border-light-custom">
                            <a href="{{ route('admin.suppliers.show', $supplier) }}"
                               class="btn btn-secondary-custom flex-fill">
                                <i class="fas fa-times me-2"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-success-custom flex-fill">
                                <i class="fas fa-save me-2"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Danger Zone -->
            <div class="card border-danger-custom mt-4">
                <div class="card-body bg-danger-light">
                    <h5 class="card-title text-danger-custom fw-bold mb-2">
                        <i class="fas fa-exclamation-triangle me-2"></i> Zona Berbahaya
                    </h5>
                    <p class="card-text text-danger-custom mb-3">
                        Data supplier akan dihapus permanen dan tidak dapat dikembalikan.
                    </p>
                    <form action="{{ route('admin.suppliers.destroy', $supplier) }}" method="POST"
                          onsubmit="return confirm('⚠️ Yakin ingin menghapus supplier ini?\n\nData yang terhapus tidak dapat dikembalikan!');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger-custom">
                            <i class="fas fa-trash me-2"></i> Hapus Supplier
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

@push('styles')
<style>
    /* Color Variables */
    :root {
        --primary-dark: #003D7A;
        --primary-medium: #0066B3;
        --error-color: #E31E24;
        --error-hover: #FF4444;
        --success-color: #1FBD88;
        --warning-color: #F59E0B;
        --bg-light: #F5F7FA;
        --bg-very-light: #E8F4F8;
        --text-dark: #1A1A1A;
        --text-secondary: #424242;
        --text-medium: #757575;
        --text-light: #BDBDBD;
        --border-normal: #D0D0D0;
        --border-light: #E0E0E0;
        --success-bg: #E8F5E9;
        --error-bg: #FFEBEE;
    }

    /* Body Background Override */
    body {
        background-color: var(--bg-very-light) !important;
    }

    /* Main Content Background */
    .container-fluid {
        background-color: var(--bg-very-light) !important;
    }

    /* Text Colors */
    .text-dark {
        color: var(--text-dark) !important;
    }

    .text-secondary {
        color: var(--text-secondary) !important;
    }

    .text-primary-custom {
        color: var(--primary-medium) !important;
    }

    .text-danger-custom {
        color: var(--error-color) !important;
    }

    /* Border Colors */
    .border-custom {
        border-color: var(--border-normal) !important;
    }

    .border-light-custom {
        border-color: var(--border-light) !important;
    }

    .border-danger-custom {
        border-color: var(--error-color) !important;
        border-width: 2px !important;
    }

    /* Background Colors */
    .bg-light-custom {
        background-color: var(--bg-light) !important;
    }

    .bg-danger-light {
        background-color: var(--error-bg) !important;
    }

    /* Card Styling */
    .card {
        transition: all 0.3s ease;
        background-color: white;
    }

    .card:hover {
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
    }

    /* Form Controls */
    .form-control,
    .form-select {
        background-color: var(--bg-light);
        border: 1px solid var(--border-normal);
        color: var(--text-dark);
        transition: all 0.2s ease;
    }

    .form-control:disabled,
    .form-select:disabled {
        background-color: var(--bg-light);
        color: var(--text-medium);
        opacity: 1;
    }

    .form-control:focus,
    .form-select:focus {
        background-color: white;
        border-color: var(--primary-medium);
        box-shadow: 0 0 0 0.25rem rgba(0, 102, 179, 0.15);
    }

    .form-control::placeholder {
        color: var(--text-light);
    }

    /* Buttons */
    .btn {
        transition: all 0.2s ease;
        font-weight: 500;
    }

    .btn:hover:not(:disabled) {
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
    }

    .btn-success-custom {
        background-color: var(--success-color);
        border-color: var(--success-color);
        color: white;
    }

    .btn-success-custom:hover {
        background-color: #1aa876;
        border-color: #1aa876;
        color: white;
    }

    .btn-secondary-custom {
        background-color: var(--text-medium);
        border-color: var(--text-medium);
        color: white;
    }

    .btn-secondary-custom:hover {
        background-color: var(--text-secondary);
        border-color: var(--text-secondary);
        color: white;
    }

    .btn-danger-custom {
        background-color: var(--error-color);
        border-color: var(--error-color);
        color: white;
    }

    .btn-danger-custom:hover {
        background-color: var(--error-hover);
        border-color: var(--error-hover);
        color: white;
    }

    /* Form Label */
    .form-label {
        margin-bottom: 0.5rem;
        color: var(--text-dark);
        font-weight: 600;
    }

    /* Form Text */
    .form-text {
        color: var(--text-secondary);
        font-size: 0.875rem;
    }

    /* Invalid Feedback */
    .invalid-feedback {
        display: block;
        color: var(--error-color);
    }

    .is-invalid {
        border-color: var(--error-color) !important;
    }

    .is-invalid:focus {
        box-shadow: 0 0 0 0.25rem rgba(227, 30, 36, 0.15) !important;
    }

    /* Alert Styling */
    .alert-success-custom {
        background-color: var(--success-bg);
        border-color: var(--success-color);
        color: var(--text-dark);
    }

    .alert-success-custom .fas {
        color: var(--success-color);
    }

    /* Optgroup Styling */
    optgroup {
        font-weight: 600;
        color: var(--text-dark);
    }

    option {
        color: var(--text-dark);
    }

    /* Link Styling */
    .btn-link {
        font-weight: 500;
    }

    .btn-link:hover {
        text-decoration: underline !important;
    }
</style>
@endpush
@endsection
