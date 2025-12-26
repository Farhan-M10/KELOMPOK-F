{{-- File: resources/views/stok_barang/index.blade.php --}}

@extends('admin.layouts.app')

@section('content')
<div class="container-fluid" style="background-color: #E8F4F8; min-height: 100vh; padding: 20px;">
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="card border-0 mb-3">
        <div class="card-body p-0">
            <ul class="nav nav-tabs nav-fill custom-tabs">
                <li class="nav-item">
                    <a class="nav-link @if(request('jenis_tab') != 'non-medis') active @endif"
                       href="{{ route('admin.stok_barang.index', array_merge(request()->except('jenis_tab', 'kategori_id'), ['jenis_tab' => 'medis'])) }}">
                        Medis
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @if(request('jenis_tab') == 'non-medis') active @endif"
                       href="{{ route('admin.stok_barang.index', array_merge(request()->except('jenis_tab', 'kategori_id'), ['jenis_tab' => 'non-medis'])) }}">
                        Non-Medis
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.stok_barang.index') }}">
                <input type="hidden" name="jenis_tab" value="{{ request('jenis_tab', 'medis') }}">

                <div class="row g-2">
                    <div class="col-md-3">
                        <input type="text" name="search" class="form-control"
                               placeholder="Cari barang..." value="{{ request('search') }}">
                    </div>

                    <div class="col-md-2">
                        <select name="kategori_id" class="form-select">
                            <option value="">Semua Kategori</option>
                            @if(request('jenis_tab') == 'non-medis')
                                @foreach($kategoris->where('jenis', 'non-medis') as $kategori)
                                <option value="{{ $kategori->id }}" @if(request('kategori_id') == $kategori->id) selected @endif>
                                    {{ $kategori->nama_kategori }}
                                </option>
                                @endforeach
                            @else
                                @foreach($kategoris->where('jenis', 'medis') as $kategori)
                                <option value="{{ $kategori->id }}" @if(request('kategori_id') == $kategori->id) selected @endif>
                                    {{ $kategori->nama_kategori }}
                                </option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <div class="col-md-2">
                        <select name="lokasi" class="form-select">
                            <option value="">Semua Lokasi</option>
                            <option value="Rak A" @if(request('lokasi') == 'Rak A') selected @endif>Rak A</option>
                            <option value="Rak B" @if(request('lokasi') == 'Rak B') selected @endif>Rak B</option>
                            <option value="Kulkas E" @if(request('lokasi') == 'Kulkas E') selected @endif>Kulkas E</option>
                            <option value="Kulkas V" @if(request('lokasi') == 'Kulkas V') selected @endif>Kulkas V</option>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <select name="status" class="form-select">
                            <option value="">Semua Status</option>
                            <option value="Stok Aman" @if(request('status') == 'Stok Aman') selected @endif>Stok Aman</option>
                            <option value="Perhatian" @if(request('status') == 'Perhatian') selected @endif>Perhatian</option>
                            <option value="Kritis" @if(request('status') == 'Kritis') selected @endif>Kritis</option>
                        </select>
                    </div>

                    <div class="col-md-3 text-end">
                        <a href="{{ route('admin.stok_barang.export') }}" class="btn btn-success btn-sm">
                            <i class="fas fa-download"></i> Export
                        </a>
                        <a href="{{ route('admin.stok_barang.create') }}" class="btn btn-danger btn-sm">
                            <i class="fas fa-plus"></i> Tambah barang
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 stok-table">
                    <thead class="table-header-custom">
                        <tr>
                            <th class="th-padding">NAMA BARANG</th>
                            <th class="th-padding">KATEGORI</th>
                            <th class="th-padding">LOKASI</th>
                            <th class="th-padding">TOTAL STOK</th>
                            <th class="th-padding">BATCH &amp; KADALUARSA</th>
                            <th class="th-padding">STATUS</th>
                            <th class="th-padding text-center">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($barangs as $barang)
                        <tr class="table-row-custom">
                            <td class="td-padding">
                                <strong class="barang-title">{{ $barang->nama_barang }}</strong>
                            </td>
                            <td class="td-padding">{{ $barang->kategori->nama_kategori ?? '-' }}</td>
                            <td class="td-padding">
                                <strong>{{ $barang->lokasi }}</strong><br>
                                <small class="text-muted">{{ $barang->ruangan }}</small>
                            </td>
                            <td class="td-padding">
                                <strong>{{ $barang->total_stok }} {{ $barang->satuan }}</strong><br>
                                <small class="text-muted">{{ $barang->jumlahBatch() }} Batch</small>
                                @if($barang->isStokRendah())
                                <br><span class="badge bg-warning text-dark badge-xs">Stok Rendah</span>
                                @endif
                            </td>
                            <td class="td-padding">
                                @foreach($barang->batchBarangs as $batch)
                                <div class="batch-card">
                                    <strong class="text-primary batch-id">{{ $batch->nomor_batch }}</strong><br>
                                    <small class="batch-info">
                                        Masuk: {{ $batch->tanggal_masuk->format('d M Y') }}<br>
                                        <span class="text-danger">
                                            EXP: {{ $batch->tanggal_kadaluarsa->format('d M Y') }}
                                        </span>
                                    </small>
                                    <div class="mt-1">
                                        <strong class="batch-amount">{{ $batch->jumlah }} {{ $barang->satuan }}</strong>
                                    </div>
                                </div>
                                @endforeach
                            </td>
                            <td class="td-padding">
                                @foreach($barang->batchBarangs as $batch)
                                <div class="mb-2">
                                    <span class="badge bg-{{ $batch->getBadgeClass() }} badge-status">
                                        {{ $batch->status }}
                                    </span>
                                </div>
                                @endforeach
                            </td>
                            <td class="td-padding text-center">
                                <a href="{{ route('admin.stok_barang.edit', $barang->id) }}"
                                   class="btn btn-sm btn-outline-primary btn-action">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.stok_barang.destroy', $barang->id) }}"
                                      method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="btn btn-sm btn-outline-danger btn-action"
                                            onclick="return confirm('Yakin ingin menghapus barang ini?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <p class="text-muted mb-0">Tidak ada data barang @if(request('jenis_tab') == 'non-medis') non-medis @else medis @endif</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

   {{-- Pagination Footer --}}
<div class="card mt-3 border-0">
    <div class="card-body py-3">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <small class="text-muted">
                    Menampilkan {{ $barangs->firstItem() ?? 0 }}-{{ $barangs->lastItem() ?? 0 }} dari {{ $barangs->total() }} barang
                </small>
            </div>
            <div>
                <nav aria-label="Page navigation">
                    <ul class="pagination pagination-custom mb-0">
                        {{-- Previous Button --}}
                        <li class="page-item @if($barangs->onFirstPage()) disabled @endif">
                            <a class="page-link" href="{{ $barangs->previousPageUrl() }}" aria-label="Previous">
                                <span aria-hidden="true">&lsaquo;</span>
                            </a>
                        </li>

                        {{-- Page Numbers --}}
                        @foreach(range(1, $barangs->lastPage()) as $page)
                            @if($page == $barangs->currentPage())
                                <li class="page-item active">
                                    <span class="page-link">{{ $page }}</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $barangs->url($page) }}">{{ $page }}</a>
                                </li>
                            @endif
                        @endforeach

                        {{-- Next Button --}}
                        <li class="page-item @if(!$barangs->hasMorePages()) disabled @endif">
                            <a class="page-link" href="{{ $barangs->nextPageUrl() }}" aria-label="Next">
                                <span aria-hidden="true">&rsaquo;</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
/* Background keseluruhan */
body {
    background-color: #E8F4F8 !important;
}

/* Custom Tabs dengan warna baru */
.custom-tabs {
    border-bottom: none;
}

.custom-tabs .nav-link {
    color: #757575;
    background-color: #F5F7FA;
    border: 1px solid #E0E0E0;
    font-weight: 500;
    border-radius: 8px 8px 0 0;
    padding: 15px;
    transition: all 0.3s ease;
}

.custom-tabs .nav-link.active {
    color: #FFFFFF;
    background: linear-gradient(135deg, #003D7A 0%, #0066B3 100%);
    border-color: #003D7A;
}

.custom-tabs .nav-link:hover:not(.active) {
    background-color: #E8F4F8;
    color: #0066B3;
}

/* Form controls dengan warna baru */
.form-control, .form-select {
    background-color: #F5F7FA;
    border: 1px solid #D0D0D0;
    color: #1A1A1A;
}

.form-control:focus, .form-select:focus {
    background-color: #FFFFFF;
    border-color: #0066B3;
    box-shadow: 0 0 0 0.2rem rgba(0, 102, 179, 0.15);
}

.form-control::placeholder {
    color: #BDBDBD;
}

/* Tombol Success (Export) */
.btn-success {
    background-color: #1FBD88;
    border-color: #1FBD88;
    color: #FFFFFF;
}

.btn-success:hover {
    background-color: #19a577;
    border-color: #19a577;
}

/* Tombol Danger (Tambah barang) */
.btn-danger {
    background-color: #E31E24;
    border-color: #E31E24;
    color: #FFFFFF;
}

.btn-danger:hover {
    background-color: #FF4444;
    border-color: #FF4444;
}

/* Card styling */
.card {
    background-color: #FFFFFF;
    border: 1px solid #E0E0E0;
    border-radius: 8px;
}

/* Table styling */
.stok-table {
    border-collapse: separate;
    border-spacing: 0;
}

.table-header-custom {
    background-color: #E8F4F8;
    border-bottom: 2px solid #D0D0D0;
}

.th-padding {
    padding: 12px 15px;
    font-weight: 600;
    font-size: 0.85rem;
    color: #003D7A;
}

.table-row-custom {
    border-bottom: 1px solid #E0E0E0;
    transition: background-color 0.2s ease;
}

.table-row-custom:hover {
    background-color: #F5F7FA;
}

.td-padding {
    padding: 15px;
    vertical-align: top;
}

.barang-title {
    color: #1A1A1A;
    font-size: 0.95rem;
}

/* Batch card styling */
.batch-card {
    margin-bottom: 8px;
    padding: 10px;
    border: 1px solid #E0E0E0;
    border-radius: 6px;
    background-color: #F5F7FA;
}

.batch-id {
    font-size: 0.9rem;
    color: #0066B3;
}

.batch-info {
    font-size: 0.8rem;
    color: #757575;
}

.batch-amount {
    font-size: 0.85rem;
    color: #1A1A1A;
}

/* Text colors */
.text-primary {
    color: #0066B3 !important;
}

.text-danger {
    color: #E31E24 !important;
}

.text-muted {
    color: #757575 !important;
}

/* Badge styling */
.badge-status {
    font-size: 0.75rem;
    padding: 0.4em 0.7em;
    font-weight: 500;
}

.badge-xs {
    font-size: 0.7rem;
    padding: 0.3em 0.6em;
}

.bg-warning {
    background-color: #F59E0B !important;
}

.bg-success {
    background-color: #1FBD88 !important;
}

.bg-danger {
    background-color: #E31E24 !important;
}

/* Action buttons */
.btn-action {
    padding: 6px 10px;
    font-size: 0.875rem;
    transition: all 0.2s ease;
}

.btn-action:hover {
    transform: scale(1.05);
}

.btn-outline-primary {
    color: #0066B3;
    border-color: #0066B3;
}

.btn-outline-primary:hover {
    background-color: #0066B3;
    border-color: #0066B3;
    color: #FFFFFF;
}

.btn-outline-danger {
    color: #E31E24;
    border-color: #E31E24;
}

.btn-outline-danger:hover {
    background-color: #E31E24;
    border-color: #E31E24;
    color: #FFFFFF;
}

/* Alert styling */
.alert-success {
    background-color: #E8F5E9;
    border-color: #1FBD88;
    color: #1A1A1A;
}

.alert-danger {
    background-color: #FFEBEE;
    border-color: #E31E24;
    color: #1A1A1A;
}

/* Custom Pagination Styling */
.pagination-custom {
    display: flex;
    gap: 4px;
}

.pagination-custom .page-item {
    margin: 0;
}

.pagination-custom .page-link {
    color: #757575;
    background-color: #FFFFFF;
    border: 1px solid #D0D0D0;
    padding: 10px 16px;
    border-radius: 6px;
    font-size: 0.9rem;
    font-weight: 500;
    transition: all 0.2s ease;
    min-width: 44px;
    text-align: center;
}

.pagination-custom .page-link:hover {
    color: #FFFFFF;
    background-color: #0066B3;
    border-color: #0066B3;
}

.pagination-custom .page-item.active .page-link {
    color: #FFFFFF;
    background-color: #0066B3;
    border-color: #0066B3;
    font-weight: 600;
    box-shadow: 0 2px 4px rgba(0, 102, 179, 0.3);
}

.pagination-custom .page-item.disabled .page-link {
    color: #BDBDBD;
    background-color: #F5F7FA;
    border-color: #E0E0E0;
    cursor: not-allowed;
}

.pagination-custom .page-item.disabled .page-link:hover {
    color: #BDBDBD;
    background-color: #F5F7FA;
    border-color: #E0E0E0;
}
</style>
@endpush
@endsection
