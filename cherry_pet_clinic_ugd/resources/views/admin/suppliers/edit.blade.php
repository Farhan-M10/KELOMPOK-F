@extends('admin.layouts.app')

@section('title', 'Edit Supplier')
@section('page-title', 'Edit Supplier')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            <!-- Back Button -->
            <div class="mb-4">
                <a href="{{ route('admin.suppliers.show', $supplier) }}"
                   class="btn btn-link text-decoration-none p-0">
                    <i class="fas fa-arrow-left me-2"></i> Kembali
                </a>
            </div>

            <!-- Success Alert -->
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
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
                            <label class="form-label fw-semibold">ID Supplier</label>
                            <input type="text" value="#{{ $supplier->id }}" disabled
                                class="form-control bg-light">
                        </div>

                        <!-- Nama Supplier -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                Nama Supplier <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="nama_supplier"
                                value="{{ old('nama_supplier', $supplier->nama_supplier) }}"
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
                            <input type="text" name="nib"
                                value="{{ old('nib', $supplier->nib) }}"
                                class="form-control @error('nib') is-invalid @enderror"
                                placeholder="1276189002457">
                            @error('nib')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Kategori (Auto) -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Kategori</label>
                            <input type="text" value="{{ $supplier->kategori->nama_kategori }}" disabled
                                class="form-control bg-light">
                            <div class="form-text">
                                <i class="fas fa-info-circle me-1"></i>
                                Otomatis berdasarkan jenis barang
                            </div>
                        </div>

                        <!-- Jenis Barang -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                Jenis Barang <span class="text-danger">*</span>
                            </label>
                            <select name="jenis_barang_id"
                                class="form-select @error('jenis_barang_id') is-invalid @enderror">
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
                            <label class="form-label fw-semibold">
                                Alamat <span class="text-danger">*</span>
                            </label>
                            <textarea name="alamat" rows="3"
                                class="form-control @error('alamat') is-invalid @enderror"
                                placeholder="Jl. Kesehatan No.1">{{ old('alamat', $supplier->alamat) }}</textarea>
                            @error('alamat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Kontak -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                Kontak <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="kontak"
                                value="{{ old('kontak', $supplier->kontak) }}"
                                class="form-control @error('kontak') is-invalid @enderror"
                                placeholder="081329891201">
                            @error('kontak')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
                            <select name="status"
                                class="form-select @error('status') is-invalid @enderror">
                                <option value="aktif" {{ old('status', $supplier->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="tidak_aktif" {{ old('status', $supplier->status) == 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Actions -->
                        <div class="d-flex gap-2 pt-3 border-top">
                            <a href="{{ route('admin.suppliers.show', $supplier) }}"
                               class="btn btn-secondary flex-fill">
                                <i class="fas fa-times me-2"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-success flex-fill">
                                <i class="fas fa-save me-2"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Danger Zone -->
            <div class="card border-danger mt-4">
                <div class="card-body bg-danger bg-opacity-10">
                    <h5 class="card-title text-danger fw-bold mb-2">
                        <i class="fas fa-exclamation-triangle me-2"></i> Zona Berbahaya
                    </h5>
                    <p class="card-text text-danger mb-3">
                        Data supplier akan dihapus permanen dan tidak dapat dikembalikan.
                    </p>
                    <form action="{{ route('admin.suppliers.destroy', $supplier) }}" method="POST"
                          onsubmit="return confirm('⚠️ Yakin ingin menghapus supplier ini?\n\nData yang terhapus tidak dapat dikembalikan!');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
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

    .border-danger {
        border-width: 2px !important;
    }

    .bg-danger.bg-opacity-10 {
        background-color: rgba(220, 53, 69, 0.1) !important;
    }
</style>
@endpush
@endsection
