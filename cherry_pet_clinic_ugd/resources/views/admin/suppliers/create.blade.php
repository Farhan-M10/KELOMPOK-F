@extends('admin.layouts.app')

@section('title', 'Tambah Supplier')
@section('page-title', 'Tambah Supplier Baru')

@section('content')
<div class="container-fluid" style="background-color: #E8F4F8; min-height: 100vh; padding: 2rem 0;">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            <!-- Back Button & Title -->
            <div class="mb-4">
                <a href="{{ route('admin.suppliers.index') }}" class="btn btn-link text-decoration-none p-0 mb-3 text-primary-custom">
                    <i class="fas fa-arrow-left me-2"></i> Kembali
                </a>
                <h4 class="fw-bold mb-0 text-dark">Form Tambah Supplier</h4>
            </div>

            <!-- Form Card -->
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <form action="{{ route('admin.suppliers.store') }}" method="POST" id="supplierForm">
                        @csrf

                        <!-- Nama Supplier -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-dark">
                                Nama Supplier <span class="text-danger-custom">*</span>
                            </label>
                            <input type="text" name="nama_supplier" value="{{ old('nama_supplier') }}"
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
                            <input type="text" name="nib" value="{{ old('nib') }}"
                                class="form-control border-custom @error('nib') is-invalid @enderror"
                                placeholder="1276189002457">
                            @error('nib')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Jenis Barang -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-dark">
                                Jenis Barang <span class="text-danger-custom">*</span>
                            </label>
                            <select name="jenis_barang_id" id="jenisBarangSelect"
                                class="form-select border-custom @error('jenis_barang_id') is-invalid @enderror">
                                <option value="">Pilih jenis barang</option>
                                @if(isset($jenisBarangs) && $jenisBarangs->isNotEmpty())
                                    @foreach($jenisBarangs->groupBy('kategori.nama_kategori') as $kategoriNama => $items)
                                        <optgroup label="{{ $kategoriNama }}">
                                            @foreach($items as $jenis)
                                                <option value="{{ $jenis->id }}"
                                                    {{ old('jenis_barang_id') == $jenis->id ? 'selected' : '' }}>
                                                    {{ $jenis->nama_jenis }}
                                                </option>
                                            @endforeach
                                        </optgroup>
                                    @endforeach
                                @endif
                            </select>
                            @error('jenis_barang_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text text-secondary">
                                <i class="fas fa-info-circle me-1"></i>
                                Total {{ isset($jenisBarangs) ? $jenisBarangs->count() : 0 }} jenis barang tersedia
                            </div>
                        </div>

                        <!-- Alamat -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-dark">
                                Alamat <span class="text-danger-custom">*</span>
                            </label>
                            <textarea name="alamat" rows="3"
                                class="form-control border-custom @error('alamat') is-invalid @enderror"
                                placeholder="Jl. Kesehatan No.1">{{ old('alamat') }}</textarea>
                            @error('alamat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Kontak -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-dark">
                                Kontak <span class="text-danger-custom">*</span>
                            </label>
                            <input type="text" name="kontak" value="{{ old('kontak') }}"
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
                                <option value="aktif" @selected(old('status', 'aktif') == 'aktif')>Aktif</option>
                                <option value="tidak_aktif" @selected(old('status') == 'tidak_aktif')>Tidak Aktif</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Buttons -->
                        <div class="d-flex gap-2 pt-3 border-top border-light-custom">
                            <button type="submit" id="submitBtn" class="btn btn-danger-custom flex-fill">
                                <i class="fas fa-save me-2"></i>
                                <span id="btnText">Simpan</span>
                                <span id="btnLoading" class="d-none">
                                    <span class="spinner-border spinner-border-sm me-1" role="status"></span>
                                    Menyimpan...
                                </span>
                            </button>
                            <a href="{{ route('admin.suppliers.index') }}" class="btn btn-secondary-custom flex-fill">
                                <i class="fas fa-times me-2"></i> Batal
                            </a>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

@push('scripts')
<script>
    // Prevent double submission
    const form = document.getElementById('supplierForm');
    const submitBtn = document.getElementById('submitBtn');
    const btnText = document.getElementById('btnText');
    const btnLoading = document.getElementById('btnLoading');

    let isSubmitting = false;

    form.addEventListener('submit', function(e) {
        if (isSubmitting) {
            e.preventDefault();
            return false;
        }

        isSubmitting = true;
        submitBtn.disabled = true;
        btnText.classList.add('d-none');
        btnLoading.classList.remove('d-none');
    });
</script>
@endpush

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

    .btn-danger-custom {
        background-color: var(--error-color);
        border-color: var(--error-color);
        color: white;
    }

    .btn-danger-custom:hover:not(:disabled) {
        background-color: var(--error-hover);
        border-color: var(--error-hover);
        color: white;
    }

    .btn-danger-custom:disabled {
        background-color: var(--text-light);
        border-color: var(--text-light);
        opacity: 0.6;
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

    /* Spinner */
    .spinner-border-sm {
        width: 1rem;
        height: 1rem;
        border-width: 0.15em;
    }
</style>
@endpush
@endsection
