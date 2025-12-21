@extends('admin.layouts.app')

@section('content')
<div class="container-fluid px-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Beranda</a></li>
            <li class="breadcrumb-item"><a href="{{ route('pengadaan.index') }}">Pengadaan Stok</a></li>
            <li class="breadcrumb-item active" aria-current="page">Detail Pengadaan Stok</li>
        </ol>
    </nav>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4>Detail Pengadaan Stok</h4>
        <a href="{{ route('pengadaan.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

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

    <div class="card">
        <div class="card-body">
            <h5 class="mb-4">Informasi Pengadaan</h5>

            <!-- Info Header -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <label class="text-muted small">ID Pengadaan</label>
                    <div class="fw-bold">{{ $pengadaan->id_pengadaan }}</div>
                </div>
                <div class="col-md-3">
                    <label class="text-muted small">Tanggal Pengadaan</label>
                    <div class="fw-bold">{{ \Carbon\Carbon::parse($pengadaan->tanggal)->format('d/m/Y') }}</div>
                </div>
                <div class="col-md-3">
                    <label class="text-muted small">Nama Supplier</label>
                    <div class="fw-bold">{{ $pengadaan->supplier->nama_supplier ?? 'N/A' }}</div>
                </div>
                <div class="col-md-3">
                    <label class="text-muted small">Status</label>
                    <div>
                        @if($pengadaan->status == 'Disetujui')
                            <span class="badge bg-success fs-6">Disetujui</span>
                        @elseif($pengadaan->status == 'Menunggu')
                            <span class="badge bg-warning text-dark fs-6">Menunggu</span>
                        @else
                            <span class="badge bg-danger fs-6">Ditolak</span>
                        @endif
                    </div>
                </div>
            </div>

            @if($pengadaan->catatan)
            <div class="row mb-4">
                <div class="col-md-12">
                    <label class="text-muted small">Catatan</label>
                    <div class="fw-normal">{{ $pengadaan->catatan }}</div>
                </div>
            </div>
            @endif

            <hr>

            <h5 class="mb-3">Daftar Barang</h5>

            <!-- Detail Items Table -->
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th width="5%">No</th>
                            <th width="40%">Nama Barang</th>
                            <th width="10%">Satuan</th>
                            <th width="15%" class="text-center">Jumlah Pesanan</th>
                            <th width="15%" class="text-end">Harga Satuan</th>
                            <th width="15%" class="text-end">SubTotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pengadaan->details as $index => $detail)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ $detail->barang->nama_barang ?? 'N/A' }}</td>
                            <td>{{ $detail->barang->satuan ?? '-' }}</td>
                            <td class="text-center">{{ number_format($detail->jumlah_pesan, 0, ',', '.') }}</td>
                            <td class="text-end">Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}</td>
                            <td class="text-end fw-bold">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">Tidak ada detail barang</td>
                        </tr>
                        @endforelse
                    </tbody>
                    <tfoot class="table-light">
                        <tr>
                            <td colspan="5" class="text-end fw-bold">Total Harga:</td>
                            <td class="text-end fw-bold text-primary fs-5">
                                Rp {{ number_format($pengadaan->total_harga, 0, ',', '.') }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <!-- Action Buttons -->
            <div class="d-flex justify-content-between align-items-center mt-4">
                <div>
                    @if($pengadaan->status == 'Menunggu')
                        <a href="{{ route('pengadaan.edit', $pengadaan->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit Pengadaan
                        </a>
                        <form action="{{ route('pengadaan.destroy', $pengadaan->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengadaan ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </form>
                    @endif
                </div>

                @if($pengadaan->status == 'Menunggu')
                <div class="d-flex gap-2">
                    <form method="POST" action="{{ route('pengadaan.updateStatus', $pengadaan->id) }}" class="d-inline">
                        @csrf
                        <input type="hidden" name="status" value="Ditolak">
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menolak pengadaan ini?')">
                            <i class="fas fa-times"></i> Tolak Pengadaan
                        </button>
                    </form>
                    <form method="POST" action="{{ route('pengadaan.updateStatus', $pengadaan->id) }}" class="d-inline">
                        @csrf
                        <input type="hidden" name="status" value="Disetujui">
                        <button type="submit" class="btn btn-success" onclick="return confirm('Apakah Anda yakin ingin menyetujui pengadaan ini?')">
                            <i class="fas fa-check"></i> Setujui Pengadaan
                        </button>
                    </form>
                </div>
                @endif
            </div>

            @if($pengadaan->status == 'Disetujui')
            <div class="alert alert-success mt-3" role="alert">
                <i class="fas fa-check-circle"></i> Pengadaan ini telah disetujui dan tidak dapat diubah.
            </div>
            @elseif($pengadaan->status == 'Ditolak')
            <div class="alert alert-danger mt-3" role="alert">
                <i class="fas fa-times-circle"></i> Pengadaan ini telah ditolak.
            </div>
            @endif
        </div>
    </div>

    <!-- Timeline Card (Optional) -->
    <div class="card mt-3">
        <div class="card-body">
            <h5 class="mb-3">Riwayat</h5>
            <ul class="list-unstyled">
                <li class="mb-2">
                    <i class="fas fa-circle text-primary me-2" style="font-size: 8px;"></i>
                    <strong>Dibuat:</strong> {{ $pengadaan->created_at->format('d M Y, H:i') }} WIB
                </li>
                @if($pengadaan->updated_at != $pengadaan->created_at)
                <li class="mb-2">
                    <i class="fas fa-circle text-warning me-2" style="font-size: 8px;"></i>
                    <strong>Terakhir diupdate:</strong> {{ $pengadaan->updated_at->format('d M Y, H:i') }} WIB
                </li>
                @endif
            </ul>
        </div>
    </div>
</div>
@endsection