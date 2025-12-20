@extends('admin.layouts.app')

@section('title', 'Tambah Supplier')
@section('page-title', 'Tambah Supplier Baru')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            <!-- Back Button & Title -->
            <div class="mb-4">
                <a href="{{ route('admin.suppliers.index') }}" class="btn btn-link text-decoration-none p-0 mb-3">
                    <i class="fas fa-arrow-left me-2"></i> Kembali
                </a>
                <h4 class="fw-bold mb-0">Form Tambah Supplier</h4>
            </div>

            <!-- Form Card -->
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <form action="{{ route('admin.suppliers.store') }}" method="POST" id="supplierForm">
                        @csrf

                        <!-- Nama Supplier -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                Nama Supplier <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="nama_supplier" value="{{ old('nama_supplier') }}"
                                class="form-control @error('nama_supplier') is-invalid @enderror"
                                placeholder="PT. Sejahtera Medika">
                            @error('nama_supplier')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- NIB -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                NIB <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="nib" value="{{ old('nib') }}"
                                class="form-control @error('nib') is-invalid @enderror"
                                placeholder="1276189002457">
                            @error('nib')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Jenis Barang -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                Jenis Barang <span class="text-danger">*</span>
                            </label>
                            <select name="jenis_barang_id" id="jenisBarangSelect"
                                class="form-select @error('jenis_barang_id') is-invalid @enderror">
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
                            <div class="form-text">
                                <i class="fas fa-info-circle me-1"></i>
                                Total {{ isset($jenisBarangs) ? $jenisBarangs->count() : 0 }} jenis barang tersedia
                            </div>
                        </div>

                        <!-- Alamat -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                Alamat <span class="text-danger">*</span>
                            </label>
                            <textarea name="alamat" rows="3"
                                class="form-control @error('alamat') is-invalid @enderror"
                                placeholder="Jl. Kesehatan No.1">{{ old('alamat') }}</textarea>
                            @error('alamat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Kontak -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                Kontak <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="kontak" value="{{ old('kontak') }}"
                                class="form-control @error('kontak') is-invalid @enderror"
                                placeholder="081329891201">
                            @error('kontak')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                Status <span class="text-danger">*</span>
                            </label>
                            <select name="status"
                                class="form-select @error('status') is-invalid @enderror">
                                <option value="aktif" @selected(old('status', 'aktif') == 'aktif')>Aktif</option>
                                <option value="tidak_aktif" @selected(old('status') == 'tidak_aktif')>Tidak Aktif</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Buttons -->
                        <div class="d-flex gap-2 pt-3 border-top">
                            <button type="submit" id="submitBtn" class="btn btn-primary flex-fill">
                                <i class="fas fa-save me-2"></i>
                                <span id="btnText">Simpan</span>
                                <span id="btnLoading" class="d-none">
                                    <span class="spinner-border spinner-border-sm me-1" role="status"></span>
                                    Menyimpan...
                                </span>
                            </button>
                            <a href="{{ route('admin.suppliers.index') }}" class="btn btn-secondary flex-fill">
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
    .card {
        transition: all 0.3s ease;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
    }

    .btn {
        transition: all 0.2s ease;
    }

    .btn:hover:not(:disabled) {
        transform: translateY(-1px);
    }

    .form-label {
        margin-bottom: 0.5rem;
        color: #212529;
    }

    .invalid-feedback {
        display: block;
    }
</style>
@endpush
@endsection
