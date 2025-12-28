@extends('staff.layouts.app')

@section('title', 'Detail Laporan')
@section('page-title', 'Laporan > Detail')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <a href="{{ route('staff.laporan.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i> Kembali
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-info-circle me-2"></i>
                        Detail Pengurangan Stok
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-4 fw-semibold">Nama Barang:</div>
                        <div class="col-md-8">{{ $pengurangan->batchBarang->barang->nama_barang }}</div>
                    </div>
                    <hr>

                    <div class="row mb-3">
                        <div class="col-md-4 fw-semibold">Kode Barang:</div>
                        <div class="col-md-8">
                            <span class="badge bg-secondary">{{ $pengurangan->batchBarang->barang->kode_barang ?? '-' }}</span>
                        </div>
                    </div>
                    <hr>

                    <div class="row mb-3">
                        <div class="col-md-4 fw-semibold">Nomor Batch:</div>
                        <div class="col-md-8">
                            <span class="text-primary fw-semibold">{{ $pengurangan->batchBarang->nomor_batch }}</span>
                        </div>
                    </div>
                    <hr>

                    <div class="row mb-3">
                        <div class="col-md-4 fw-semibold">Jumlah Dikurangi:</div>
                        <div class="col-md-8">
                            <span class="badge bg-danger fs-6">-{{ $pengurangan->jumlah_pengurangan }} {{ $pengurangan->batchBarang->barang->satuan }}</span>
                        </div>
                    </div>
                    <hr>

                    <div class="row mb-3">
                        <div class="col-md-4 fw-semibold">Tanggal & Waktu:</div>
                        <div class="col-md-8">{{ $pengurangan->tanggal_pengurangan->format('d M Y, H:i') }} WIB</div>
                    </div>
                    <hr>

                    <div class="row mb-3">
                        <div class="col-md-4 fw-semibold">Kategori:</div>
                        <div class="col-md-8">
                            <span class="badge bg-info">{{ $pengurangan->batchBarang->barang->kategori->nama_kategori }}</span>
                        </div>
                    </div>
                    <hr>

                    <div class="row mb-3">
                        <div class="col-md-4 fw-semibold">Jenis Pengurangan:</div>
                        <div class="col-md-8">
                            @if($pengurangan->alasan == 'Digunakan untuk pemeriksaan pasien')
                                <span class="badge bg-info">Penjualan</span>
                            @elseif($pengurangan->alasan == 'Digunakan untuk operasi' || $pengurangan->alasan == 'Digunakan untuk perawatan rawat inap')
                                <span class="badge bg-success">Digunakan Internal</span>
                            @elseif($pengurangan->alasan == 'Rusak/Kadaluarsa')
                                <span class="badge bg-warning text-dark">Rusak / Expired</span>
                            @elseif($pengurangan->alasan == 'Hilang')
                                <span class="badge bg-danger">Hilang</span>
                            @else
                                <span class="badge bg-secondary">{{ $pengurangan->alasan }}</span>
                            @endif
                        </div>
                    </div>
                    <hr>

                    <div class="row mb-3">
                        <div class="col-md-4 fw-semibold">Lokasi Penyimpanan:</div>
                        <div class="col-md-8">
                            {{ $pengurangan->batchBarang->barang->lokasi }}
                            <small class="text-muted d-block">{{ $pengurangan->batchBarang->barang->ruangan ?? '-' }}</small>
                        </div>
                    </div>
                    <hr>

                    <div class="row mb-3">
                        <div class="col-md-4 fw-semibold">Dicatat Oleh:</div>
                        <div class="col-md-8">
                            <strong>{{ $pengurangan->user->name }}</strong>
                        </div>
                    </div>
                    <hr>

                    <div class="row">
                        <div class="col-md-4 fw-semibold">Deskripsi:</div>
                        <div class="col-md-8">
                            <div class="alert alert-light">
                                <strong>Alasan:</strong> {{ $pengurangan->alasan }}
                                @if($pengurangan->keterangan)
                                    <hr>
                                    <strong>Keterangan Tambahan:</strong><br>
                                    {{ $pengurangan->keterangan }}
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light">
                    <h6 class="mb-0">Informasi Batch</h6>
                </div>
                <div class="card-body">
                    <p class="mb-2">
                        <strong>Tanggal Masuk:</strong><br>
                        {{ $pengurangan->batchBarang->tanggal_masuk->format('d M Y') }}
                    </p>
                    <p class="mb-2">
                        <strong>Tanggal Kadaluarsa:</strong><br>
                        {{ $pengurangan->batchBarang->tanggal_kadaluarsa->format('d M Y') }}
                    </p>
                    <p class="mb-0">
                        <strong>Stok Tersisa Saat Ini:</strong><br>
                        <span class="badge bg-info">{{ $pengurangan->batchBarang->jumlah }} {{ $pengurangan->batchBarang->barang->satuan }}</span>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    border-radius: 12px;
}

.card-header {
    border-radius: 12px 12px 0 0;
}

hr {
    margin: 1rem 0;
    border-color: #e9ecef;
}
</style>
@endsection
