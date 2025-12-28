@extends('staff.layouts.app')

@section('title', 'Pengurangan Stok - Cherry Pet Clinic')
@section('page-title', 'Pengurangan Stok')

@section('content')
<div class="container-fluid">
    <p class="text-muted mb-4">Kurangi barang setelah digunakan dalam pemeriksaan</p>

    {{-- Tab Medis / Non-Medis --}}
    <div class="mb-4">
        <div class="btn-group" role="group">
            <a href="{{ route('staff.pengurangan_stok.index', ['tab' => 'medis']) }}"
               class="btn {{ request('tab', 'medis') === 'medis' ? 'btn-primary' : 'btn-outline-primary' }} px-5">
                Medis
            </a>
            <a href="{{ route('staff.pengurangan_stok.index', ['tab' => 'non-medis']) }}"
               class="btn {{ request('tab') === 'non-medis' ? 'btn-primary' : 'btn-outline-primary' }} px-5">
                Non-Medis
            </a>
        </div>
    </div>

    {{-- Filter Section --}}
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('staff.pengurangan_stok.index') }}" method="GET" id="filterForm">
                <input type="hidden" name="tab" value="{{ request('tab', 'medis') }}">
                <div class="row g-3">
                    <div class="col-md-3">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="fas fa-search text-muted"></i>
                            </span>
                            <input type="text" name="search" class="form-control border-start-0"
                                   placeholder="Cari barang..." value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <select name="kategori_id" class="form-select">
                            <option value="">Semua Kategori</option>
                            @foreach($kategoris as $kategori)
                                <option value="{{ $kategori->id }}" {{ request('kategori_id') == $kategori->id ? 'selected' : '' }}>
                                    {{ $kategori->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select name="lokasi" class="form-select">
                            <option value="">Semua Lokasi</option>
                            @foreach($lokasis as $lokasi)
                                <option value="{{ $lokasi }}" {{ request('lokasi') == $lokasi ? 'selected' : '' }}>
                                    {{ $lokasi }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select name="status" class="form-select">
                            <option value="">Semua Status</option>
                            <option value="Stok Aman" {{ request('status') == 'Stok Aman' ? 'selected' : '' }}>Stok Aman</option>
                            <option value="Perhatian" {{ request('status') == 'Perhatian' ? 'selected' : '' }}>Perhatian</option>
                            <option value="Kritis" {{ request('status') == 'Kritis' ? 'selected' : '' }}>Kritis</option>
                        </select>
                    </div>
                    <div class="col-md-3 text-end">
                        <button type="button" class="btn btn-danger" id="btnExport">
                            <i class="fas fa-file-export me-1"></i> Export
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Tabel Stok --}}
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>NAMA BARANG</th>
                            <th>KATEGORI</th>
                            <th>LOKASI</th>
                            <th>TOTAL STOK</th>
                            <th>BATCH & KADALUARSA</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($barangs as $barang)
                            <tr>
                                <td class="fw-semibold">{{ $barang->nama_barang }}</td>
                                <td>{{ $barang->kategori->nama_kategori }}</td>
                                <td>
                                    {{ $barang->lokasi }}
                                    @if($barang->ruangan)
                                        <small class="text-muted d-block">{{ $barang->ruangan }}</small>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-info">{{ $barang->total_stok }} {{ $barang->satuan }}</span>
                                    <small class="text-muted d-block">{{ $barang->batchBarangs->where('jumlah', '>', 0)->count() }} Batch</small>
                                </td>
                                <td>
                                    @foreach($barang->batchBarangs as $batch)
                                        @if($batch->jumlah > 0)
                                        <div class="batch-item mb-3 pb-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                                            <div class="d-flex justify-content-between align-items-start">
                                                <div class="flex-grow-1">
                                                    <div class="text-primary fw-semibold">{{ $batch->nomor_batch }}</div>
                                                    <div class="small text-muted">
                                                        Masuk: {{ $batch->tanggal_masuk->format('d M Y') }}
                                                    </div>
                                                    <div class="small {{ $batch->sisaHari() < 0 ? 'text-danger' : ($batch->sisaHari() <= 30 ? 'text-warning' : 'text-success') }}">
                                                        ED: {{ $batch->tanggal_kadaluarsa->format('d M Y') }}
                                                    </div>
                                                    <div class="mt-1">
                                                        <span class="badge bg-secondary">Stok: {{ $batch->jumlah }} {{ $barang->satuan }}</span>
                                                    </div>
                                                </div>
                                                <div class="text-end" style="min-width: 120px;">
                                                    <label class="small text-muted mb-1">Kurangi:</label>
                                                    <div class="input-group input-group-sm mb-2" style="width: 100px;">
                                                        <input type="number"
                                                               class="form-control form-control-sm text-center kurangi-input"
                                                               data-batch-id="{{ $batch->id }}"
                                                               data-stok-tersedia="{{ $batch->jumlah }}"
                                                               data-nama-barang="{{ $barang->nama_barang }}"
                                                               data-batch-number="{{ $batch->nomor_batch }}"
                                                               data-satuan="{{ $barang->satuan }}"
                                                               min="0"
                                                               max="{{ $batch->jumlah }}"
                                                               value="0"
                                                               placeholder="0">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                    @endforeach
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">
                                    <i class="fas fa-box-open fa-3x mb-3 d-block"></i>
                                    <p class="mb-0">Tidak ada data stok barang</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Padding bottom untuk summary bar --}}
    <div style="height: 100px;"></div>
</div>

{{-- Modal Konfirmasi Pengurangan --}}
<div class="modal fade" id="confirmModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    Konfirmasi Pengurangan Stok
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-light border">
                    <div class="mb-2">
                        <strong>Barang:</strong>
                        <div id="confirmNamaBarang" class="text-primary fw-semibold"></div>
                    </div>
                    <div class="mb-0">
                        <strong>Jumlah Pengurangan:</strong>
                        <span id="confirmJumlah" class="text-danger fw-bold fs-5"></span>
                    </div>
                </div>

                <form id="penguranganForm">
                    @csrf
                    <input type="hidden" id="batchBarangId" name="batch_barang_id">
                    <input type="hidden" id="jumlahPengurangan" name="jumlah_pengurangan">

                    <div class="mb-3">
                        <label class="form-label">Alasan Pengurangan <span class="text-danger">*</span></label>
                        <select class="form-select" name="alasan" id="alasanSelect" required>
                            <option value="">Pilih alasan...</option>
                            <option value="Digunakan untuk pemeriksaan pasien">Digunakan untuk pemeriksaan pasien</option>
                            <option value="Digunakan untuk operasi">Digunakan untuk operasi</option>
                            <option value="Digunakan untuk perawatan rawat inap">Digunakan untuk perawatan rawat inap</option>
                            <option value="Rusak/Kadaluarsa">Rusak/Kadaluarsa</option>
                            <option value="Hilang">Hilang</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Keterangan Tambahan (Opsional)</label>
                        <textarea class="form-control" name="keterangan" rows="3" placeholder="Masukkan keterangan tambahan jika diperlukan..."></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i> Batal
                </button>
                <button type="button" class="btn btn-danger" id="btnKonfirmasi">
                    <i class="fas fa-check me-1"></i> Konfirmasi Pengurangan
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Summary Bar Fixed Bottom --}}
<div class="summary-bar-fixed" id="summaryBar" style="display: none;">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-6 col-7">
                <div class="d-flex align-items-center">
                    <i class="fas fa-shopping-cart text-danger fs-4 me-3"></i>
                    <div>
                        <small class="text-muted d-block">Total akan dikurangi:</small>
                        <span class="fw-bold text-danger fs-4" id="totalPengurangan">0 unit</span>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-5 text-end">
                <button type="button" class="btn btn-danger btn-lg shadow-sm" id="btnKurangBarang">
                    <i class="fas fa-minus-circle me-2"></i>
                    <span class="d-none d-md-inline">Kurangi Barang</span>
                    <span class="d-inline d-md-none">Kurangi</span>
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
    .batch-item:last-child {
        margin-bottom: 0 !important;
        padding-bottom: 0 !important;
    }

    .kurangi-input:focus {
        border-color: #dc3545;
        box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
    }

    .input-group-sm .form-control {
        font-size: 0.875rem;
    }

    /* Summary Bar Styling */
    .summary-bar-fixed {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
        border-top: 3px solid #dc3545;
        box-shadow: 0 -4px 20px rgba(0, 0, 0, 0.15);
        padding: 1rem 0;
        z-index: 1040;
        animation: slideUp 0.3s ease-out;
    }

    @keyframes slideUp {
        from {
            transform: translateY(100%);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    /* Responsive untuk mobile */
    @media (max-width: 768px) {
        .summary-bar-fixed {
            padding: 0.75rem 0;
        }

        .summary-bar-fixed .fs-4 {
            font-size: 1.2rem !important;
        }

        .summary-bar-fixed .btn-lg {
            padding: 0.5rem 1rem;
            font-size: 0.9rem;
        }
    }

    /* Animasi untuk input */
    .kurangi-input {
        transition: all 0.2s ease;
    }

    .kurangi-input:not([value="0"]) {
        background-color: #fff3cd;
        border-color: #ffc107;
        font-weight: bold;
    }
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    console.log('✅ Pengurangan Stok Script Loaded');

    let selectedItems = [];

    // Monitor perubahan input dengan debounce
    let debounceTimer;
    $(document).on('input', '.kurangi-input', function() {
        clearTimeout(debounceTimer);

        const $input = $(this);
        const value = parseInt($input.val()) || 0;
        const max = parseInt($input.attr('max'));

        // Validasi tidak boleh lebih dari stok
        if (value > max) {
            $input.val(max);
            Swal.fire({
                icon: 'warning',
                title: 'Perhatian',
                text: `Jumlah tidak boleh melebihi stok tersedia (${max})!`,
                timer: 2000,
                showConfirmButton: false,
                toast: true,
                position: 'top-end'
            });
        }

        // Update summary dengan delay
        debounceTimer = setTimeout(function() {
            updateSummary();
        }, 300);
    });

    function updateSummary() {
        selectedItems = [];
        let totalUnit = 0;

        $('.kurangi-input').each(function() {
            const value = parseInt($(this).val()) || 0;
            if (value > 0) {
                selectedItems.push({
                    batchId: $(this).data('batch-id'),
                    namaBarang: $(this).data('nama-barang'),
                    batchNumber: $(this).data('batch-number'),
                    stokTersedia: $(this).data('stok-tersedia'),
                    satuan: $(this).data('satuan'),
                    jumlah: value
                });
                totalUnit += value;
            }
        });

        console.log('📦 Selected items:', selectedItems.length);
        console.log('🔢 Total unit:', totalUnit);

        if (totalUnit > 0) {
            $('#totalPengurangan').text(totalUnit + ' unit');
            $('#summaryBar').fadeIn(300);
            console.log('✅ Summary bar visible');
        } else {
            $('#summaryBar').fadeOut(300);
            console.log('❌ Summary bar hidden');
        }
    }

    // Tombol Kurang Barang
    $('#btnKurangBarang').click(function() {
        console.log('🔘 Button clicked');

        if (selectedItems.length === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'Perhatian',
                text: 'Silakan masukkan jumlah pengurangan terlebih dahulu!',
                confirmButtonColor: '#dc3545'
            });
            return;
        }

        console.log('🚀 Processing', selectedItems.length, 'items');
        processItems(0);
    });

    function processItems(index) {
        console.log('⚙️ Processing item index:', index);

        if (index >= selectedItems.length) {
            // Semua item sudah diproses
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: 'Semua pengurangan stok berhasil dicatat!',
                timer: 2000,
                showConfirmButton: false
            }).then(() => {
                console.log('🔄 Reloading page...');
                location.reload();
            });
            return;
        }

        const item = selectedItems[index];
        showConfirmModal(item, function() {
            processItems(index + 1);
        });
    }

    function showConfirmModal(item, callback) {
        console.log('📋 Show modal for:', item.namaBarang);

        $('#confirmNamaBarang').text(item.namaBarang + ' - Batch: ' + item.batchNumber);
        $('#confirmJumlah').text(item.jumlah + ' ' + item.satuan);
        $('#batchBarangId').val(item.batchId);
        $('#jumlahPengurangan').val(item.jumlah);

        // Store callback
        $('#confirmModal').data('callback', callback);

        // Reset form
        $('#penguranganForm')[0].reset();
        $('#batchBarangId').val(item.batchId);
        $('#jumlahPengurangan').val(item.jumlah);

        // Show modal
        const modal = new bootstrap.Modal(document.getElementById('confirmModal'));
        modal.show();
    }

    // Konfirmasi Pengurangan
    $('#btnKonfirmasi').click(function() {
        const form = $('#penguranganForm');
        const alasan = form.find('select[name="alasan"]').val();

        console.log('✔️ Konfirmasi clicked, alasan:', alasan);

        if (!alasan) {
            Swal.fire({
                icon: 'warning',
                title: 'Perhatian',
                text: 'Silakan pilih alasan pengurangan!',
                confirmButtonColor: '#dc3545'
            });
            return;
        }

        // Disable button
        const $btn = $(this);
        $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2"></span>Memproses...');

        console.log('📤 Sending AJAX request...');

        $.ajax({
            url: '{{ route("staff.pengurangan.store") }}',
            method: 'POST',
            data: form.serialize(),
            success: function(response) {
                console.log('✅ Success:', response);

                if (response.success) {
                    // Hide modal
                    const modal = bootstrap.Modal.getInstance(document.getElementById('confirmModal'));
                    modal.hide();

                    // Panggil callback
                    const callback = $('#confirmModal').data('callback');
                    if (callback) {
                        setTimeout(callback, 300);
                    }
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: response.message || 'Terjadi kesalahan!',
                        confirmButtonColor: '#dc3545'
                    });
                    $btn.prop('disabled', false).html('<i class="fas fa-check me-1"></i> Konfirmasi Pengurangan');
                }
            },
            error: function(xhr) {
                console.log('❌ Error:', xhr);

                const message = xhr.responseJSON?.message || 'Terjadi kesalahan!';
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: message,
                    confirmButtonColor: '#dc3545'
                });
                $btn.prop('disabled', false).html('<i class="fas fa-check me-1"></i> Konfirmasi Pengurangan');
            }
        });
    });

    // Reset modal saat ditutup
    $('#confirmModal').on('hidden.bs.modal', function() {
        $('#penguranganForm')[0].reset();
        $('#btnKonfirmasi').prop('disabled', false).html('<i class="fas fa-check me-1"></i> Konfirmasi Pengurangan');
    });

    // Auto submit filter
    $('select[name="kategori_id"], select[name="lokasi"], select[name="status"]').change(function() {
        $('#filterForm').submit();
    });

    // Export button
    $('#btnExport').click(function() {
        Swal.fire({
            icon: 'info',
            title: 'Fitur Export',
            text: 'Fitur export sedang dalam pengembangan',
            confirmButtonColor: '#dc3545'
        });
    });

    // Initial check
    updateSummary();

    console.log('✅ All event listeners attached');
});
</script>
@endpush
