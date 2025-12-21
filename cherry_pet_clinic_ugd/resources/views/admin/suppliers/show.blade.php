@extends('admin.layouts.app')

@section('title', 'Detail Supplier')
@section('page-title', 'Detail Supplier')

@section('content')
<div class="container-fluid" style="background-color: #E8F4F8; min-height: 100vh; padding: 2rem 0;">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            <!-- Back Button -->
            <div class="mb-4">
                <a href="{{ route('admin.suppliers.index') }}"
                   class="btn btn-link text-decoration-none p-0 text-primary-custom">
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
                                <span class="badge {{ $supplier->kategori->nama_kategori == 'Medis' ? 'badge-medis' : 'badge-non-medis' }} rounded-pill">
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
                            <div class="card border-custom">
                                <div class="card-body">
                                    <p class="text-secondary small mb-1">
                                        <i class="fas fa-id-card me-1"></i> NIB
                                    </p>
                                    <h5 class="fw-bold mb-0 text-dark">{{ $supplier->nib }}</h5>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card border-custom">
                                <div class="card-body">
                                    <p class="text-secondary small mb-1">
                                        <i class="fas fa-tag me-1"></i> Kategori
                                    </p>
                                    <h5 class="fw-bold mb-0 text-dark">
                                        {{ $supplier->kategori->nama_kategori }}
                                    </h5>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Jenis Barang -->
                    <div class="card border-custom mb-4">
                        <div class="card-body">
                            <p class="text-secondary small mb-1">
                                <i class="fas fa-boxes me-1"></i> Jenis Barang
                            </p>
                            <h5 class="fw-bold mb-0 text-dark">
                                {{ $supplier->jenisBarang->nama_jenis }}
                            </h5>
                        </div>
                    </div>

                    <!-- Kontak -->
                    <div class="card border-custom mb-4">
                        <div class="card-body">
                            <p class="text-secondary small mb-2">
                                <i class="fas fa-phone me-1"></i> Kontak
                            </p>
                            <h5 class="fw-bold mb-3 text-dark">
                                {{ $supplier->kontak }}
                            </h5>

                            <div class="d-flex gap-2">
                                <a href="https://wa.me/62{{ ltrim($supplier->kontak, '0') }}"
                                   target="_blank"
                                   class="btn btn-success-custom flex-fill">
                                    <i class="fab fa-whatsapp me-2"></i> WhatsApp
                                </a>

                                <a href="tel:{{ $supplier->kontak }}"
                                   class="btn btn-secondary-custom flex-fill">
                                    <i class="fas fa-phone me-2"></i> Telepon
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Alamat -->
                    <div class="card border-custom mb-4">
                        <div class="card-body">
                            <p class="text-secondary small mb-2">
                                <i class="fas fa-map-marker-alt me-1"></i> Alamat
                            </p>
                            <p class="mb-0 text-dark lh-lg">
                                {{ $supplier->alamat }}
                            </p>
                        </div>
                    </div>

                    <!-- Status -->
                    <div class="card border-custom mb-4">
                        <div class="card-body">
                            <p class="text-secondary small mb-1">
                                <i class="fas fa-info-circle me-1"></i> Status
                            </p>
                            <h5 class="mb-0">
                                @if($supplier->status == 'aktif')
                                    <span class="badge badge-status-active">
                                        <i class="fas fa-check-circle me-1"></i> Aktif
                                    </span>
                                @else
                                    <span class="badge badge-status-inactive">
                                        <i class="fas fa-times-circle me-1"></i> Tidak Aktif
                                    </span>
                                @endif
                            </h5>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="d-flex gap-2 pt-3 border-top border-custom">
                        <a href="{{ route('admin.suppliers.index') }}"
                           class="btn btn-secondary-custom flex-fill">
                            <i class="fas fa-times me-2"></i> Tutup
                        </a>
                        <a href="{{ route('admin.suppliers.edit', $supplier) }}"
                           class="btn btn-success-custom flex-fill">
                            <i class="fas fa-edit me-2"></i> Edit Supplier
                        </a>
                    </div>

                </div>
            </div>

            <!-- Footer Info -->
            <div class="card border-0 shadow-sm mt-3">
                <div class="card-body p-3 bg-light-custom">
                    <div class="row text-center small text-secondary">
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
    }

    /* Body Background Override */
    body {
        background-color: var(--bg-very-light) !important;
    }

    /* Main Content Background */
    .container-fluid {
        background-color: var(--bg-very-light) !important;
    }

    /* Background Gradient - Biru */
    .bg-gradient-primary {
        background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-medium) 100%);
    }

    /* Cards */
    .card {
        transition: all 0.3s ease;
        background-color: white;
    }

    .card:hover {
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
    }

    .border-custom {
        border: 1px solid var(--border-light);
    }

    /* Badges */
    .badge-medis {
        background-color: var(--success-color);
        color: white;
        padding: 0.4em 0.8em;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .badge-non-medis {
        background-color: var(--primary-medium);
        color: white;
        padding: 0.4em 0.8em;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .badge-status-active {
        background-color: var(--success-color);
        color: white;
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
        font-weight: 600;
    }

    .badge-status-inactive {
        background-color: var(--text-medium);
        color: white;
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
        font-weight: 600;
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

    .btn-primary-custom {
        background-color: var(--primary-medium);
        border-color: var(--primary-medium);
        color: white;
    }

    .btn-primary-custom:hover {
        background-color: var(--primary-dark);
        border-color: var(--primary-dark);
        color: white;
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

    /* Text Colors */
    .text-dark {
        color: var(--text-dark) !important;
    }

    .text-secondary {
        color: var(--text-secondary) !important;
    }

    .text-medium {
        color: var(--text-medium) !important;
    }

    .text-primary-custom {
        color: var(--primary-medium) !important;
    }

    /* Background Colors */
    .bg-light-custom {
        background-color: var(--bg-light) !important;
    }

    .bg-white.bg-opacity-25 {
        background-color: rgba(255, 255, 255, 0.25) !important;
    }

    /* Border */
    .border-top.border-custom {
        border-top: 1px solid var(--border-light) !important;
    }

    /* Rounded */
    .rounded-top-0 {
        border-top-left-radius: 0 !important;
        border-top-right-radius: 0 !important;
    }

    .rounded-bottom-0 {
        border-bottom-left-radius: 0 !important;
        border-bottom-right-radius: 0 !important;
    }

    /* Line Height */
    .lh-lg {
        line-height: 1.75;
    }

    /* Link */
    a.btn-link {
        transition: color 0.2s ease;
        font-weight: 500;
    }

    a.btn-link:hover {
        color: var(--primary-dark) !important;
        text-decoration: underline !important;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .d-flex.gap-2 {
            flex-direction: column;
        }

        .col-6 {
            font-size: 0.75rem;
        }

        .bg-gradient-primary h3 {
            font-size: 1.25rem;
        }
    }
</style>
@endpush
@endsection
