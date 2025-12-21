@extends('admin.layouts.app')

@section('content')
<div class="container-fluid px-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Beranda</a></li>
            <li class="breadcrumb-item active" aria-current="page">Pengadaan Stok</li>
        </ol>
    </nav>

    <h4 class="mb-4">Pengadaan Stok</h4>

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

    <!-- Filter & Search -->
    <div class="card mb-3">
        <div class="card-body">
            <form method="GET" action="{{ route('pengadaan.index') }}" class="row g-3">
                <div class="col-md-5">
                    <input type="text" name="search" class="form-control" placeholder="Cari berdasarkan ID atau Supplier" value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <select name="status" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="Disetujui" {{ request('status') == 'Disetujui' ? 'selected' : '' }}>Disetujui</option>
                        <option value="Menunggu" {{ request('status') == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                        <option value="Ditolak" {{ request('status') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search"></i> Cari
                    </button>
                </div>
                <div class="col-md-2">
                    <a href="{{ route('pengadaan.create') }}" class="btn btn-danger w-100">
                        <i class="fas fa-plus"></i> Tambah
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Table -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>ID PENGADAAN</th>
                            <th>TANGGAL</th>
                            <th>PEMASOK</th>
                            <th>TOTAL BIAYA</th>
                            <th>STATUS</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pengadaanStok as $item)
                        <tr>
                            <td>{{ $item->id_pengadaan }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</td>
                            <td>{{ $item->supplier->nama_supplier ?? 'N/A' }}</td>
                            <td>Rp {{ number_format($item->total_harga, 0, ',', '.') }}</td>
                            <td>
                                @if($item->status == 'Disetujui')
                                    <span class="badge bg-success">Disetujui</span>
                                @elseif($item->status == 'Menunggu')
                                    <span class="badge bg-warning text-dark">Menunggu</span>
                                @else
                                    <span class="badge bg-danger">Ditolak</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('pengadaan.show', $item->id) }}" class="btn btn-sm btn-outline-primary" title="Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @if($item->status == 'Menunggu')
                                <a href="{{ route('pengadaan.edit', $item->id) }}" class="btn btn-sm btn-outline-warning" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('pengadaan.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">Tidak ada data</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-3">
                <div>
                    Menampilkan {{ $pengadaanStok->firstItem() ?? 0 }} - {{ $pengadaanStok->lastItem() ?? 0 }} dari {{ $pengadaanStok->total() }} item
                </div>
                <div>
                    {{ $pengadaanStok->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection