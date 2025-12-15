@extends('admin.layouts.app')

@section('title', 'Tambah Supplier')
@section('header-title', 'Tambah Supplier Baru')

@section('content')
<div class="container mx-auto px-4 py-6 max-w-3xl">

    <div class="mb-6">
        <a href="{{ route('admin.suppliers.index') }}" class="text-blue-600 flex items-center gap-2 mb-4">
            ← Kembali
        </a>
        <h2 class="text-xl font-bold">Form Tambah Supplier</h2>
    </div>

    <div class="bg-white rounded-lg shadow-sm p-6">
        <form action="{{ route('admin.suppliers.store') }}" method="POST">
            @csrf

            {{-- Nama Supplier --}}
            <div class="mb-5">
                <label class="block text-sm font-semibold mb-2">
                    Nama Supplier <span class="text-red-500">*</span>
                </label>
                <input type="text" name="nama_supplier" value="{{ old('nama_supplier') }}"
                    class="w-full px-4 py-3 border rounded-lg @error('nama_supplier') border-red-500 @enderror"
                    placeholder="PT. Sejahtera Medika">
                @error('nama_supplier')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- NIB --}}
            <div class="mb-5">
                <label class="block text-sm font-semibold mb-2">
                    NIB <span class="text-red-500">*</span>
                </label>
                <input type="text" name="nib" value="{{ old('nib') }}"
                    class="w-full px-4 py-3 border rounded-lg @error('nib') border-red-500 @enderror"
                    placeholder="1276189002457">
                @error('nib')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Jenis Barang --}}
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
                                <option value="{{ $j->id }}" @selected(old('jenis_barang_id') == $j->id)>
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

            {{-- Alamat --}}
            <div class="mb-5">
                <label class="block text-sm font-semibold mb-2">
                    Alamat <span class="text-red-500">*</span>
                </label>
                <textarea name="alamat" rows="3"
                    class="w-full px-4 py-3 border rounded-lg @error('alamat') border-red-500 @enderror"
                    placeholder="Jl. Kesehatan No.1">{{ old('alamat') }}</textarea>
                @error('alamat')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Kontak --}}
            <div class="mb-5">
                <label class="block text-sm font-semibold mb-2">
                    Kontak <span class="text-red-500">*</span>
                </label>
                <input type="text" name="kontak" value="{{ old('kontak') }}"
                    class="w-full px-4 py-3 border rounded-lg @error('kontak') border-red-500 @enderror"
                    placeholder="081329891201">
                @error('kontak')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Status --}}
            <div class="mb-6">
                <label class="block text-sm font-semibold mb-2">
                    Status <span class="text-red-500">*</span>
                </label>
                <select name="status"
                    class="w-full px-4 py-3 border rounded-lg @error('status') border-red-500 @enderror">
                    <option value="aktif">Aktif</option>
                    <option value="tidak_aktif">Tidak Aktif</option>
                </select>
                @error('status')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Button --}}
            <div class="flex gap-3">
                <button type="submit"
                    class="flex-1 bg-blue-600 text-white px-6 py-3 rounded-lg">
                    Simpan
                </button>
                <a href="{{ route('admin.suppliers.index') }}"
                    class="flex-1 bg-gray-200 text-gray-800 px-6 py-3 rounded-lg text-center">
                    Batal
                </a>
            </div>

        </form>
    </div>
</div>
@endsection
