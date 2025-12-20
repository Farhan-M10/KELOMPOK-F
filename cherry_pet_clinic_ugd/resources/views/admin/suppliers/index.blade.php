@extends('admin.layouts.app')

@section('title', 'Data Supplier')
@section('page-title', 'Pemasok')

@section('content')
<div class="container-fluid">

    <!-- Stats Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted small mb-1">Total Supplier</p>
                            <h3 class="fw-bold mb-0">{{ \App\Models\Supplier::count() }}</h3>
                        </div>
                        <div class="bg-primary bg-opacity-10 p-3 rounded">
                            <i class="fas fa-building text-primary fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted small mb-1">Supplier Aktif</p>
                            <h3 class="fw-bold mb-0">{{ \App\Models\Supplier::where('status', 'aktif')->count() }}</h3>
                        </div>
                        <div class="bg-success bg-opacity-10 p-3 rounded">
                            <i class="fas fa-check-circle text-success fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted small mb-1">Jenis Produk</p>
                            <h3 class="fw-bold mb-0">{{ \App\Models\JenisBarang::count() }}</h3>
                        </div>
                        <div class="bg-info bg-opacity-10 p-3 rounded">
                            <i class="fas fa-boxes text-info fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Search & Filter Bar -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-5">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari nama supplier, NIB, atau alamat..."
                            class="form-control border-start-0 ps-0">
                    </div>
                </div>

                <div class="col-md-3">
                    <select name="kategori" class="form-select">
                        <option value="">Semua Jenis Produk</option>
                        <option value="Medis" {{ request('kategori') == 'Medis' ? 'selected' : '' }}>Medis</option>
                        <option value="Non-Medis" {{ request('kategori') == 'Non-Medis' ? 'selected' : '' }}>Non Medis</option>
                    </select>
                </div>

                <div class="col-md-4 text-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-filter me-1"></i> Filter
                    </button>
                    <a href="{{ route('admin.suppliers.index') }}" class="btn btn-secondary">
                        <i class="fas fa-redo me-1"></i> Reset
                    </a>
                    <a href="{{ route('admin.suppliers.create') }}" class="btn btn-danger">
                        <i class="fas fa-plus me-1"></i> Tambah Supplier
                    </a>
                </div>
            </form>
        </div>
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

    <!-- Supplier Grid -->
    <div class="row g-3 mb-4">
        @forelse($suppliers as $s)
        <div class="col-md-6 col-lg-6">
            <div class="card border-0 shadow-sm h-100 border-start border-5 {{ $s->kategori->nama_kategori == 'Medis' ? 'border-success' : 'border-primary' }}">
                <div class="card-body">
                    <!-- Header -->
                    <div class="d-flex justify-content-between align-items-start mb-3 pb-3 border-bottom">
                        <div>
                            <h5 class="card-title fw-bold mb-1">{{ $s->nama_supplier }}</h5>
                            <p class="text-muted small mb-0">NIB: {{ $s->nib }}</p>
                        </div>
                        <span class="badge {{ $s->kategori->nama_kategori == 'Medis' ? 'bg-success' : 'bg-primary' }} rounded-pill">
                            {{ $s->kategori->nama_kategori }}
                        </span>
                    </div>

                    <!-- Info Section -->
                    <div class="mb-3">
                        <div class="d-flex align-items-start mb-2">
                            <i class="fas fa-boxes text-muted me-2 mt-1" style="width: 16px;"></i>
                            <div class="flex-grow-1">
                                <p class="text-muted small mb-0">Jenis Barang</p>
                                <p class="fw-medium mb-0">{{ $s->jenisBarang->nama_jenis }}</p>
                            </div>
                        </div>

                        <div class="d-flex align-items-start mb-2">
                            <i class="fas fa-map-marker-alt text-muted me-2 mt-1" style="width: 16px;"></i>
                            <div class="flex-grow-1">
                                <p class="text-muted small mb-0">Alamat</p>
                                <p class="fw-medium mb-0 text-truncate">{{ $s->alamat }}</p>
                            </div>
                        </div>

                        <div class="d-flex align-items-start">
                            <i class="fas fa-phone text-muted me-2 mt-1" style="width: 16px;"></i>
                            <div class="flex-grow-1">
                                <p class="text-muted small mb-0">Kontak</p>
                                <p class="fw-medium mb-0">{{ $s->kontak }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex gap-2 pt-3 border-top">
                        <a href="{{ route('admin.suppliers.show', $s) }}"
                           class="btn btn-sm btn-primary flex-fill">
                            <i class="fas fa-eye me-1"></i> Detail
                        </a>
                        <a href="{{ route('admin.suppliers.edit', $s) }}"
                           class="btn btn-sm btn-success flex-fill">
                            <i class="fas fa-edit me-1"></i> Edit
                        </a>
                        <form action="{{ route('admin.suppliers.destroy', $s) }}" method="POST"
                              onsubmit="return confirm('Yakin ingin menghapus supplier ini?')"
                              class="flex-fill">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger w-100">
                                <i class="fas fa-trash me-1"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center py-5">
                    <div class="mb-3">
                        <i class="fas fa-building text-muted" style="font-size: 4rem; opacity: 0.3;"></i>
                    </div>
                    <h5 class="fw-bold mb-2">Belum ada supplier</h5>
                    <p class="text-muted mb-0">Klik tombol "Tambah Supplier" untuk menambahkan data</p>
                </div>
            </div>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($suppliers->hasPages())
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
                <div class="text-muted small">
                    Menampilkan {{ $suppliers->firstItem() }} - {{ $suppliers->lastItem() }} dari {{ $suppliers->total() }} data
                </div>
                <div class="supplier-pagination">
                    {{ $suppliers->appends(['kategori' => request('kategori'), 'search' => request('search')])->links() }}
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

@push('styles')
<style>
    /* Card hover effects */
    .card {
        transition: all 0.3s ease;
    }

    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
    }

    /* Input styling */
    .input-group-text {
        border-right: 0;
    }

    /* Border styling */
    .border-start.border-5 {
        border-left-width: 4px !important;
    }

    /* Text truncate */
    .text-truncate {
        max-width: 100%;
    }

    /* Badge styling */
    .badge.rounded-pill {
        padding: 0.4em 0.8em;
        font-size: 0.75rem;
        font-weight: 600;
    }

    /* Button hover effects */
    .btn {
        transition: all 0.2s ease;
    }

    .btn:hover {
        transform: translateY(-1px);
    }

    /* Icon sizing */
    .fas {
        display: inline-block;
    }

    /* Pagination styling fix */
    .supplier-pagination .pagination {
        margin-bottom: 0;
        gap: 0.25rem;
    }

    .supplier-pagination .page-link {
        color: #0d6efd;
        border-color: #dee2e6;
        padding: 0.375rem 0.75rem;
        min-width: 38px;
        text-align: center;
        font-size: 0.875rem;
        border-radius: 0.25rem;
    }

    .supplier-pagination .page-item.active .page-link {
        background-color: #0d6efd;
        border-color: #0d6efd;
        color: white;
    }

    .supplier-pagination .page-link:hover {
        background-color: #e9ecef;
        border-color: #dee2e6;
        color: #0d6efd;
    }

    /* Ukuran icon pagination lebih kecil */
    .supplier-pagination svg,
    .supplier-pagination i {
        font-size: 0.875rem;
        width: 1rem;
        height: 1rem;
    }

    /* Sembunyikan teks Previous dan Next */
    .supplier-pagination .page-link[rel="prev"],
    .supplier-pagination .page-link[rel="next"] {
        font-size: 0;
        padding: 0.375rem 0.5rem;
    }

    .supplier-pagination .page-link[rel="prev"]::before {
        content: "‹";
        font-size: 1.25rem;
        line-height: 1;
    }

    .supplier-pagination .page-link[rel="next"]::before {
        content: "›";
        font-size: 1.25rem;
        line-height: 1;
    }

    /* Ensure proper spacing */
    .row.g-3 {
        margin-bottom: 1rem;
    }
</style>
@endpush
@endsection
