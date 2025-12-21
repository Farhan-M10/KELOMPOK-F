@extends('admin.layouts.app')

@section('content')
<div class="container-fluid px-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Beranda</a></li>
            <li class="breadcrumb-item"><a href="{{ route('pengadaan.index') }}">Pengadaan Stok</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Pengadaan Stok</li>
        </ol>
    </nav>

    <h4 class="mb-4">Edit Pengadaan Stok</h4>

    {{-- Display Validation Errors --}}
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show">
            <strong>Error Validasi!</strong>
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('pengadaan.update', $pengadaan->id) }}" id="formPengadaan">
                @csrf
                @method('PUT')
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Pemasok <span class="text-danger">*</span></label>
                        <select name="supplier_id" class="form-select @error('supplier_id') is-invalid @enderror" required>
                            <option value="">Pilih Pemasok</option>
                            @foreach($suppliers as $supplier)
                                <option value="{{ $supplier->id }}" {{ old('supplier_id', $pengadaan->suppliers_id) == $supplier->id ? 'selected' : '' }}>
                                    {{ $supplier->nama_supplier }}
                                </option>
                            @endforeach
                        </select>
                        @error('supplier_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tanggal Pengadaan <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal" class="form-control @error('tanggal') is-invalid @enderror" value="{{ old('tanggal', $pengadaan->tanggal->format('Y-m-d')) }}" required>
                        @error('tanggal')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <h5 class="mb-3">Daftar Barang</h5>
                
                <div class="table-responsive">
                    <table class="table table-bordered" id="tableBarang">
                        <thead class="table-light">
                            <tr>
                                <th width="35%">Nama Barang <span class="text-danger">*</span></th>
                                <th width="15%">Satuan</th>
                                <th width="15%">Jumlah Pesan <span class="text-danger">*</span></th>
                                <th width="15%">Harga Satuan <span class="text-danger">*</span></th>
                                <th width="15%">SubTotal</th>
                                <th width="5%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pengadaan->details as $detail)
                            <tr class="item-row">
                                <td>
                                    <select name="barang_id[]" class="form-select barang-select" required>
                                        <option value="">Pilih Barang</option>
                                        @foreach($barangs as $barang)
                                            <option value="{{ $barang->id }}" 
                                                    data-harga="{{ $barang->harga_beli }}"
                                                    data-satuan="{{ $barang->satuan }}"
                                                    {{ $detail->barangs_id == $barang->id ? 'selected' : '' }}>
                                                {{ $barang->nama_barang }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <input type="text" class="form-control satuan" readonly value="{{ $detail->barang->satuan ?? '-' }}">
                                </td>
                                <td>
                                    <input type="number" name="jumlah_pesan[]" class="form-control jumlah" min="1" value="{{ $detail->jumlah_pesan }}" required>
                                </td>
                                <td>
                                    <input type="number" name="harga_satuan[]" class="form-control harga" min="0" step="0.01" value="{{ $detail->harga_satuan }}" required>
                                </td>
                                <td>
                                    <input type="text" class="form-control subtotal" readonly value="Rp {{ number_format($detail->subtotal, 0, ',', '.') }}">
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-sm btn-danger remove-row">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <button type="button" class="btn btn-danger mb-3" id="btnTambahBaris">
                    <i class="fas fa-plus"></i> Tambahkan Barang
                </button>

                <div class="text-end mb-3">
                    <h5>Total Harga: <span id="totalHarga">Rp {{ number_format($pengadaan->total_harga, 0, ',', '.') }}</span></h5>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('pengadaan.index') }}" class="btn btn-outline-secondary">Batal</a>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i> Update Pengadaan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const tableBarang = document.getElementById('tableBarang').getElementsByTagName('tbody')[0];
    const btnTambahBaris = document.getElementById('btnTambahBaris');

    // Template for new row
    const barangOptions = `
        <option value="">Pilih Barang</option>
        @foreach($barangs as $barang)
        <option value="{{ $barang->id }}" 
                data-harga="{{ $barang->harga_beli }}"
                data-satuan="{{ $barang->satuan }}">
            {{ $barang->nama_barang }}
        </option>
        @endforeach
    `;

    // Function to calculate subtotal and total
    function calculateTotals() {
        let total = 0;
        document.querySelectorAll('.item-row').forEach(row => {
            const jumlah = parseFloat(row.querySelector('.jumlah').value) || 0;
            const harga = parseFloat(row.querySelector('.harga').value) || 0;
            const subtotal = jumlah * harga;
            
            row.querySelector('.subtotal').value = 'Rp ' + subtotal.toLocaleString('id-ID');
            total += subtotal;
        });
        
        document.getElementById('totalHarga').textContent = 'Rp ' + total.toLocaleString('id-ID');
    }

    // Function to update remove buttons
    function updateRemoveButtons() {
        const rows = document.querySelectorAll('.item-row');
        rows.forEach((row, index) => {
            const removeBtn = row.querySelector('.remove-row');
            removeBtn.disabled = rows.length === 1;
        });
    }

    // Add new row
    btnTambahBaris.addEventListener('click', function() {
        const newRow = document.createElement('tr');
        newRow.className = 'item-row';
        newRow.innerHTML = `
            <td>
                <select name="barang_id[]" class="form-select barang-select" required>
                    ${barangOptions}
                </select>
            </td>
            <td>
                <input type="text" class="form-control satuan" readonly value="-">
            </td>
            <td>
                <input type="number" name="jumlah_pesan[]" class="form-control jumlah" min="1" value="1" required>
            </td>
            <td>
                <input type="number" name="harga_satuan[]" class="form-control harga" min="0" step="0.01" value="0" required>
            </td>
            <td>
                <input type="text" class="form-control subtotal" readonly value="Rp 0">
            </td>
            <td class="text-center">
                <button type="button" class="btn btn-sm btn-danger remove-row">
                    <i class="fas fa-trash"></i>
                </button>
            </td>
        `;
        
        tableBarang.appendChild(newRow);
        updateRemoveButtons();
        calculateTotals();
    });

    // Event delegation for remove button
    tableBarang.addEventListener('click', function(e) {
        if (e.target.closest('.remove-row')) {
            const row = e.target.closest('.item-row');
            if (document.querySelectorAll('.item-row').length > 1) {
                row.remove();
                updateRemoveButtons();
                calculateTotals();
            }
        }
    });

    // Event delegation for barang selection
    tableBarang.addEventListener('change', function(e) {
        if (e.target.classList.contains('barang-select')) {
            const row = e.target.closest('.item-row');
            const selectedOption = e.target.options[e.target.selectedIndex];
            
            if (selectedOption.value) {
                const harga = selectedOption.dataset.harga || 0;
                const satuan = selectedOption.dataset.satuan || '-';
                
                row.querySelector('.harga').value = harga;
                row.querySelector('.satuan').value = satuan;
            } else {
                row.querySelector('.harga').value = '0';
                row.querySelector('.satuan').value = '-';
            }
            
            calculateTotals();
        }
    });

    // Event delegation for input changes
    tableBarang.addEventListener('input', function(e) {
        if (e.target.classList.contains('jumlah') || e.target.classList.contains('harga')) {
            calculateTotals();
        }
    });

    // Initial calculation
    calculateTotals();
    updateRemoveButtons();
});
</script>
@endpush
@endsection