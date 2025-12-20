{{-- File: resources/views/stok_barang/create.blade.php --}}

@extends('layouts.app')

@section('content')
<div class="container-fluid" style="max-width: 900px;">
    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <form action="{{ route('admin.barang.store') }}" method="POST" id="formBarang">
                @csrf

                {{-- Nama Barang --}}
                <div class="mb-4">
                    <label class="form-label fw-bold">Nama Barang <span class="text-danger">*</span></label>
                    <input type="text" name="nama_barang" 
                           class="form-control form-control-lg @error('nama_barang') is-invalid @enderror" 
                           value="{{ old('nama_barang') }}" 
                           placeholder="Amoxicillin 500mg"
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
                            <option value="{{ $kategori->id }}" {{ old('kategori_id') == $kategori->id ? 'selected' : '' }}>
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
                            <option value="{{ $jenis->id }}" {{ old('jenis_barang_id') == $jenis->id ? 'selected' : '' }}>
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
                            <option value="Rak A" {{ old('lokasi') == 'Rak A' ? 'selected' : '' }}>Rak A</option>
                            <option value="Rak B" {{ old('lokasi') == 'Rak B' ? 'selected' : '' }}>Rak B</option>
                            <option value="Kulkas E" {{ old('lokasi') == 'Kulkas E' ? 'selected' : '' }}>Kulkas E</option>
                            <option value="Kulkas V" {{ old('lokasi') == 'Kulkas V' ? 'selected' : '' }}>Kulkas V</option>
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
                               value="{{ old('ruangan') }}" 
                               placeholder="Ruang Display Lt. 1"
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
                            <option value="box" {{ old('satuan') == 'box' ? 'selected' : '' }}>box</option>
                            <option value="vial" {{ old('satuan') == 'vial' ? 'selected' : '' }}>vial</option>
                            <option value="botol" {{ old('satuan') == 'botol' ? 'selected' : '' }}>botol</option>
                            <option value="unit" {{ old('satuan') == 'unit' ? 'selected' : '' }}>unit</option>
                            <option value="ampul" {{ old('satuan') == 'ampul' ? 'selected' : '' }}>ampul</option>
                            <option value="pcs" {{ old('satuan') == 'pcs' ? 'selected' : '' }}>pcs</option>
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
                               value="{{ old('stok_minimum', 10) }}" 
                               placeholder="10"
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
                              style="resize: none;"
                              placeholder="Masukan deskripsi, kegunaan, cara penggunaan, atau informasi yang relevan...">{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <hr class="my-4">

                {{-- Data Batch Section --}}
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0 fw-bold">Data Batch</h5>
                    <button type="button" class="btn btn-link text-decoration-none" id="btnTambahBatch">
                        <i class="fas fa-plus-circle me-1"></i> Tambah barang
                    </button>
                </div>

                <div id="batchContainer">
                    {{-- Batch Item Template --}}
                    <div class="batch-item mb-3 p-3 bg-light rounded position-relative">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="mb-0 text-primary fw-bold">Batch #1</h6>
                            <button type="button" class="btn btn-sm btn-light text-danger btn-hapus-batch border-0" style="display: none;">
                                Hapus
                            </button>
                        </div>

                        <div class="row mb-3">
                            {{-- Nomor Batch --}}
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Nomor Batch <span class="text-danger">*</span></label>
                                <input type="text" name="batches[0][nomor_batch]" 
                                       class="form-control" 
                                       placeholder="B-240915"
                                       required>
                            </div>

                            {{-- Jumlah --}}
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Jumlah <span class="text-danger">*</span></label>
                                <input type="number" name="batches[0][jumlah]" 
                                       class="form-control" 
                                       placeholder="15"
                                       min="1"
                                       required>
                            </div>
                        </div>

                        <div class="row">
                            {{-- Tanggal Masuk --}}
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Tanggal Masuk <span class="text-danger">*</span></label>
                                <input type="date" name="batches[0][tanggal_masuk]" 
                                       class="form-control" 
                                       required>
                            </div>

                            {{-- Tanggal Kadaluarsa --}}
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Tanggal Kadaluarsa <span class="text-danger">*</span></label>
                                <input type="date" name="batches[0][tanggal_kadaluarsa]" 
                                       class="form-control" 
                                       required>
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                {{-- Action Buttons --}}
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.barang.index') }}" class="btn btn-lg btn-light px-4">
                        Batal
                    </a>
                    <button type="submit" class="btn btn-lg btn-primary px-4">
                        Tambah barang
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
    
    .batch-item {
        border: 1px solid #e9ecef;
        transition: all 0.2s;
    }
    
    .batch-item:hover {
        border-color: #dee2e6;
    }
    
    .btn-hapus-batch {
        background-color: #ffe5e5;
        color: #dc3545;
        font-size: 0.875rem;
        padding: 0.375rem 0.75rem;
    }
    
    .btn-hapus-batch:hover {
        background-color: #ffcccc;
    }
    
    input[type="date"]::-webkit-calendar-picker-indicator {
        cursor: pointer;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    let batchCount = 1;
    const btnTambahBatch = document.getElementById('btnTambahBatch');
    const batchContainer = document.getElementById('batchContainer');

    // Tambah Batch Baru
    btnTambahBatch.addEventListener('click', function() {
        const newBatch = document.querySelector('.batch-item').cloneNode(true);
        
        // Update batch number
        newBatch.querySelector('h6').textContent = `Batch #${batchCount + 1}`;
        
        // Update input names dan clear values
        const inputs = newBatch.querySelectorAll('input');
        inputs.forEach(input => {
            const name = input.getAttribute('name');
            input.setAttribute('name', name.replace(/\[\d+\]/, `[${batchCount}]`));
            input.value = '';
        });

        // Show hapus button
        const hapusBtn = newBatch.querySelector('.btn-hapus-batch');
        hapusBtn.style.display = 'inline-block';
        
        batchContainer.appendChild(newBatch);
        batchCount++;

        updateHapusButtons();
    });

    // Hapus Batch
    batchContainer.addEventListener('click', function(e) {
        if (e.target.classList.contains('btn-hapus-batch') || e.target.closest('.btn-hapus-batch')) {
            const batchItem = e.target.closest('.batch-item');
            const allBatches = document.querySelectorAll('.batch-item');
            
            if (allBatches.length > 1) {
                batchItem.remove();
                updateBatchNumbers();
                updateHapusButtons();
            } else {
                alert('Minimal harus ada 1 batch!');
            }
        }
    });

    function updateBatchNumbers() {
        const batches = document.querySelectorAll('.batch-item');
        batches.forEach((batch, index) => {
            batch.querySelector('h6').textContent = `Batch #${index + 1}`;
            
            const inputs = batch.querySelectorAll('input');
            inputs.forEach(input => {
                const name = input.getAttribute('name');
                input.setAttribute('name', name.replace(/\[\d+\]/, `[${index}]`));
            });
        });
        batchCount = batches.length;
    }

    function updateHapusButtons() {
        const batches = document.querySelectorAll('.batch-item');
        batches.forEach((batch, index) => {
            const hapusBtn = batch.querySelector('.btn-hapus-batch');
            if (batches.length > 1) {
                hapusBtn.style.display = 'inline-block';
            } else {
                hapusBtn.style.display = 'none';
            }
        });
    }

    // Format tanggal saat input
    document.addEventListener('change', function(e) {
        if (e.target.type === 'date') {
            const tanggalMasuk = e.target.closest('.batch-item').querySelector('input[name*="[tanggal_masuk]"]');
            const tanggalKadaluarsa = e.target.closest('.batch-item').querySelector('input[name*="[tanggal_kadaluarsa]"]');
            
            if (tanggalMasuk && tanggalKadaluarsa && tanggalMasuk.value && tanggalKadaluarsa.value) {
                if (new Date(tanggalKadaluarsa.value) <= new Date(tanggalMasuk.value)) {
                    alert('Tanggal kadaluarsa harus lebih besar dari tanggal masuk!');
                    tanggalKadaluarsa.value = '';
                }
            }
        }
    });
});
</script>
@endpush
@endsection