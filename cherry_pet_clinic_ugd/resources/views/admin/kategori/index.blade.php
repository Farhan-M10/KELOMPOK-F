@extends('admin.layouts.app')

@section('title', 'Jenis Barang')
@section('page-title', 'Jenis Barang')

@section('content')
<div class="container-fluid" style="background-color: #E8F4F8; min-height: 100vh; padding: 2rem 0;">

    <!-- Header dengan Breadcrumb -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="mb-3">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.kategori.index') }}" class="text-decoration-none text-primary-custom">
                            <i class="fas fa-tags me-1"></i> Kategori
                        </a>
                    </li>
                    @if($kategori_id)
                        <li class="breadcrumb-item">
                            <span class="text-secondary">{{ $kategoris->find($kategori_id)->nama_kategori ?? 'Kategori' }}</span>
                        </li>
                    @endif
                    <li class="breadcrumb-item active text-dark" aria-current="page">Jenis Barang</li>
                </ol>
            </nav>

            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="fw-bold mb-2 text-dark">
                        Jenis Barang
                        @if($kategori_id)
                            <span class="text-secondary">- {{ $kategoris->find($kategori_id)->nama_kategori }}</span>
                        @endif
                    </h4>
                    <p class="text-secondary small mb-0">Kelola jenis barang untuk inventori klinik</p>
                </div>
                <a href="{{ route('jenis-barangs.create', ['kategori_id' => $kategori_id]) }}"
                    class="btn btn-danger-custom">
                    <i class="fas fa-plus me-2"></i> Tambah Baru
                </a>
            </div>
        </div>
    </div>

    <!-- Filter Kategori -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('jenis-barangs.index') }}"
                    class="btn {{ !$kategori_id ? 'btn-primary-custom' : 'btn-outline-custom' }}">
                    Semua
                </a>
                @foreach($kategoris as $kategori)
                    <a href="{{ route('jenis-barangs.index', ['kategori_id' => $kategori->id]) }}"
                        class="btn {{ $kategori_id == $kategori->id ? 'btn-primary-custom' : 'btn-outline-custom' }}">
                        {{ $kategori->nama_kategori }}
                    </a>
                @endforeach
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

    <!-- Tabel Jenis Barang -->
    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-header-custom">
                    <tr>
                        <th class="px-4 py-3 text-uppercase small fw-semibold">No</th>
                        <th class="px-4 py-3 text-uppercase small fw-semibold">Kode Jenis</th>
                        <th class="px-4 py-3 text-uppercase small fw-semibold">Nama Jenis</th>
                        <th class="px-4 py-3 text-uppercase small fw-semibold">Kategori</th>
                        <th class="px-4 py-3 text-center text-uppercase small fw-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jenisBarangs as $index => $jenisBarang)
                        <tr class="table-row-custom">
                            <td class="px-4 py-3">
                                <span class="text-medium">{{ $jenisBarangs->firstItem() + $index }}</span>
                            </td>
                            <td class="px-4 py-3">
                                <code class="code-badge">{{ $jenisBarang->kode_jenis }}</code>
                            </td>
                            <td class="px-4 py-3">
                                <span class="fw-medium text-dark">{{ $jenisBarang->nama_jenis }}</span>
                            </td>
                            <td class="px-4 py-3">
                                <span class="badge {{ $jenisBarang->kategori->nama_kategori == 'Medis' ? 'badge-success-custom' : 'badge-primary-custom' }} rounded-pill">
                                    {{ $jenisBarang->kategori->nama_kategori }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="{{ route('jenis-barangs.show', $jenisBarang) }}"
                                        class="btn btn-sm btn-primary-custom"
                                        data-bs-toggle="tooltip"
                                        title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('jenis-barangs.edit', $jenisBarang) }}"
                                        class="btn btn-sm btn-success-custom"
                                        data-bs-toggle="tooltip"
                                        title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('jenis-barangs.destroy', $jenisBarang) }}"
                                        method="POST"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus jenis barang ini?')"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="btn btn-sm btn-danger-custom"
                                            data-bs-toggle="tooltip"
                                            title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <div class="d-flex flex-column align-items-center gap-3">
                                    <i class="fas fa-box-open text-light-custom" style="font-size: 4rem; opacity: 0.3;"></i>
                                    <p class="text-secondary fw-medium mb-0">Belum ada jenis barang</p>
                                    <a href="{{ route('jenis-barangs.create', ['kategori_id' => $kategori_id]) }}"
                                        class="btn btn-danger-custom">
                                        <i class="fas fa-plus me-2"></i> Tambah Jenis Barang
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($jenisBarangs->hasPages())
            <div class="card-footer bg-white border-top border-light-custom">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
                    <div class="text-secondary small">
                        Menampilkan {{ $jenisBarangs->firstItem() }} - {{ $jenisBarangs->lastItem() }} dari {{ $jenisBarangs->total() }} data
                    </div>
                    <div class="jenis-pagination">
                        {{ $jenisBarangs->appends(['kategori_id' => $kategori_id])->links() }}
                    </div>
                </div>
            </div>
        @endif
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

    /* Breadcrumb */
    .breadcrumb-item + .breadcrumb-item::before {
        content: "›";
        color: var(--text-medium);
    }

    /* Pagination styling */
    .jenis-pagination .pagination {
        margin-bottom: 0;
        gap: 0.25rem;
    }

    .jenis-pagination .page-link {
        color: var(--primary-medium);
        border-color: var(--border-light);
        padding: 0.375rem 0.75rem;
        min-width: 38px;
        text-align: center;
        font-size: 0.875rem;
        border-radius: 0.25rem;
    }

    .jenis-pagination .page-item.active .page-link {
        background-color: var(--primary-medium);
        border-color: var(--primary-medium);
        color: white;
    }

    .jenis-pagination .page-link:hover {
        background-color: var(--bg-very-light);
        border-color: var(--border-light);
        color: var(--primary-medium);
    }

    /* Sembunyikan teks Previous dan Next */
    .jenis-pagination .page-link[rel="prev"],
    .jenis-pagination .page-link[rel="next"] {
        font-size: 0;
        padding: 0.375rem 0.5rem;
    }

    .jenis-pagination .page-link[rel="prev"]::before {
        content: "‹";
        font-size: 1.25rem;
        line-height: 1;
    }

    .jenis-pagination .page-link[rel="next"]::before {
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
