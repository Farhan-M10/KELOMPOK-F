@extends('admin.layouts.app')

@section('title', 'Detail Supplier')
@section('page-title', 'Detail Supplier')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            <!-- Back Button -->
            <div class="mb-4">
                <a href="{{ route('admin.suppliers.index') }}"
                   class="btn btn-link text-decoration-none p-0">
                    <i class="fas fa-arrow-left me-2"></i> Kembali
                </a>
            </div>

            <!-- Header Card -->
            <div class="card border-0 shadow-sm mb-0 rounded-bottom-0">
                <div class="card-body p-4 bg-gradient-primary">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-white bg-opacity-25 p-3 rounded">
                            <i class="fas fa-building text-white fs-3"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <span class="badge bg-white bg-opacity-25 text-white">
                                    ID #{{ $supplier->id }}
                                </span>
                                <span class="badge {{ $supplier->kategori->nama_kategori == 'Medis' ? 'bg-success' : 'bg-primary' }} rounded-pill">
                                    {{ $supplier->kategori->nama_kategori }}
                                </span>
                            </div>
                            <h3 class="text-white fw-bold mb-0">
                                {{ $supplier->nama_supplier }}
                            </h3>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Body Card -->
            <div class="card border-0 shadow-sm rounded-top-0">
                <div class="card-body p-4">

                    <!-- Info Grid -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <div class="card border">
                                <div class="card-body">
                                    <p class="text-muted small mb-1">
                                        <i class="fas fa-id-card me-1"></i> NIB
                                    </p>
                                    <h5 class="fw-bold mb-0">{{ $supplier->nib }}</h5>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card border">
                                <div class="card-body">
                                    <p class="text-muted small mb-1">
                                        <i class="fas fa-tag me-1"></i> Kategori
                                    </p>
                                    <h5 class="fw-bold mb-0">
                                        {{ $supplier->kategori->nama_kategori }}
                                    </h5>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Jenis Barang -->
                    <div class="card border mb-4">
                        <div class="card-body">
                            <p class="text-muted small mb-1">
                                <i class="fas fa-boxes me-1"></i> Jenis Barang
                            </p>
                            <h5 class="fw-bold mb-0">
                                {{ $supplier->jenisBarang->nama_jenis }}
                            </h5>
                        </div>
                    </div>

                    <!-- Kontak -->
                    <div class="card border mb-4">
                        <div class="card-body">
                            <p class="text-muted small mb-2">
                                <i class="fas fa-phone me-1"></i> Kontak
                            </p>
                            <h5 class="fw-bold mb-3">
                                {{ $supplier->kontak }}
                            </h5>

                            <div class="d-flex gap-2">
                                <a href="https://wa.me/62{{ ltrim($supplier->kontak, '0') }}"
                                   target="_blank"
                                   class="btn btn-success flex-fill">
                                    <i class="fab fa-whatsapp me-2"></i> WhatsApp
                                </a>

                                <a href="tel:{{ $supplier->kontak }}"
                                   class="btn btn-secondary flex-fill">
                                    <i class="fas fa-phone me-2"></i> Telepon
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Alamat -->
                    <div class="card border mb-4">
                        <div class="card-body">
                            <p class="text-muted small mb-2">
                                <i class="fas fa-map-marker-alt me-1"></i> Alamat
                            </p>
                            <p class="mb-0 text-dark lh-lg">
                                {{ $supplier->alamat }}
                            </p>
                        </div>
                    </div>

                    <!-- Status -->
                    <div class="card border mb-4">
                        <div class="card-body">
                            <p class="text-muted small mb-1">
                                <i class="fas fa-info-circle me-1"></i> Status
                            </p>
                            <h5 class="mb-0">
                                @if($supplier->status == 'aktif')
                                    <span class="badge bg-success">
                                        <i class="fas fa-check-circle me-1"></i> Aktif
                                    </span>
                                @else
                                    <span class="badge bg-secondary">
                                        <i class="fas fa-times-circle me-1"></i> Tidak Aktif
                                    </span>
                                @endif
                            </h5>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="d-flex gap-2 pt-3 border-top">
                        <a href="{{ route('admin.suppliers.index') }}"
                           class="btn btn-secondary flex-fill">
                            <i class="fas fa-times me-2"></i> Tutup
                        </a>
                        <a href="{{ route('admin.suppliers.edit', $supplier) }}"
                           class="btn btn-success flex-fill">
                            <i class="fas fa-edit me-2"></i> Edit Supplier
                        </a>
                    </div>

                </div>
            </div>

            <!-- Footer Info -->
            <div class="card border-0 shadow-sm mt-3">
                <div class="card-body p-3 bg-light">
                    <div class="row text-center small text-muted">
                        <div class="col-6">
                            <i class="fas fa-calendar-plus me-1"></i>
                            Dibuat: {{ $supplier->created_at->format('d M Y, H:i') }}
                        </div>
                        <div class="col-6">
                            <i class="fas fa-calendar-edit me-1"></i>
                            Diubah: {{ $supplier->updated_at->format('d M Y, H:i') }}
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@push('styles')
<style>
    .bg-gradient-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .card {
        transition: all 0.3s ease;
    }

    .btn {
        transition: all 0.2s ease;
    }

    .btn:hover:not(:disabled) {
        transform: translateY(-1px);
    }

    .rounded-top-0 {
        border-top-left-radius: 0 !important;
        border-top-right-radius: 0 !important;
    }

    .rounded-bottom-0 {
        border-bottom-left-radius: 0 !important;
        border-bottom-right-radius: 0 !important;
    }

    .bg-white.bg-opacity-25 {
        background-color: rgba(255, 255, 255, 0.25) !important;
    }

    .lh-lg {
        line-height: 1.75;
    }
</style>
@endpush
@endsection
