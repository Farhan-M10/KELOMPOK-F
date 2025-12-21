{{-- File: resources/views/stok_barang/edit.blade.php --}}

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
            <div class="card-header bg-white border-bottom border-light-custom">
                <div>
                    <h4 class="mb-1 fw-bold text-dark">Edit Barang</h4>
                    <p class="text-secondary small mb-0">{{ $barang->nama_barang }}</p>
                </div>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('admin.stok_barang.update', $barang->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- Nama Barang --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold text-dark">
                            Nama Barang <span class="text-danger-custom">*</span>
                        </label>
                        <input type="text" name="nama_barang"
                               class="form-control form-control-lg border-custom @error('nama_barang') is-invalid @enderror"
                               value="{{ old('nama_barang', $barang->nama_barang) }}"
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
                            <label class="form-label fw-semibold text-dark">
                                Jenis Barang <span class="text-danger-custom">*</span>
                            </label>
                            <select name="jenis_barang_id" class="form-select form-select-lg border-custom @error('jenis_barang_id') is-invalid @enderror" required>
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
                            <label class="form-label fw-semibold text-dark">
                                Lokasi Penyimpanan <span class="text-danger-custom">*</span>
                            </label>
                            <select name="lokasi" class="form-select form-select-lg border-custom @error('lokasi') is-invalid @enderror" required>
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
                            <label class="form-label fw-semibold text-dark">
                                Ruangan <span class="text-danger-custom">*</span>
                            </label>
                            <input type="text" name="ruangan"
                                   class="form-control form-control-lg border-custom @error('ruangan') is-invalid @enderror"
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
                            <label class="form-label fw-semibold text-dark">Satuan</label>
                            <select name="satuan" class="form-select form-select-lg border-custom @error('satuan') is-invalid @enderror">
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
                            <label class="form-label fw-semibold text-dark">Stok Minimum</label>
                            <input type="number" name="stok_minimum"
                                   class="form-control form-control-lg border-custom @error('stok_minimum') is-invalid @enderror"
                                   value="{{ old('stok_minimum', $barang->stok_minimum) }}"
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
                                  style="resize: none;">{{ old('deskripsi', $barang->deskripsi) }}</textarea>
                        @error('deskripsi')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <hr class="my-4 border-light-custom">

                    {{-- Data Batch --}}
                    <h5 class="mb-3 fw-bold text-dark">Data Batch</h5>
                    <div class="table-responsive mb-4">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-header-custom">
                                <tr>
                                    <th class="px-3 py-3 text-uppercase small fw-semibold">Nomor Batch</th>
                                    <th class="px-3 py-3 text-uppercase small fw-semibold">Tanggal Masuk</th>
                                    <th class="px-3 py-3 text-uppercase small fw-semibold">Kadaluarsa</th>
                                    <th class="px-3 py-3 text-uppercase small fw-semibold">Jumlah</th>
                                    <th class="px-3 py-3 text-uppercase small fw-semibold">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($barang->batchBarangs as $batch)
                                <tr class="table-row-custom">
                                    <td class="px-3 py-3">
                                        <code class="code-badge">{{ $batch->nomor_batch }}</code>
                                    </td>
                                    <td class="px-3 py-3">
                                        <span class="text-dark">{{ $batch->tanggal_masuk->format('d M Y') }}</span>
                                    </td>
                                    <td class="px-3 py-3">
                                        <span class="text-dark">{{ $batch->tanggal_kadaluarsa->format('d M Y') }}</span>
                                    </td>
                                    <td class="px-3 py-3">
                                        <span class="fw-medium text-dark">{{ $batch->jumlah }} {{ $barang->satuan }}</span>
                                    </td>
                                    <td class="px-3 py-3">
                                        @php
                                            $badgeClass = $batch->getBadgeClass();
                                            $customBadge = match($badgeClass) {
                                                'success' => 'badge-success-custom',
                                                'warning' => 'badge-warning-custom',
                                                'danger' => 'badge-danger-custom',
                                                default => 'badge-secondary-custom'
                                            };
                                        @endphp
                                        <span class="badge {{ $customBadge }} rounded-pill">
                                            {{ $batch->status }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5">
                                        <div class="text-secondary">
                                            <i class="fas fa-box-open mb-2" style="font-size: 2rem; opacity: 0.3;"></i>
                                            <p class="mb-0">Belum ada batch</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <hr class="my-4 border-light-custom">

                    {{-- Action Buttons --}}
                    <div class="d-flex justify-content-between gap-2">
                        <a href="{{ route('admin.stok_barang.index') }}" class="btn btn-lg btn-secondary-custom px-4">
                            <i class="fas fa-arrow-left me-2"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-lg btn-success-custom px-4">
                            <i class="fas fa-save me-2"></i> Update
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

    /* Card */
    .card {
        background-color: white;
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

    /* Table Styling */
    .table-header-custom {
        background-color: var(--bg-light);
        color: var(--text-secondary);
    }

    .table-row-custom {
        transition: background-color 0.2s ease;
    }

    .table-row-custom:hover {
        background-color: var(--bg-very-light);
    }

    /* Code Badge */
    .code-badge {
        background-color: var(--bg-light);
        color: var(--text-dark);
        padding: 0.25rem 0.5rem;
        border-radius: 0.25rem;
        font-size: 0.875rem;
        font-family: 'Courier New', monospace;
    }

    /* Badges */
    .badge-success-custom {
        background-color: var(--success-color);
        color: white;
        padding: 0.35em 0.65em;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .badge-warning-custom {
        background-color: var(--warning-color);
        color: white;
        padding: 0.35em 0.65em;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .badge-danger-custom {
        background-color: var(--error-color);
        color: white;
        padding: 0.35em 0.65em;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .badge-secondary-custom {
        background-color: var(--text-medium);
        color: white;
        padding: 0.35em 0.65em;
        font-size: 0.75rem;
        font-weight: 600;
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

    .btn-success-custom {
        background-color: var(--success-color);
        border-color: var(--success-color);
        color: white;
    }

    .btn-success-custom:hover {
        background-color: #1aa876;
        border-color: #1aa876;
        color: white;
    }

    .btn-link {
        font-weight: 500;
    }

    .btn-link:hover {
        text-decoration: underline !important;
    }

    /* Small Text */
    small {
        font-size: 0.875rem;
    }
</style>
@endpush
@endsection
