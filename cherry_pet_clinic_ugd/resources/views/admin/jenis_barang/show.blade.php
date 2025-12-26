@extends('admin.layouts.app')

@section('title', 'Detail Jenis Barang')
@section('page-title', 'Detail Jenis Barang')

@section('content')
<div class="container-fluid" style="background-color: #E8F4F8; min-height: 100vh; padding: 2rem 0;">

    <!-- Breadcrumb -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <nav aria-label="breadcrumb" class="mb-3">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.kategori.index') }}" class="text-decoration-none text-primary-custom">
                            <i class="fas fa-tags me-1"></i> Kategori
                        </a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.jenis_barang.index') }}" class="text-decoration-none text-primary-custom">
                            Jenis Barang
                        </a>
                    </li>
                    <li class="breadcrumb-item active text-dark" aria-current="page">Detail</li>
                </ol>
            </nav>

            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="fw-bold mb-2 text-dark">Detail Jenis Barang</h4>
                    <p class="text-secondary small mb-0">Informasi lengkap jenis barang</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.jenis_barang.edit', $jenisBarang) }}" class="btn btn-warning text-white">
                        <i class="fas fa-edit me-2"></i> Edit
                    </a>
                    <a href="{{ route('admin.jenis_barang.index') }}" class="btn btn-outline-custom">
                        <i class="fas fa-arrow-left me-2"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Detail Card -->
    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h5 class="fw-bold mb-0 text-dark">
                        <i class="fas fa-info-circle text-primary-custom me-2"></i>
                        Informasi Jenis Barang
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-4">


                        <!-- Nama Jenis -->
                        <div class="col-md-6">
                            <label class="text-secondary small mb-2 d-block">Nama Jenis</label>
                            <div class="detail-value fw-bold text-dark">
                                {{ $jenisBarang->nama_jenis }}
                            </div>
                        </div>

                        <!-- Kategori -->
                        <div class="col-md-6">
                            <label class="text-secondary small mb-2 d-block">Kategori</label>
                            <div class="detail-value">
                                @if(strtolower($jenisBarang->kategori->nama_kategori) == 'medis')
                                    <span class="badge badge-medis-large">
                                        <i class="fas fa-medkit me-2"></i>
                                        {{ $jenisBarang->kategori->nama_kategori }}
                                    </span>
                                @else
                                    <span class="badge badge-non-medis-large">
                                        <i class="fas fa-boxes me-2"></i>
                                        {{ $jenisBarang->kategori->nama_kategori }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        

                        <!-- Tanggal Dibuat -->
                        <div class="col-md-6">
                            <label class="text-secondary small mb-2 d-block">Tanggal Dibuat</label>
                            <div class="detail-value">
                                <i class="fas fa-calendar-plus text-success me-2"></i>
                                {{ $jenisBarang->created_at->format('d/m/Y H:i') }}
                            </div>
                        </div>

                        <!-- Terakhir Diupdate -->
                        <div class="col-md-6">
                            <label class="text-secondary small mb-2 d-block">Terakhir Diupdate</label>
                            <div class="detail-value">
                                <i class="fas fa-calendar-edit text-warning me-2"></i>
                                {{ $jenisBarang->updated_at->format('d/m/Y H:i') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Info Card Sidebar -->
        <div class="col-lg-4">
            <!-- Quick Actions -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-bottom">
                    <h6 class="fw-bold mb-0 text-dark">
                        <i class="fas fa-bolt text-warning me-2"></i>
                        Aksi Cepat
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.jenis_barang.edit', $jenisBarang) }}" class="btn btn-warning text-white">
                            <i class="fas fa-edit me-2"></i> Edit Jenis Barang
                        </a>
                        <form action="{{ route('admin.jenis_barang.destroy', $jenisBarang) }}"
                              method="POST"
                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus jenis barang ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger-custom w-100">
                                <i class="fas fa-trash me-2"></i> Hapus Jenis Barang
                            </button>
                        </form>
                        <a href="{{ route('admin.jenis_barang.index', ['kategori_id' => $jenisBarang->kategori_id]) }}"
                           class="btn btn-outline-custom">
                            <i class="fas fa-list me-2"></i> Lihat Semua {{ $jenisBarang->kategori->nama_kategori }}
                        </a>
                    </div>
                </div>
            </div>

            <!-- Info Card -->
            <div class="card border-0 shadow-sm bg-light">
                <div class="card-body">
                    <div class="text-center mb-3">
                        <i class="fas fa-info-circle text-primary-custom" style="font-size: 2.5rem;"></i>
                    </div>
                    <h6 class="fw-bold text-dark mb-2 text-center">Informasi</h6>
                    <p class="text-secondary small mb-0 text-center">
                        Data jenis barang digunakan untuk mengkategorisasi barang dalam inventori klinik.
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

    /* Body Background */
    body {
        background-color: var(--bg-very-light) !important;
    }

    /* Text Colors */
    .text-dark { color: var(--text-dark) !important; }
    .text-secondary { color: var(--text-secondary) !important; }
    .text-medium { color: var(--text-medium) !important; }
    .text-primary-custom { color: var(--primary-medium) !important; }

    /* Card Styling */
    .card {
        transition: all 0.3s ease;
    }

    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
    }

    /* Detail Value */
    .detail-value {
        font-size: 1rem;
        color: var(--text-dark);
        padding: 0.75rem;
        background-color: var(--bg-light);
        border-radius: 0.375rem;
        border: 1px solid var(--border-light);
    }

    /* Code Badge */
    .code-badge {
        background-color: var(--bg-light);
        color: var(--text-dark);
        padding: 0.25rem 0.5rem;
        border-radius: 0.25rem;
        font-size: 0.875rem;
        font-family: 'Courier New', monospace;
        border: 1px solid var(--border-light);
    }

    .code-badge-large {
        background-color: var(--primary-medium);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 0.375rem;
        font-size: 1rem;
        font-family: 'Courier New', monospace;
        font-weight: bold;
        display: inline-block;
    }

    /* Badge untuk Kategori */
    .badge-medis-large {
        background-color: #0066B3;
        color: white;
        padding: 0.6em 1.2em;
        font-size: 0.9rem;
        font-weight: 600;
        border-radius: 0.375rem;
    }

    .badge-non-medis-large {
        background-color: #1FBD88;
        color: white;
        padding: 0.6em 1.2em;
        font-size: 0.9rem;
        font-weight: 600;
        border-radius: 0.375rem;
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
    }

    .btn-danger-custom {
        background-color: var(--error-color);
        border-color: var(--error-color);
        color: white;
    }

    .btn-danger-custom:hover {
        background-color: var(--error-hover);
        border-color: var(--error-hover);
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

    /* Breadcrumb */
    .breadcrumb-item + .breadcrumb-item::before {
        content: "›";
        color: var(--text-medium);
    }

    /* Card Header */
    .card-header {
        padding: 1rem 1.5rem;
    }
</style>
@endpush

@endsection
