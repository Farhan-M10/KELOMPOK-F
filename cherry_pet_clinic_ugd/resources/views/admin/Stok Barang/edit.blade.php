{{-- File: resources/views/stok_barang/edit.blade.php --}}

@extends('layouts.app')

@section('content')
<div class="container-fluid" style="max-width: 900px;">
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-bottom">
            <h4 class="mb-0">Edit Barang: {{ $barang->nama_barang }}</h4>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('admin.barang.update', $barang->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Nama Barang --}}
                <div class="mb-4">
                    <label class="form-label fw-bold">Nama Barang <span class="text-danger">*</span></label>
                    <input type="text" name="nama_barang" 
                           class="form-control form-control-lg @error('nama_barang') is-invalid @enderror" 
                           value="{{ old('nama_barang', $barang->nama_barang) }}" 
                           required>
                    @error('nama_barang')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row mb-4">
                    {{-- Kategori --}}
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Kategori <span class="text-danger">*</span></label>
                        <select name="kategori_id" class="form-select form-select-lg @error('kategori_id') is-invalid @enderror" required>
                            <option value="">Semua Kategori</option>
                            @foreach($kategoris as $kategori)
                            <option value="{{ $kategori->id }}" {{ old('kategori_id', $barang->kategori_id) == $kategori->id ? 'selected' : '' }}>
                                {{ $kategori->nama_kategori }}
                            </option>
                            @endforeach
                        </select>
                        @error('kategori_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Jenis Barang --}}
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Jenis Barang <span class="text-danger">*</span></label>
                        <select name="jenis_barang_id" class="form-select form-select-lg @error('jenis_barang_id') is-invalid @enderror" required>
                            <option value="">Pilih Kategori</option>
                            @foreach($jenisBarangs as $jenis)
                            <option value="{{ $jenis->id }}" {{ old('jenis_barang_id', $barang->jenis_barang_id) == $jenis->id ? 'selected' : '' }}>
                                {{ $jenis->nama_jenis }}
                            </option>
                            @endforeach
                        </select>
                        @error('jenis_barang_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-4">
                    {{-- Lokasi Penyimpanan --}}
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Lokasi Penyimpanan <span class="text-danger">*</span></label>
                        <select name="lokasi" class="form-select form-select-lg @error('lokasi') is-invalid @enderror" required>
                            <option value="">Semua Lokasi</option>
                            <option value="Rak A" {{ old('lokasi', $barang->lokasi) == 'Rak A' ? 'selected' : '' }}>Rak A</option>
                            <option value="Rak B" {{ old('lokasi', $barang->lokasi) == 'Rak B' ? 'selected' : '' }}>Rak B</option>
                            <option value="Kulkas E" {{ old('lokasi', $barang->lokasi) == 'Kulkas E' ? 'selected' : '' }}>Kulkas E</option>
                            <option value="Kulkas V" {{ old('lokasi', $barang->lokasi) == 'Kulkas V' ? 'selected' : '' }}>Kulkas V</option>
                        </select>
                        @error('lokasi')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Ruangan --}}
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Ruangan <span class="text-danger">*</span></label>
                        <input type="text" name="ruangan" 
                               class="form-control form-control-lg @error('ruangan') is-invalid @enderror" 
                               value="{{ old('ruangan', $barang->ruangan) }}" 
                               required>
                        @error('ruangan')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-4">
                    {{-- Satuan --}}
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Satuan</label>
                        <select name="satuan" class="form-select form-select-lg @error('satuan') is-invalid @enderror">
                            <option value="box" {{ old('satuan', $barang->satuan) == 'box' ? 'selected' : '' }}>box</option>
                            <option value="vial" {{ old('satuan', $barang->satuan) == 'vial' ? 'selected' : '' }}>vial</option>
                            <option value="botol" {{ old('satuan', $barang->satuan) == 'botol' ? 'selected' : '' }}>botol</option>
                            <option value="unit" {{ old('satuan', $barang->satuan) == 'unit' ? 'selected' : '' }}>unit</option>
                            <option value="ampul" {{ old('satuan', $barang->satuan) == 'ampul' ? 'selected' : '' }}>ampul</option>
                            <option value="pcs" {{ old('satuan', $barang->satuan) == 'pcs' ? 'selected' : '' }}>pcs</option>
                        </select>
                        @error('satuan')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Stok Minimum --}}
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Stok Minimum</label>
                        <input type="number" name="stok_minimum" 
                               class="form-control form-control-lg @error('stok_minimum') is-invalid @enderror" 
                               value="{{ old('stok_minimum', $barang->stok_minimum) }}" 
                               min="0">
                        <small class="text-primary">Alert akan muncul jika stok di bawah nilai ini</small>
                        @error('stok_minimum')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Deskripsi Barang --}}
                <div class="mb-4">
                    <label class="form-label fw-bold">Deskripsi Barang</label>
                    <textarea name="deskripsi" 
                              class="form-control @error('deskripsi') is-invalid @enderror" 
                              rows="3" 
                              style="resize: none;">{{ old('deskripsi', $barang->deskripsi) }}</textarea>
                    @error('deskripsi')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <hr class="my-4">

                {{-- Data Batch --}}
                <h5 class="mb-3 fw-bold">Data Batch</h5>
                <div class="table-responsive mb-4">
                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>Nomor Batch</th>
                                <th>Tanggal Masuk</th>
                                <th>Kadaluarsa</th>
                                <th>Jumlah</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($barang->batchBarangs as $batch)
                            <tr>
                                <td><strong class="text-primary">{{ $batch->nomor_batch }}</strong></td>
                                <td>{{ $batch->tanggal_masuk->format('d M Y') }}</td>
                                <td>{{ $batch->tanggal_kadaluarsa->format('d M Y') }}</td>
                                <td>{{ $batch->jumlah }} {{ $barang->satuan }}</td>
                                <td>
                                    <span class="badge bg-{{ $batch->getBadgeClass() }}">
                                        {{ $batch->status }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">Belum ada batch</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <hr class="my-4">

                {{-- Action Buttons --}}
                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.barang.index') }}" class="btn btn-lg btn-light px-4">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                    <button type="submit" class="btn btn-lg btn-primary px-4">
                        <i class="fas fa-save"></i> Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('styles')
<style>
    .form-control, .form-select {
        border: 1px solid #dee2e6;
        padding: 0.625rem 0.875rem;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.1);
    }
    
    .form-label {
        margin-bottom: 0.5rem;
        font-size: 0.9rem;
        color: #212529;
    }
    
    .badge {
        font-size: 0.75rem;
        padding: 0.35em 0.65em;
    }
</style>
@endpush
@endsection