@extends('layouts.app')

@section('title', 'Edit Supplier')
@section('page-title', 'Edit Supplier')

@section('content')
<div class="max-w-3xl mx-auto">
    <!-- Back Button -->
    <a href="{{ route('suppliers.show', $supplier) }}" class="inline-flex items-center gap-2 text-gray-600 hover:text-gray-800 mb-6">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Kembali
    </a>

    <!-- Success Alert -->
    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6 flex items-center justify-between">
        <span>✅ {{ session('success') }}</span>
        <button onclick="this.parentElement.remove()" class="text-green-700 hover:text-green-900">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>
    @endif

    <!-- Form Card -->
    <div class="bg-white rounded-xl shadow-sm p-6">
        <form action="{{ route('suppliers.update', $supplier) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- ID Supplier (Read Only) -->
            <div class="mb-5">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    ID Supplier
                </label>
                <input type="text" value="#{{ $supplier->id }}" disabled
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-50 text-gray-600">
            </div>

            <!-- Nama Perusahaan -->
            <div class="mb-5">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Nama Perusahaan <span class="text-red-500">*</span>
                </label>
                <input type="text" name="nama_supplier" value="{{ old('nama_supplier', $supplier->nama_supplier) }}"
                    class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('nama_supplier') border-red-500 @enderror"
                    placeholder="PT. Sejahtera Medika">
                @error('nama_supplier')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- NIB -->
            <div class="mb-5">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    NIB <span class="text-red-500">*</span>
                </label>
                <input type="text" name="nib" value="{{ old('nib', $supplier->nib) }}"
                    class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('nib') border-red-500 @enderror"
                    placeholder="1276189024571">
                @error('nib')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Kategori (Read Only - Auto dari Jenis Barang) -->
            <div class="mb-5">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Kategori
                </label>
                <input type="text" value="{{ $supplier->kategori->nama_kategori }}" disabled
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-50 text-gray-600">
                <p class="text-xs text-gray-500 mt-1">Kategori otomatis berdasarkan jenis barang</p>
            </div>

            <!-- Jenis Barang -->
            <div class="mb-5">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Jenis Barang <span class="text-red-500">*</span>
                </label>
                <select name="jenis_barang_id"
                    class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('jenis_barang_id') border-red-500 @enderror">
                    <option value="">Pilih jenis barang</option>
                    @foreach($jenisBarangs->groupBy('kategori.nama_kategori') as $kat => $items)
                        <optgroup label="{{ $kat }}">
                            @foreach($items as $j)
                                <option value="{{ $j->id }}" {{ old('jenis_barang_id', $supplier->jenis_barang_id) == $j->id ? 'selected' : '' }}>
                                    {{ $j->icon }} {{ $j->nama_jenis }}
                                </option>
                            @endforeach
                        </optgroup>
                    @endforeach
                </select>
                @error('jenis_barang_id')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Alamat -->
            <div class="mb-5">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Alamat <span class="text-red-500">*</span>
                </label>
                <textarea name="alamat" rows="3"
                    class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('alamat') border-red-500 @enderror"
                    placeholder="Jl. Kesehatan No.1, Jakarta">{{ old('alamat', $supplier->alamat) }}</textarea>
                @error('alamat')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Nomor Kontak -->
            <div class="mb-5">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Nomor Kontak <span class="text-red-500">*</span>
                </label>
                <input type="text" name="kontak" value="{{ old('kontak', $supplier->kontak) }}"
                    class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('kontak') border-red-500 @enderror"
                    placeholder="081382891272">
                @error('kontak')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Status -->
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Status <span class="text-red-500">*</span>
                </label>
                <select name="status"
                    class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('status') border-red-500 @enderror">
                    <option value="aktif" {{ old('status', $supplier->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="tidak_aktif" {{ old('status', $supplier->status) == 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                </select>
                @error('status')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Action Buttons -->
            <div class="flex gap-3">
                <a href="{{ route('suppliers.show', $supplier) }}"
                    class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 text-center px-6 py-3 rounded-lg font-medium transition">
                    Batal
                </a>
                <button type="submit"
                    class="flex-1 bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-medium transition">
                    Edit Supplier
                </button>
            </div>
        </form>
    </div>

    <!-- Delete Button (Optional) -->
    <div class="mt-6 p-6 bg-red-50 border border-red-200 rounded-lg">
        <h3 class="text-sm font-semibold text-red-800 mb-2">Zona Berbahaya</h3>
        <p class="text-sm text-red-600 mb-4">Menghapus supplier ini akan menghapus semua data terkait secara permanen.</p>
        <form action="{{ route('suppliers.destroy', $supplier) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus supplier ini? Data yang sudah dihapus tidak dapat dikembalikan!');">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg font-medium transition">
                Hapus Supplier
            </button>
        </form>
    </div>
</div>
@endsection
