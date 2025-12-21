{{-- File: resources/views/stok_barang/create.blade.php --}}

@extends('admin.layouts.app')

@section('content')
<div class="container-fluid" style="background-color: #E8F4F8; min-height: 100vh; padding: 2rem 0;">
    <div style="max-width: 900px; margin: 0 auto;">

        <!-- Back Button -->
        <div class="mb-4">
            <a href="{{ route('admin.stok_barang.index') }}" class="btn btn-link text-decoration-none p-0 text-primary-custom">
                <i class="fas fa-arrow-left me-2"></i> Kembali
            </a>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <!-- Header -->
                <div class="mb-4">
                    <h4 class="fw-bold text-dark mb-1">Tambah Barang Baru</h4>
                    <p class="text-secondary small mb-0">Lengkapi form di bawah untuk menambahkan barang baru ke stok</p>
                </div>

                <form action="{{ route('admin.stok_barang.store') }}" method="POST" id="formBarang">
                    @csrf

                    {{-- Nama Barang --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold text-dark">
                            Nama Barang <span class="text-danger-custom">*</span>
                        </label>
                        <input type="text" name="nama_barang"
                               class="form-control form-control-lg border-custom @error('nama_barang') is-invalid @enderror"
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
                            <label class="form-label fw-semibold text-dark">
                                Kategori <span class="text-danger-custom">*</span>
                            </label>
                            <select name="kategori_id" class="form-select form-select-lg border-custom @error('kategori_id') is-invalid @enderror" required>
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
                            <label class="form-label fw-semibold text-dark">
                                Jenis Barang <span class="text-danger-custom">*</span>
                            </label>
                            <select name="jenis_barang_id" class="form-select form-select-lg border-custom @error('jenis_barang_id') is-invalid @enderror" required>
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
                            <label class="form-label fw-semibold text-dark">
                                Lokasi Penyimpanan <span class="text-danger-custom">*</span>
                            </label>
                            <select name="lokasi" class="form-select form-select-lg border-custom @error('lokasi') is-invalid @enderror" required>
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
                            <label class="form-label fw-semibold text-dark">
                                Ruangan <span class="text-danger-custom">*</span>
                            </label>
                            <input type="text" name="ruangan"
                                   class="form-control form-control-lg border-custom @error('ruangan') is-invalid @enderror"
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
                            <label class="form-label fw-semibold text-dark">Satuan</label>
                            <select name="satuan" class="form-select form-select-lg border-custom @error('satuan') is-invalid @enderror">
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
                            <label class="form-label fw-semibold text-dark">Stok Minimum</label>
                            <input type="number" name="stok_minimum"
                                   class="form-control form-control-lg border-custom @error('stok_minimum') is-invalid @enderror"
                                   value="{{ old('stok_minimum', 10) }}"
                                   placeholder="10"
                                   min="0">
                            <small class="text-primary-custom">
                                <i class="fas fa-info-circle me-1"></i>
                                Alert akan muncul jika stok di bawah nilai ini
                            </small>
                            @error('stok_minimum')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Deskripsi Barang --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold text-dark">Deskripsi Barang</label>
                        <textarea name="deskripsi"
                                  class="form-control border-custom @error('deskripsi') is-invalid @enderror"
                                  rows="3"
                                  style="resize: none;"
                                  placeholder="Masukan deskripsi, kegunaan, cara penggunaan, atau informasi yang relevan...">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <hr class="my-4 border-light-custom">

                    {{-- Data Batch Section --}}
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0 fw-bold text-dark">Data Batch</h5>
                        <button type="button" class="btn btn-link text-decoration-none text-primary-custom" id="btnTambahBatch">
                            <i class="fas fa-plus-circle me-1"></i> Tambah barang
                        </button>
                    </div>

                    <div id="batchContainer">
                        {{-- Batch Item Template --}}
                        <div class="batch-item mb-3 p-3 bg-light-batch rounded position-relative">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="mb-0 text-primary-custom fw-bold">Batch #1</h6>
                                <button type="button" class="btn btn-sm btn-hapus-batch border-0" style="display: none;">
                                    <i class="fas fa-trash me-1"></i> Hapus
                                </button>
                            </div>

                            <div class="row mb-3">
                                {{-- Nomor Batch --}}
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold text-dark">
                                        Nomor Batch <span class="text-danger-custom">*</span>
                                    </label>
                                    <input type="text" name="batches[0][nomor_batch]"
                                           class="form-control border-custom"
                                           placeholder="B-240915"
                                           required>
                                </div>

                                {{-- Jumlah --}}
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold text-dark">
                                        Jumlah <span class="text-danger-custom">*</span>
                                    </label>
                                    <input type="number" name="batches[0][jumlah]"
                                           class="form-control border-custom"
                                           placeholder="15"
                                           min="1"
                                           required>
                                </div>
                            </div>

                            <div class="row">
                                {{-- Tanggal Masuk --}}
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold text-dark">
                                        Tanggal Masuk <span class="text-danger-custom">*</span>
                                    </label>
                                    <input type="date" name="batches[0][tanggal_masuk]"
                                           class="form-control border-custom"
                                           required>
                                </div>

                                {{-- Tanggal Kadaluarsa --}}
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold text-dark">
                                        Tanggal Kadaluarsa <span class="text-danger-custom">*</span>
                                    </label>
                                    <input type="date" name="batches[0][tanggal_kadaluarsa]"
                                           class="form-control border-custom"
                                           required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4 border-light-custom">

                    {{-- Action Buttons --}}
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.stok_barang.index') }}" class="btn btn-lg btn-secondary-custom px-4">
                            <i class="fas fa-times me-2"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-lg btn-danger-custom px-4">
                            <i class="fas fa-save me-2"></i> Tambah barang
                        </button>
                    </div>
                </form>
            </div>
        </div>
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
    }

    /* Body Background */
    body {
        background-color: var(--bg-very-light) !important;
    }

    /* Text Colors */
    .text-dark {
        color: var(--text-dark) !important;
    }

    .text-secondary {
        color: var(--text-secondary) !important;
    }

    .text-primary-custom {
        color: var(--primary-medium) !important;
    }

    .text-danger-custom {
        color: var(--error-color) !important;
    }

    /* Border Colors */
    .border-custom {
        border-color: var(--border-normal) !important;
    }

    .border-light-custom {
        border-color: var(--border-light) !important;
    }

    /* Form Controls */
    .form-control, .form-select {
        background-color: var(--bg-light);
        border: 1px solid var(--border-normal);
        padding: 0.625rem 0.875rem;
        color: var(--text-dark);
        transition: all 0.2s ease;
    }

    .form-control:focus, .form-select:focus {
        background-color: white;
        border-color: var(--primary-medium);
        box-shadow: 0 0 0 0.25rem rgba(0, 102, 179, 0.15);
    }

    .form-control::placeholder {
        color: var(--text-light);
    }

    /* Form Label */
    .form-label {
        margin-bottom: 0.5rem;
        font-size: 0.9rem;
        color: var(--text-dark);
        font-weight: 600;
    }

    /* Invalid Feedback */
    .invalid-feedback {
        display: block;
        color: var(--error-color);
    }

    .is-invalid {
        border-color: var(--error-color) !important;
    }

    .is-invalid:focus {
        box-shadow: 0 0 0 0.25rem rgba(227, 30, 36, 0.15) !important;
    }

    /* Batch Item */
    .bg-light-batch {
        background-color: var(--bg-light) !important;
    }

    .batch-item {
        border: 1px solid var(--border-light);
        transition: all 0.2s;
    }

    .batch-item:hover {
        border-color: var(--border-normal);
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    .btn-hapus-batch {
        background-color: var(--error-color);
        color: white;
        font-size: 0.875rem;
        padding: 0.375rem 0.75rem;
        transition: all 0.2s ease;
    }

    .btn-hapus-batch:hover {
        background-color: var(--error-hover);
        transform: translateY(-1px);
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

    .btn-secondary-custom {
        background-color: var(--text-medium);
        border-color: var(--text-medium);
        color: white;
    }

    .btn-secondary-custom:hover {
        background-color: var(--text-secondary);
        border-color: var(--text-secondary);
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

    .btn-link {
        font-weight: 500;
    }

    .btn-link:hover {
        text-decoration: underline !important;
    }

    /* Card */
    .card {
        background-color: white;
    }

    /* Date Input */
    input[type="date"]::-webkit-calendar-picker-indicator {
        cursor: pointer;
    }

    /* Small Text */
    small {
        font-size: 0.875rem;
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
