@extends('admin.layouts.app')

@section('title', 'Jenis Barang')
@section('page-title', 'Jenis Barang')

@section('content')
<div class="container-fluid">

    <!-- Header dengan Breadcrumb -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="mb-3">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.kategori.index') }}" class="text-decoration-none">
                            <i class="fas fa-tags me-1"></i> Kategori
                        </a>
                    </li>
                    @if($kategori_id)
                        <li class="breadcrumb-item">
                            <span>{{ $kategoris->find($kategori_id)->nama_kategori ?? 'Kategori' }}</span>
                        </li>
                    @endif
                    <li class="breadcrumb-item active" aria-current="page">Jenis Barang</li>
                </ol>
            </nav>

            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="fw-bold mb-2">
                        Jenis Barang
                        @if($kategori_id)
                            <span class="text-muted">- {{ $kategoris->find($kategori_id)->nama_kategori }}</span>
                        @endif
                    </h4>
                    <p class="text-muted small mb-0">Kelola jenis barang untuk inventori klinik</p>
                </div>
                <a href="{{ route('jenis-barangs.create', ['kategori_id' => $kategori_id]) }}"
                    class="btn btn-primary">
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
                    class="btn {{ !$kategori_id ? 'btn-primary' : 'btn-outline-secondary' }}">
                    Semua
                </a>
                @foreach($kategoris as $kategori)
                    <a href="{{ route('jenis-barangs.index', ['kategori_id' => $kategori->id]) }}"
                        class="btn {{ $kategori_id == $kategori->id ? 'btn-primary' : 'btn-outline-secondary' }}">
                        {{ $kategori->nama_kategori }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <div class="d-flex align-items-center">
                <i class="fas fa-check-circle me-2"></i>
                <span>{{ session('success') }}</span>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
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
                <thead class="table-light">
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
                        <tr>
                            <td class="px-4 py-3">
                                <span class="text-muted">{{ $jenisBarangs->firstItem() + $index }}</span>
                            </td>
                            <td class="px-4 py-3">
                                <code class="bg-light px-2 py-1 rounded">{{ $jenisBarang->kode_jenis }}</code>
                            </td>
                            <td class="px-4 py-3">
                                <span class="fw-medium">{{ $jenisBarang->nama_jenis }}</span>
                            </td>
                            <td class="px-4 py-3">
                                <span class="badge {{ $jenisBarang->kategori->nama_kategori == 'Medis' ? 'bg-primary' : 'bg-success' }} rounded-pill">
                                    {{ $jenisBarang->kategori->nama_kategori }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="{{ route('jenis-barangs.show', $jenisBarang) }}"
                                        class="btn btn-sm btn-outline-primary"
                                        data-bs-toggle="tooltip"
                                        title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('jenis-barangs.edit', $jenisBarang) }}"
                                        class="btn btn-sm btn-outline-success"
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
                                            class="btn btn-sm btn-outline-danger"
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
                                    <i class="fas fa-box-open text-muted" style="font-size: 4rem; opacity: 0.3;"></i>
                                    <p class="text-muted fw-medium mb-0">Belum ada jenis barang</p>
                                    <a href="{{ route('jenis-barangs.create', ['kategori_id' => $kategori_id]) }}"
                                        class="btn btn-primary">
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
            <div class="card-footer bg-white border-top">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
                    <div class="text-muted small">
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
    .card {
        transition: all 0.3s ease;
    }

    .table > tbody > tr {
        transition: background-color 0.2s ease;
    }

    .btn {
        transition: all 0.2s ease;
    }

    .btn:hover:not(:disabled) {
        transform: translateY(-1px);
    }

    .breadcrumb-item + .breadcrumb-item::before {
        content: "›";
    }

    code {
        font-size: 0.875rem;
    }

    /* Pagination styling */
    .jenis-pagination .pagination {
        margin-bottom: 0;
        gap: 0.25rem;
    }

    .jenis-pagination .page-link {
        color: #0d6efd;
        border-color: #dee2e6;
        padding: 0.375rem 0.75rem;
        min-width: 38px;
        text-align: center;
        font-size: 0.875rem;
        border-radius: 0.25rem;
    }

    .jenis-pagination .page-item.active .page-link {
        background-color: #0d6efd;
        border-color: #0d6efd;
        color: white;
    }

    .jenis-pagination .page-link:hover {
        background-color: #e9ecef;
        border-color: #dee2e6;
        color: #0d6efd;
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
