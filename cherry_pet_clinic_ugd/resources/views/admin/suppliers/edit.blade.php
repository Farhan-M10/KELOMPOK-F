@extends('admin.layouts.app')

@section('title', 'Edit Supplier')
@section('header-title', 'Edit Supplier')

@section('content')
<div class="max-w-3xl mx-auto">

    <!-- Back Button -->
    <a href="{{ route('admin.suppliers.show', $supplier) }}"
       class="inline-flex items-center gap-2 text-gray-600 hover:text-gray-800 mb-6">
        ← Kembali
    </a>

    <!-- Success Alert -->
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6 flex justify-between items-center">
            <span>✅ {{ session('success') }}</span>
            <button onclick="this.parentElement.remove()">✖</button>
        </div>
    @endif

    <!-- Form Card -->
    <div class="bg-white rounded-xl shadow-sm p-6">
        <form action="{{ route('admin.suppliers.update', $supplier) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- ID Supplier -->
            <div class="mb-5">
                <label class="block text-sm font-semibold mb-2">ID Supplier</label>
                <input type="text" value="#{{ $supplier->id }}" disabled
                    class="w-full px-4 py-3 border rounded-lg bg-gray-50">
            </div>

            <!-- Nama Supplier -->
            <div class="mb-5">
                <label class="block text-sm font-semibold mb-2">
                    Nama Supplier <span class="text-red-500">*</span>
                </label>
                <input type="text" name="nama_supplier"
                    value="{{ old('nama_supplier', $supplier->nama_supplier) }}"
                    class="w-full px-4 py-3 border rounded-lg @error('nama_supplier') border-red-500 @enderror">
                @error('nama_supplier')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- NIB -->
            <div class="mb-5">
                <label class="block text-sm font-semibold mb-2">
                    NIB <span class="text-red-500">*</span>
                </label>
                <input type="text" name="nib"
                    value="{{ old('nib', $supplier->nib) }}"
                    class="w-full px-4 py-3 border rounded-lg @error('nib') border-red-500 @enderror">
                @error('nib')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Kategori (Auto) -->
            <div class="mb-5">
                <label class="block text-sm font-semibold mb-2">Kategori</label>
                <input type="text" value="{{ $supplier->kategori->nama_kategori }}" disabled
                    class="w-full px-4 py-3 border rounded-lg bg-gray-50">
                <p class="text-xs text-gray-500 mt-1">
                    Otomatis berdasarkan jenis barang
                </p>
            </div>

            <!-- Jenis Barang -->
            <div class="mb-5">
                <label class="block text-sm font-semibold mb-2">
                    Jenis Barang <span class="text-red-500">*</span>
                </label>
                <select name="jenis_barang_id"
                    class="w-full px-4 py-3 border rounded-lg @error('jenis_barang_id') border-red-500 @enderror">
                    <option value="">Pilih jenis barang</option>
                    @foreach($jenisBarangs->groupBy('kategori.nama_kategori') as $kat => $items)
                        <optgroup label="{{ $kat }}">
                            @foreach($items as $j)
                                <option value="{{ $j->id }}"
                                    {{ old('jenis_barang_id', $supplier->jenis_barang_id) == $j->id ? 'selected' : '' }}>
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
                <label class="block text-sm font-semibold mb-2">
                    Alamat <span class="text-red-500">*</span>
                </label>
                <textarea name="alamat" rows="3"
                    class="w-full px-4 py-3 border rounded-lg @error('alamat') border-red-500 @enderror">{{ old('alamat', $supplier->alamat) }}</textarea>
                @error('alamat')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Kontak -->
            <div class="mb-5">
                <label class="block text-sm font-semibold mb-2">
                    Kontak <span class="text-red-500">*</span>
                </label>
                <input type="text" name="kontak"
                    value="{{ old('kontak', $supplier->kontak) }}"
                    class="w-full px-4 py-3 border rounded-lg @error('kontak') border-red-500 @enderror">
                @error('kontak')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Status -->
            <div class="mb-6">
                <label class="block text-sm font-semibold mb-2">Status</label>
                <select name="status"
                    class="w-full px-4 py-3 border rounded-lg @error('status') border-red-500 @enderror">
                    <option value="aktif" {{ old('status', $supplier->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="tidak_aktif" {{ old('status', $supplier->status) == 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                </select>
            </div>

            <!-- Actions -->
            <div class="flex gap-3">
                <a href="{{ route('admin.suppliers.show', $supplier) }}"
                   class="flex-1 bg-gray-300 text-center px-6 py-3 rounded-lg">
                    Batal
                </a>
                <button type="submit"
                    class="flex-1 bg-green-600 text-white px-6 py-3 rounded-lg">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

    <!-- Danger Zone -->
    <div class="mt-6 p-6 bg-red-50 border border-red-200 rounded-lg">
        <h3 class="text-sm font-semibold text-red-800 mb-2">Zona Berbahaya</h3>
        <p class="text-sm text-red-600 mb-4">
            Data supplier akan dihapus permanen.
        </p>
        <form action="{{ route('admin.suppliers.destroy', $supplier) }}" method="POST"
              onsubmit="return confirm('Yakin ingin menghapus supplier ini?');">
            @csrf
            @method('DELETE')
            <button type="submit"
                class="bg-red-600 text-white px-6 py-2 rounded-lg">
                Hapus Supplier
            </button>
        </form>
    </div>

</div>
@endsection
