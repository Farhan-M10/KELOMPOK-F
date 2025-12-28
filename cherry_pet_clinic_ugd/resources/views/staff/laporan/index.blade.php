@extends('staff.layouts.app')

@section('title', 'Laporan Pengurangan Stok')
@section('page-title', 'Laporan')

@section('content')
<div class="container-fluid">

    {{-- Statistik Cards --}}
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="stat-card card border-0 shadow-sm">
                <div class="card-body d-flex align-items-center">
                    <div class="stat-icon bg-primary-subtle text-primary">
                        <i class="fas fa-box fa-2x"></i>
                    </div>
                    <div class="ms-3">
                        <h6 class="text-muted mb-1">Total Barang Keluar</h6>
                        <h2 class="mb-0 fw-bold">{{ $totalBarangKeluar }}</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="stat-card card border-0 shadow-sm">
                <div class="card-body d-flex align-items-center">
                    <div class="stat-icon bg-danger-subtle text-danger">
                        <i class="fas fa-exclamation-triangle fa-2x"></i>
                    </div>
                    <div class="ms-3">
                        <h6 class="text-muted mb-1">Barang Keluar Terbanyak</h6>
                        <h2 class="mb-0 fw-bold">{{ $barangKritisCount }}</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="stat-card card border-0 shadow-sm">
                <div class="card-body d-flex align-items-center">
                    <div class="stat-icon bg-warning-subtle text-warning">
                        <i class="fas fa-clipboard-list fa-2x"></i>
                    </div>
                    <div class="ms-3">
                        <h6 class="text-muted mb-1">Jumlah Pengurangan Tercatat</h6>
                        <h2 class="mb-0 fw-bold">{{ $jumlahPenguranganTercatat }}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Filter Section --}}
    <div class="card mb-4 border-0 shadow-sm">
        <div class="card-body">
            <form action="{{ route('staff.laporan.index') }}" method="GET" id="filterForm">
                <div class="row g-3 align-items-end">
                    <div class="col-md-2">
                        <label class="form-label fw-semibold">Periode</label>
                        <select name="periode" class="form-select">
                            <option value="">Bulan Ini</option>
                            <option value="Hari Ini" {{ request('periode') == 'Hari Ini' ? 'selected' : '' }}>Hari Ini</option>
                            <option value="Minggu Ini" {{ request('periode') == 'Minggu Ini' ? 'selected' : '' }}>Minggu Ini</option>
                            <option value="Bulan Ini" {{ request('periode') == 'Bulan Ini' ? 'selected' : '' }}>Bulan Ini</option>
                            <option value="Tahun Ini" {{ request('periode') == 'Tahun Ini' ? 'selected' : '' }}>Tahun Ini</option>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label fw-semibold">Dari Tanggal</label>
                        <input type="date" name="dari_tanggal" class="form-control" value="{{ request('dari_tanggal') }}">
                    </div>

                    <div class="col-md-2">
                        <label class="form-label fw-semibold">Sampai Tanggal</label>
                        <input type="date" name="sampai_tanggal" class="form-control" value="{{ request('sampai_tanggal') }}">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Pencarian Barang</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white">
                                <i class="fas fa-search text-muted"></i>
                            </span>
                            <input type="text" name="search" class="form-control" placeholder="Cari nama barang..." value="{{ request('search') }}">
                        </div>
                    </div>

                    <div class="col-md-3 text-end">
                        <button type="button" class="btn btn-danger" onclick="exportPdf()">
                            <i class="fas fa-file-pdf me-1"></i> Export PDF
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Tabel Laporan --}}
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>TANGGAL</th>
                            <th>NAMA BARANG</th>
                            <th>JUMLAH DIKURANGI</th>
                            <th>TUJUAN PENGGUNAAN</th>
                            <th>STAFF</th>
                            <th class="text-center">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($laporanPengurangan as $laporan)
                            <tr>
                                <td>
                                    <span class="fw-semibold">{{ $laporan->tanggal_pengurangan->format('d M Y H:i') }}</span>
                                </td>
                                <td>
                                    <div class="fw-semibold">{{ $laporan->batchBarang->barang->nama_barang }}</div>
                                    <small class="text-muted">Batch: {{ $laporan->batchBarang->nomor_batch }}</small>
                                </td>
                                <td>
                                    <span class="badge bg-danger">-{{ $laporan->jumlah_pengurangan }} {{ $laporan->batchBarang->barang->satuan }}</span>
                                </td>
                                <td>
                                    @if($laporan->alasan == 'Digunakan untuk pemeriksaan pasien')
                                        <span class="badge bg-info">
                                            <i class="fas fa-stethoscope me-1"></i> Penjualan
                                        </span>
                                        <div class="small text-muted mt-1">{{ $laporan->alasan }}</div>
                                    @elseif($laporan->alasan == 'Digunakan untuk operasi')
                                        <span class="badge bg-success">
                                            <i class="fas fa-procedures me-1"></i> Digunakan Internal
                                        </span>
                                        <div class="small text-muted mt-1">{{ $laporan->alasan }}</div>
                                    @elseif($laporan->alasan == 'Rusak/Kadaluarsa')
                                        <span class="badge bg-warning text-dark">
                                            <i class="fas fa-exclamation-circle me-1"></i> Rusak / Expired
                                        </span>
                                        <div class="small text-muted mt-1">{{ $laporan->alasan }}</div>
                                    @elseif($laporan->alasan == 'Hilang')
                                        <span class="badge bg-danger">
                                            <i class="fas fa-times-circle me-1"></i> Hilang
                                        </span>
                                        <div class="small text-muted mt-1">{{ $laporan->alasan }}</div>
                                    @else
                                        <span class="badge bg-secondary">
                                            <i class="fas fa-info-circle me-1"></i> {{ $laporan->alasan }}
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <span class="fw-semibold">{{ $laporan->user->name }}</span>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('staff.laporan.show', $laporan->id) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye me-1"></i> Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                                    <p class="mb-0">Tidak ada data laporan pengurangan stok</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($laporanPengurangan->hasPages())
                <div class="card-footer bg-white border-top">
                    {{ $laporanPengurangan->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

<style>
.stat-card {
    transition: transform 0.3s;
}

.stat-card:hover {
    transform: translateY(-5px);
}

.stat-icon {
    width: 60px;
    height: 60px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.card {
    border-radius: 12px;
}

.table thead th {
    font-weight: 600;
    font-size: 13px;
    color: #6c757d;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.badge {
    padding: 6px 12px;
    font-weight: 500;
}

.form-label {
    font-size: 13px;
    color: #495057;
}
</style>

@push('scripts')
<script>
// Auto submit filter
document.querySelectorAll('select[name="periode"]').forEach(function(select) {
    select.addEventListener('change', function() {
        document.getElementById('filterForm').submit();
    });
});

document.querySelectorAll('input[name="dari_tanggal"], input[name="sampai_tanggal"]').forEach(function(input) {
    input.addEventListener('change', function() {
        document.getElementById('filterForm').submit();
    });
});

// Export PDF
function exportPdf() {
    Swal.fire({
        icon: 'info',
        title: 'Fitur Export PDF',
        text: 'Fitur export PDF sedang dalam pengembangan',
        confirmButtonColor: '#0066B3'
    });
}
</script>
@endpush
@endsection
