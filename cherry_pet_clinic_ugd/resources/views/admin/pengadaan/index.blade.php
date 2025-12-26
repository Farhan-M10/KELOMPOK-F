@extends('admin.layouts.app')

@section('content')
<div class="container-fluid" style="background-color: #E8F4F8; min-height: 100vh; padding: 2rem 0;">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb bg-transparent">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.dashboard') }}" class="text-decoration-none text-primary-custom">
                    <i class="fas fa-home me-1"></i>Beranda
                </a>
            </li>
            <li class="breadcrumb-item active text-dark" aria-current="page">Pengadaan Stok</li>
        </ol>
    </nav>

    <!-- Header -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="fw-bold mb-2 text-dark">Pengadaan Stok</h4>
                    <p class="text-secondary small mb-0">Kelola pengadaan stok barang dari pemasok</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="alert alert-success-custom alert-dismissible fade show" role="alert">
            <div class="d-flex align-items-center">
                <i class="fas fa-check-circle me-2"></i>
                <span>{{ session('success') }}</span>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger-custom alert-dismissible fade show" role="alert">
            <div class="d-flex align-items-center">
                <i class="fas fa-exclamation-circle me-2"></i>
                <span>{{ session('error') }}</span>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Filter & Search -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('pengadaan.index') }}" class="row g-3">
                <div class="col-md-5">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0 border-custom">
                            <i class="fas fa-search text-light-custom"></i>
                        </span>
                        <input type="text"
                               name="search"
                               class="form-control border-start-0 border-custom ps-0"
                               placeholder="Cari berdasarkan ID atau Supplier"
                               value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <select name="status" class="form-select border-custom">
                        <option value="">Semua Status</option>
                        <option value="Disetujui" {{ request('status') == 'Disetujui' ? 'selected' : '' }}>Disetujui</option>
                        <option value="Menunggu" {{ request('status') == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                        <option value="Ditolak" {{ request('status') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary-custom w-100">
                        <i class="fas fa-search me-1"></i> Cari
                    </button>
                </div>
                <div class="col-md-2">
                    <a href="{{ route('pengadaan.create') }}" class="btn btn-danger-custom w-100">
                        <i class="fas fa-plus me-1"></i> Tambah
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-header-custom">
                        <tr>
                            <th class="px-4 py-3 text-uppercase small fw-semibold">ID Pengadaan</th>
                            <th class="px-4 py-3 text-uppercase small fw-semibold">Tanggal</th>
                            <th class="px-4 py-3 text-uppercase small fw-semibold">Pemasok</th>
                            <th class="px-4 py-3 text-uppercase small fw-semibold">Total Biaya</th>
                            <th class="px-4 py-3 text-uppercase small fw-semibold">Status</th>
                            <th class="px-4 py-3 text-center text-uppercase small fw-semibold" width="12%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pengadaanStok as $item)
                        <tr class="table-row-custom">
                            <td class="px-4 py-3">
                                <code class="code-badge">{{ $item->id_pengadaan }}</code>
                            </td>
                            <td class="px-4 py-3">
                                <span class="text-dark">{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</span>
                            </td>
                            <td class="px-4 py-3">
                                <span class="fw-medium text-dark">{{ $item->supplier->nama_supplier ?? 'N/A' }}</span>
                            </td>
                            <td class="px-4 py-3">
                                <span class="fw-medium text-dark">Rp {{ number_format($item->total_harga, 0, ',', '.') }}</span>
                            </td>
                            <td class="px-4 py-3">
                                @if($item->status == 'Disetujui')
                                    <span class="badge badge-success-custom rounded-pill">Disetujui</span>
                                @elseif($item->status == 'Menunggu')
                                    <span class="badge badge-warning-custom rounded-pill">Menunggu</span>
                                @else
                                    <span class="badge badge-danger-custom rounded-pill">Ditolak</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <div class="action-buttons">
                                    <a href="{{ route('pengadaan.show', $item->id) }}"
                                       class="action-btn action-btn-info"
                                       data-bs-toggle="tooltip"
                                       title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if($item->status == 'Menunggu')
                                    <a href="{{ route('pengadaan.edit', $item->id) }}"
                                       class="action-btn action-btn-warning"
                                       data-bs-toggle="tooltip"
                                       title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('pengadaan.destroy', $item->id) }}"
                                          method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('Yakin ingin menghapus?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="action-btn action-btn-danger"
                                                data-bs-toggle="tooltip"
                                                title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="d-flex flex-column align-items-center gap-3">
                                    <i class="fas fa-box-open text-light-custom" style="font-size: 4rem; opacity: 0.3;"></i>
                                    <p class="text-secondary fw-medium mb-0">Tidak ada data pengadaan</p>
                                    <a href="{{ route('pengadaan.create') }}" class="btn btn-danger-custom">
                                        <i class="fas fa-plus me-2"></i> Tambah Pengadaan
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($pengadaanStok->hasPages())
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3 mt-4 pt-3 border-top border-light-custom">
                <div class="text-secondary small">
                    Menampilkan {{ $pengadaanStok->firstItem() ?? 0 }} - {{ $pengadaanStok->lastItem() ?? 0 }} dari {{ $pengadaanStok->total() }} data
                </div>
                <div class="pengadaan-pagination">
                    {{ $pengadaanStok->links() }}
                </div>
            </div>
            @endif
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

    .text-medium {
        color: var(--text-medium) !important;
    }

    .text-light-custom {
        color: var(--text-light) !important;
    }

    .text-primary-custom {
        color: var(--primary-medium) !important;
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
        transform: translateY(-2px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
    }

    /* Action Buttons */
    .action-buttons {
        display: flex;
        gap: 6px;
        justify-content: center;
    }

    .action-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        border: 1px solid;
        border-radius: 6px;
        background: white;
        cursor: pointer;
        transition: all 0.2s;
        text-decoration: none;
        padding: 0;
        font-size: 14px;
    }

    /* Detail Button - Biru */
    .action-btn-info {
        color: #0066B3;
        border-color: #0066B3;
    }

    .action-btn-info:hover {
        background: #0066B3;
        color: white;
    }

    /* Edit Button - Kuning/Orange */
    .action-btn-warning {
        color: #F59E0B;
        border-color: #F59E0B;
    }

    .action-btn-warning:hover {
        background: #F59E0B;
        color: white;
    }

    /* Delete Button - Merah */
    .action-btn-danger {
        color: #E31E24;
        border-color: #E31E24;
    }

    .action-btn-danger:hover {
        background: #E31E24;
        color: white;
    }

    .action-btn i {
        font-size: 13px;
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

    .btn-warning-custom {
        background-color: var(--warning-color);
        border-color: var(--warning-color);
        color: white;
    }

    .btn-warning-custom:hover {
        background-color: #d97706;
        border-color: #d97706;
        color: white;
    }

    /* Badges */
    .badge-primary-custom {
        background-color: var(--primary-medium);
        color: white;
        padding: 0.4em 0.8em;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .badge-success-custom {
        background-color: var(--success-color);
        color: white;
        padding: 0.4em 0.8em;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .badge-danger-custom {
        background-color: var(--error-color);
        color: white;
        padding: 0.4em 0.8em;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .badge-warning-custom {
        background-color: var(--warning-color);
        color: white;
        padding: 0.4em 0.8em;
        font-size: 0.75rem;
        font-weight: 600;
    }

    /* Code Badge */
    .code-badge {
        background-color: var(--bg-light);
        color: var(--text-dark);
        padding: 0.25rem 0.5rem;
        border-radius: 0.25rem;
        font-size: 0.875rem;
        font-family: 'Courier New', monospace;
    }

    /* Table Styling */
    .table-header-custom {
        background-color: var(--bg-light);
        color: var(--text-secondary);
    }

    .table-row-custom {
        transition: background-color 0.2s ease;
    }

    .table-row-custom:hover {
        background-color: var(--bg-very-light);
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

    .alert-danger-custom {
        background-color: var(--error-bg);
        border-color: var(--error-color);
        color: var(--text-dark);
    }

    .alert-danger-custom .fas {
        color: var(--error-color);
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

    /* Breadcrumb */
    .breadcrumb-item + .breadcrumb-item::before {
        content: "›";
        color: var(--text-medium);
    }

    /* Pagination styling */
    .pengadaan-pagination .pagination {
        margin-bottom: 0;
        gap: 0.25rem;
    }

    .pengadaan-pagination .page-link {
        color: var(--primary-medium);
        border-color: var(--border-light);
        padding: 0.375rem 0.75rem;
        min-width: 38px;
        text-align: center;
        font-size: 0.875rem;
        border-radius: 0.25rem;
    }

    .pengadaan-pagination .page-item.active .page-link {
        background-color: var(--primary-medium);
        border-color: var(--primary-medium);
        color: white;
    }

    .pengadaan-pagination .page-link:hover {
        background-color: var(--bg-very-light);
        border-color: var(--border-light);
        color: var(--primary-medium);
    }

    /* Sembunyikan teks Previous dan Next */
    .pengadaan-pagination .page-link[rel="prev"],
    .pengadaan-pagination .page-link[rel="next"] {
        font-size: 0;
        padding: 0.375rem 0.5rem;
    }

    .pengadaan-pagination .page-link[rel="prev"]::before {
        content: "‹";
        font-size: 1.25rem;
        line-height: 1;
    }

    .pengadaan-pagination .page-link[rel="next"]::before {
        content: "›";
        font-size: 1.25rem;
        line-height: 1;
    }

    /* Tooltip styling */
    .tooltip-inner {
        font-size: 0.75rem;
        background-color: var(--text-dark);
    }
</style>
@endpush

@push('scripts')
<script>
    // Initialize Bootstrap tooltips
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>
@endpush
@endsection
