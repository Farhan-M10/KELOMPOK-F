{{-- File: resources/views/stok_barang/index.blade.php --}}

@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
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
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="fas fa-search"></i>
                        </button>
                        <a href="{{ route('admin.stok_barang.index', ['jenis_tab' => request('jenis_tab', 'medis')]) }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-redo"></i>
                        </a>
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

    <div class="mt-3 d-flex justify-content-between align-items-center">
        <small class="text-muted">Menampilkan {{ $barangs->firstItem() ?? 0 }}-{{ $barangs->lastItem() ?? 0 }} dari {{ $barangs->total() }} item</small>
        {{ $barangs->appends(request()->query())->links() }}
    </div>
</div>

@push('styles')
<style>
.custom-tabs {
    border-bottom: none;
}

.custom-tabs .nav-link {
    color: #6c757d;
    background-color: #f8f9fa;
    border: 1px solid #dee2e6;
    font-weight: 500;
    border-radius: 8px 8px 0 0;
    padding: 15px;
}

.custom-tabs .nav-link.active {
    color: #ffffff;
    background-color: #0d6efd;
    border-color: #0d6efd;
}

.custom-tabs .nav-link:hover:not(.active) {
    background-color: #e9ecef;
}

.stok-table {
    border-collapse: separate;
    border-spacing: 0;
}

.table-header-custom {
    background-color: #e8f4f8;
    border-bottom: 2px solid #dee2e6;
}

.th-padding {
    padding: 12px 15px;
    font-weight: 600;
    font-size: 0.85rem;
}

.table-row-custom {
    border-bottom: 1px solid #e9ecef;
}

.td-padding {
    padding: 15px;
    vertical-align: top;
}

.barang-title {
    color: #212529;
    font-size: 0.95rem;
}

.batch-card {
    margin-bottom: 8px;
    padding: 10px;
    border: 1px solid #dee2e6;
    border-radius: 6px;
    background-color: #f8f9fa;
}

.batch-id {
    font-size: 0.9rem;
}

.batch-info {
    font-size: 0.8rem;
}

.batch-amount {
    font-size: 0.85rem;
}

.badge-status {
    font-size: 0.75rem;
    padding: 0.4em 0.7em;
    font-weight: 500;
}

.badge-xs {
    font-size: 0.7rem;
    padding: 0.3em 0.6em;
}

.btn-action {
    padding: 6px 10px;
    font-size: 0.875rem;
}

.btn-action:hover {
    transform: scale(1.05);
    transition: all 0.2s;
}
</style>
@endpush
@endsection

