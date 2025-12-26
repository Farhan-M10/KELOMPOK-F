@extends('admin.layouts.app')

@section('title', 'Detail Supplier')
@section('page-title', 'Detail Supplier')

@section('content')
<div class="container-fluid" style="background-color: #E8F4F8; min-height: 100vh; padding: 2rem 0;">

    <!-- Breadcrumb -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <nav aria-label="breadcrumb" class="mb-3">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.suppliers.index') }}" class="text-decoration-none text-primary-custom">
                            <i class="fas fa-building me-1"></i> Supplier
                        </a>
                    </li>
                    <li class="breadcrumb-item active text-dark" aria-current="page">Detail</li>
                </ol>
            </nav>

            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="fw-bold mb-2 text-dark">Detail Supplier</h4>
                    <p class="text-secondary small mb-0">Informasi lengkap supplier</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.suppliers.edit', $supplier) }}" class="btn btn-warning text-white">
                        <i class="fas fa-edit me-2"></i> Edit
                    </a>
                    <a href="{{ route('admin.suppliers.index') }}" class="btn btn-outline-custom">
                        <i class="fas fa-arrow-left me-2"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <!-- Supplier Header Card -->
            <div class="card border-0 shadow-sm mb-4 overflow-hidden">
                <div class="supplier-header-gradient">
                    <div class="d-flex align-items-center gap-4 p-4">
                        <div class="supplier-icon-wrapper">
                            <i class="fas fa-building"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                @if(strtolower($supplier->kategori->nama_kategori) == 'medis')
                                    <span class="badge badge-medis-white">
                                        <i class="fas fa-medkit me-1"></i>
                                        {{ $supplier->kategori->nama_kategori }}
                                    </span>
                                @else
                                    <span class="badge badge-non-medis-white">
                                        <i class="fas fa-boxes me-1"></i>
                                        {{ $supplier->kategori->nama_kategori }}
                                    </span>
                                @endif
                                @if($supplier->status == 'aktif')
                                    <span class="badge badge-active-white">
                                        <i class="fas fa-check-circle me-1"></i> Aktif
                                    </span>
                                @else
                                    <span class="badge badge-inactive-white">
                                        <i class="fas fa-times-circle me-1"></i> Nonaktif
                                    </span>
                                @endif
                            </div>
                            <h3 class="text-dark fw-bold mb-0">{{ $supplier->nama_supplier }}</h3>
                            <p class="text-secondary mb-0 mt-1">NIB: {{ $supplier->nib }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Informasi Detail -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-bottom">
                    <h5 class="fw-bold mb-0 text-dark">
                        <i class="fas fa-info-circle text-primary-custom me-2"></i>
                        Informasi Detail
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-4">
                        <!-- Jenis Barang -->
                        <div class="col-12">
                            <div class="info-box-simple">
                                <label class="info-label">Jenis Barang</label>
                                <div class="info-value">{{ $supplier->jenisBarang->nama_jenis }}</div>
                            </div>
                        </div>

                        <!-- Kontak -->
                        <div class="col-12">
                            <div class="info-box-simple">
                                <label class="info-label">Nomor Kontak</label>
                                <div class="info-value mb-3">{{ $supplier->kontak }}</div>
                                <div class="d-flex gap-2">
                                    <a href="https://wa.me/62{{ ltrim($supplier->kontak, '0') }}"
                                       target="_blank"
                                       class="btn btn-success-custom btn-sm flex-fill">
                                        <i class="fab fa-whatsapp me-1"></i> WhatsApp
                                    </a>
                                    <a href="tel:{{ $supplier->kontak }}"
                                       class="btn btn-outline-success btn-sm flex-fill">
                                        <i class="fas fa-phone me-1"></i> Telepon
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Alamat -->
                        <div class="col-12">
                            <div class="info-box-simple">
                                <label class="info-label">Alamat Lengkap</label>
                                <div class="info-value-text">{{ $supplier->alamat }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Timeline -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h5 class="fw-bold mb-0 text-dark">
                        <i class="fas fa-clock text-primary-custom me-2"></i>
                        Riwayat
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-marker bg-success"></div>
                            <div class="timeline-content">
                                <div class="timeline-title">Data Dibuat</div>
                                <div class="timeline-date">
                                    <i class="fas fa-calendar me-1"></i>
                                    {{ $supplier->created_at->format('d F Y, H:i') }} WIB
                                </div>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-marker bg-warning"></div>
                            <div class="timeline-content">
                                <div class="timeline-title">Terakhir Diperbarui</div>
                                <div class="timeline-date">
                                    <i class="fas fa-calendar-edit me-1"></i>
                                    {{ $supplier->updated_at->format('d F Y, H:i') }} WIB
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Quick Actions -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-bottom">
                    <h6 class="fw-bold mb-0 text-dark">
                        <i class="fas fa-bolt text-warning me-2"></i>
                        Aksi Cepat
                    </h6>
                </div>
                <div class="card-body p-3">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.suppliers.edit', $supplier) }}"
                           class="btn btn-warning text-white d-flex align-items-center justify-content-center">
                            <i class="fas fa-edit me-2"></i> Edit Supplier
                        </a>
                        <a href="https://wa.me/62{{ ltrim($supplier->kontak, '0') }}"
                           target="_blank"
                           class="btn btn-success-custom d-flex align-items-center justify-content-center">
                            <i class="fab fa-whatsapp me-2"></i> Hubungi via WhatsApp
                        </a>
                        <form action="{{ route('admin.suppliers.destroy', $supplier) }}"
                              method="POST"
                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus supplier ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger-custom w-100 d-flex align-items-center justify-content-center">
                                <i class="fas fa-trash me-2"></i> Hapus Supplier
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Status Card -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body text-center p-4">
                    @if($supplier->status == 'aktif')
                        <div class="status-icon-wrapper bg-success-light mb-3">
                            <i class="fas fa-check-circle text-success"></i>
                        </div>
                        <h6 class="fw-bold text-dark mb-2">Supplier Aktif</h6>
                        <p class="text-secondary small mb-0">Supplier ini sedang aktif dan dapat digunakan untuk transaksi</p>
                    @else
                        <div class="status-icon-wrapper bg-danger-light mb-3">
                            <i class="fas fa-times-circle text-danger"></i>
                        </div>
                        <h6 class="fw-bold text-dark mb-2">Supplier Nonaktif</h6>
                        <p class="text-secondary small mb-0">Supplier ini tidak aktif dan tidak dapat digunakan untuk transaksi</p>
                    @endif
                </div>
            </div>

            <!-- Info Card -->
            <div class="card border-0 shadow-sm bg-light">
                <div class="card-body p-4">
                    <div class="text-center mb-3">
                        <i class="fas fa-info-circle text-primary-custom" style="font-size: 2.5rem;"></i>
                    </div>
                    <h6 class="fw-bold text-dark mb-2 text-center">Informasi</h6>
                    <p class="text-secondary small mb-0 text-center">
                        Data supplier digunakan untuk mengelola pemasok barang dalam sistem inventori klinik.
                    </p>
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

    /* Body & Container */
    body {
        background-color: var(--bg-very-light) !important;
    }

    /* Supplier Header Gradient */
    .supplier-header-gradient {
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    }

    .supplier-icon-wrapper {
        width: 80px;
        height: 80px;
        background: rgba(0, 0, 0, 0.05);
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        color: #424242;
        backdrop-filter: blur(10px);
    }

    /* Badges on Header */
    .badge-medis-white,
    .badge-non-medis-white,
    .badge-active-white,
    .badge-inactive-white {
        padding: 0.5em 1em;
        font-size: 0.75rem;
        font-weight: 600;
        border-radius: 20px;
        backdrop-filter: blur(10px);
    }

    .badge-medis-white {
        background: rgba(0, 102, 179, 0.9);
        color: white;
    }

    .badge-non-medis-white {
        background: rgba(31, 189, 136, 0.9);
        color: white;
    }

    .badge-active-white {
        background: rgba(31, 189, 136, 0.15);
        color: #1FBD88;
        border: 1.5px solid #1FBD88;
        font-weight: 700;
    }

    .badge-inactive-white {
        background: rgba(227, 30, 36, 0.15);
        color: #E31E24;
        border: 1.5px solid #E31E24;
        font-weight: 700;
    }

    /* Info Box Simple - Without Icons */
    .info-box-simple {
        padding: 1.5rem;
        background: var(--bg-light);
        border-radius: 12px;
        border: 1px solid var(--border-light);
        transition: all 0.3s ease;
    }

    .info-box-simple:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }

    .info-label {
        font-size: 0.75rem;
        color: var(--text-secondary);
        text-transform: uppercase;
        font-weight: 600;
        letter-spacing: 0.5px;
        margin-bottom: 0.5rem;
        display: block;
    }

    .info-value {
        font-size: 1.125rem;
        font-weight: 700;
        color: var(--text-dark);
    }

    .info-value-text {
        font-size: 1rem;
        color: var(--text-dark);
        line-height: 1.6;
    }

    /* Background Colors */
    .bg-primary-light {
        background: rgba(0, 102, 179, 0.1);
    }

    .bg-success-light {
        background: rgba(31, 189, 136, 0.1);
    }

    .bg-warning-light {
        background: rgba(245, 158, 11, 0.1);
    }

    .bg-danger-light {
        background: rgba(227, 30, 36, 0.1);
    }

    /* Timeline */
    .timeline {
        position: relative;
        padding-left: 2rem;
    }

    .timeline::before {
        content: '';
        position: absolute;
        left: 8px;
        top: 8px;
        bottom: 8px;
        width: 2px;
        background: var(--border-light);
    }

    .timeline-item {
        position: relative;
        padding-bottom: 2rem;
    }

    .timeline-item:last-child {
        padding-bottom: 0;
    }

    .timeline-marker {
        position: absolute;
        left: -2rem;
        width: 18px;
        height: 18px;
        border-radius: 50%;
        border: 3px solid white;
        box-shadow: 0 0 0 2px var(--border-light);
    }

    .timeline-content {
        background: var(--bg-light);
        padding: 1rem 1.25rem;
        border-radius: 8px;
        border: 1px solid var(--border-light);
    }

    .timeline-title {
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 0.25rem;
    }

    .timeline-date {
        font-size: 0.875rem;
        color: var(--text-secondary);
    }

    /* Status Icon Wrapper */
    .status-icon-wrapper {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
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

    .btn-outline-custom {
        background-color: white;
        border-color: var(--border-normal);
        color: var(--text-secondary);
    }

    .btn-outline-custom:hover {
        background-color: var(--bg-light);
        border-color: var(--primary-medium);
        color: var(--primary-medium);
    }

    .btn-outline-success {
        border-color: var(--success-color);
        color: var(--success-color);
    }

    .btn-outline-success:hover {
        background-color: var(--success-color);
        color: white;
    }

    /* Cards */
    .card {
        transition: all 0.3s ease;
    }

    .card:hover {
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
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

    /* Breadcrumb */
    .breadcrumb-item + .breadcrumb-item::before {
        content: "›";
        color: var(--text-medium);
    }
</style>
@endpush
@endsection
