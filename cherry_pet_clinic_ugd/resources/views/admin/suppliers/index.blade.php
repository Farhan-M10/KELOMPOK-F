@extends('admin.layouts.app')

@section('title', 'Data Supplier')
@section('page-title', 'Pemasok')

@section('content')
<div class="container-fluid" style="background-color: #E8F4F8; min-height: 100vh; padding: 2rem 0;">

    <!-- Stats Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-secondary small mb-1">Total Supplier</p>
                            <h3 class="fw-bold mb-0 text-dark">{{ \App\Models\Supplier::count() }}</h3>
                        </div>
                        <div class="bg-primary-light p-3 rounded">
                            <i class="fas fa-building text-primary-custom fs-4"></i>
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
                            <p class="text-secondary small mb-1">Supplier Aktif</p>
                            <h3 class="fw-bold mb-0 text-dark">{{ \App\Models\Supplier::where('status', 'aktif')->count() }}</h3>
                        </div>
                        <div class="bg-success-light p-3 rounded">
                            <i class="fas fa-check-circle text-success-custom fs-4"></i>
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
                            <p class="text-secondary small mb-1">Jenis Produk</p>
                            <h3 class="fw-bold mb-0 text-dark">{{ \App\Models\JenisBarang::count() }}</h3>
                        </div>
                        <div class="bg-warning-light p-3 rounded">
                            <i class="fas fa-boxes text-warning-custom fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Search & Filter Bar -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.suppliers.index') }}" class="row g-3" id="filterForm">
                <div class="col-md-5">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0 border-custom">
                            <i class="fas fa-search text-light-custom"></i>
                        </span>
                        <input type="text"
                               name="search"
                               value="{{ request('search') }}"
                               placeholder="Cari nama supplier, NIB, atau alamat..."
                               class="form-control border-start-0 border-custom ps-0">
                    </div>
                </div>

                <div class="col-md-3">
                    <select name="kategori" class="form-select border-custom" id="kategoriFilter">
                        <option value="">Semua Jenis Produk</option>
                        <option value="Medis" {{ request('kategori') == 'Medis' ? 'selected' : '' }}>Medis</option>
                        <option value="Non-Medis" {{ request('kategori') == 'Non-Medis' ? 'selected' : '' }}>Non Medis</option>
                    </select>
                </div>

                <div class="col-md-4 text-end">
                    <button type="submit" class="btn btn-primary-custom">
                        <i class="fas fa-filter me-1"></i> Filter
                    </button>
                    <a href="{{ route('admin.suppliers.index') }}" class="btn btn-secondary-custom">
                        <i class="fas fa-redo me-1"></i> Reset
                    </a>
                    <a href="{{ route('admin.suppliers.create') }}" class="btn btn-danger-custom">
                        <i class="fas fa-plus me-1"></i> Tambah Supplier
                    </a>
                </div>
            </form>
        </div>
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

    <!-- Supplier Grid -->
    <div class="row g-3 mb-4">
        @forelse($suppliers as $s)
        <div class="col-md-6 col-lg-6">
            <div class="card border-0 shadow-sm h-100 border-start border-5 {{ $s->kategori->nama_kategori == 'Medis' ? 'border-success-custom' : 'border-primary-custom' }}">
                <div class="card-body">
                    <!-- Header -->
                    <div class="d-flex justify-content-between align-items-start mb-3 pb-3 border-bottom border-light-custom">
                        <div>
                            <h5 class="card-title fw-bold mb-1 text-dark">{{ $s->nama_supplier }}</h5>
                            <p class="text-secondary small mb-0">NIB: {{ $s->nib }}</p>
                        </div>
                        <span class="badge {{ $s->kategori->nama_kategori == 'Medis' ? 'badge-success-custom' : 'badge-primary-custom' }} rounded-pill">
                            {{ $s->kategori->nama_kategori }}
                        </span>
                    </div>

                    <!-- Info Section -->
                    <div class="mb-3">
                        <div class="d-flex align-items-start mb-2">
                            <i class="fas fa-boxes text-medium me-2 mt-1" style="width: 16px;"></i>
                            <div class="flex-grow-1">
                                <p class="text-secondary small mb-0">Jenis Barang</p>
                                <p class="fw-medium mb-0 text-dark">{{ $s->jenisBarang->nama_jenis }}</p>
                            </div>
                        </div>

                        <div class="d-flex align-items-start mb-2">
                            <i class="fas fa-map-marker-alt text-medium me-2 mt-1" style="width: 16px;"></i>
                            <div class="flex-grow-1">
                                <p class="text-secondary small mb-0">Alamat</p>
                                <p class="fw-medium mb-0 text-truncate text-dark">{{ $s->alamat }}</p>
                            </div>
                        </div>

                        <div class="d-flex align-items-start">
                            <i class="fas fa-phone text-medium me-2 mt-1" style="width: 16px;"></i>
                            <div class="flex-grow-1">
                                <p class="text-secondary small mb-0">Kontak</p>
                                <p class="fw-medium mb-0 text-dark">{{ $s->kontak }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex gap-2 pt-3 border-top border-light-custom">
                        <a href="{{ route('admin.suppliers.show', $s) }}"
                           class="btn btn-sm btn-primary-custom flex-fill">
                            <i class="fas fa-eye me-1"></i> Detail
                        </a>
                        <a href="{{ route('admin.suppliers.edit', $s) }}"
                           class="btn btn-sm btn-success-custom flex-fill">
                            <i class="fas fa-edit me-1"></i> Edit
                        </a>
                        <form action="{{ route('admin.suppliers.destroy', $s) }}" method="POST"
                              onsubmit="return confirm('Yakin ingin menghapus supplier ini?')"
                              class="flex-fill">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger-custom w-100">
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
                        <i class="fas fa-building text-light-custom" style="font-size: 4rem; opacity: 0.3;"></i>
                    </div>
                    <h5 class="fw-bold mb-2 text-dark">
                        @if(request('kategori') || request('search'))
                            Tidak ada supplier yang sesuai dengan filter
                        @else
                            Belum ada supplier
                        @endif
                    </h5>
                    <p class="text-secondary mb-0">
                        @if(request('kategori') || request('search'))
                            Coba ubah filter pencarian Anda
                        @else
                            Klik tombol "Tambah Supplier" untuk menambahkan data
                        @endif
                    </p>
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
                <div class="text-secondary small">
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

    /* Background Colors */
    .bg-primary-light {
        background-color: rgba(0, 102, 179, 0.1) !important;
    }

    .bg-success-light {
        background-color: rgba(31, 189, 136, 0.1) !important;
    }

    .bg-warning-light {
        background-color: rgba(245, 158, 11, 0.1) !important;
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

    .text-light-custom {
        color: var(--text-light) !important;
    }

    .text-primary-custom {
        color: var(--primary-medium) !important;
    }

    .text-success-custom {
        color: var(--success-color) !important;
    }

    .text-warning-custom {
        color: var(--warning-color) !important;
    }

    /* Border Colors */
    .border-custom {
        border-color: var(--border-normal) !important;
    }

    .border-light-custom {
        border-color: var(--border-light) !important;
    }

    .border-primary-custom {
        border-color: var(--primary-medium) !important;
    }

    .border-success-custom {
        border-color: var(--success-color) !important;
    }

    /* Badges */
    .badge-primary-custom {
        background-color: var(--primary-medium);
        color: white;
    }

    .badge-success-custom {
        background-color: var(--success-color);
        color: white;
    }

    .badge.rounded-pill {
        padding: 0.4em 0.8em;
        font-size: 0.75rem;
        font-weight: 600;
    }

    /* Buttons */
    .btn {
        transition: all 0.2s ease;
        font-weight: 500;
    }

    .btn:hover {
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

    /* Alert */
    .alert-success-custom {
        background-color: var(--success-bg);
        border-color: var(--success-color);
        color: var(--text-dark);
    }

    .alert-success-custom .fas {
        color: var(--success-color);
    }

    /* Card hover effects */
    .card {
        transition: all 0.3s ease;
        background-color: white;
    }

    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
    }

    /* Input styling */
    .input-group-text {
        border-right: 0;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: var(--primary-medium);
        box-shadow: 0 0 0 0.25rem rgba(0, 102, 179, 0.15);
    }

    /* Border styling */
    .border-start.border-5 {
        border-left-width: 4px !important;
    }

    /* Text truncate */
    .text-truncate {
        max-width: 100%;
    }

    /* Pagination styling */
    .supplier-pagination .pagination {
        margin-bottom: 0;
        gap: 0.25rem;
    }

    .supplier-pagination .page-link {
        color: var(--primary-medium);
        border-color: var(--border-light);
        padding: 0.25rem 0.5rem;
        min-width: 32px;
        text-align: center;
        font-size: 0.813rem;
        border-radius: 0.25rem;
    }

    .supplier-pagination .page-item.active .page-link {
        background-color: var(--primary-medium);
        border-color: var(--primary-medium);
        color: white;
    }

    .supplier-pagination .page-link:hover {
        background-color: var(--bg-very-light);
        border-color: var(--border-light);
        color: var(--primary-medium);
    }

    /* Sembunyikan teks Previous dan Next */
    .supplier-pagination .page-link[rel="prev"],
    .supplier-pagination .page-link[rel="next"] {
        font-size: 0;
        padding: 0.25rem 0.4rem;
    }

    .supplier-pagination .page-link[rel="prev"]::before {
        content: "‹";
        font-size: 1rem;
        line-height: 1;
    }

    .supplier-pagination .page-link[rel="next"]::before {
        content: "›";
        font-size: 1rem;
        line-height: 1;
    }

    /* Ensure proper spacing */
    .row.g-3 {
        margin-bottom: 1rem;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .text-end {
            text-align: left !important;
        }

        .btn {
            width: 100%;
            margin-bottom: 0.5rem;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    // Optional: Auto-submit saat kategori dipilih (uncomment jika ingin fitur ini)
    // document.getElementById('kategoriFilter')?.addEventListener('change', function() {
    //     document.getElementById('filterForm').submit();
    // });
</script>
@endpush
@endsection
