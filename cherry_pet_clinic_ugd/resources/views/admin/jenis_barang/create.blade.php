@extends('admin.layouts.app')

@section('title', 'Tambah Jenis Barang')
@section('page-title', 'Tambah Jenis Barang')

@section('content')
<div class="max-w-3xl mx-auto">
    <!-- Breadcrumb -->
    <div class="mb-6">
        <div class="flex items-center gap-2 text-sm text-gray-600">
            <a href="{{ route('admin.kategori.index') }}" class="hover:text-blue-600">Kategori</a>
            <span>›</span>
            <a href="{{ route('admin.jenis_barang.index') }}" class="hover:text-blue-600">Jenis Barang</a>
            <span>›</span>
            <span class="text-gray-800 font-medium">Tambah Baru</span>
        </div>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-5">
            <h2 class="text-xl font-bold text-white">Tambah Jenis Barang Baru</h2>
            <p class="text-blue-100 text-sm mt-1">Lengkapi informasi jenis barang</p>
        </div>

        <!-- Form Body -->
        <form action="{{ route('admin.jenis_barang.store') }}" method="POST" class="p-6">
            @csrf

            <!-- Kategori -->
            <div class="mb-6">
                <label for="kategori_id" class="block text-sm font-semibold text-gray-700 mb-2">
                    Kategori <span class="text-red-500">*</span>
                </label>
                <select name="kategori_id" id="kategori_id"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('kategori_id') border-red-500 @enderror"
                    required>
                    <option value="">Pilih Kategori</option>
                    @foreach($kategoris as $kategori)
                        <option value="{{ $kategori->id }}"
                            {{ old('kategori_id', request('kategori_id')) == $kategori->id ? 'selected' : '' }}>
                            {{ $kategori->nama_kategori }}
                        </option>
                    @endforeach
                </select>
                @error('kategori_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Kode Jenis -->
            <div class="mb-6">
                <label for="kode_jenis" class="block text-sm font-semibold text-gray-700 mb-2">
                    Kode Jenis <span class="text-red-500">*</span>
                </label>
                <input type="text"
                    name="kode_jenis"
                    id="kode_jenis"
                    value="{{ old('kode_jenis') }}"
                    placeholder="Contoh: OB123456"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all font-mono @error('kode_jenis') border-red-500 @enderror"
                    required>
                @error('kode_jenis')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-xs text-gray-500">Kode unik untuk identifikasi jenis barang</p>
            </div>

            <!-- Nama Jenis -->
            <div class="mb-6">
                <label for="nama_jenis" class="block text-sm font-semibold text-gray-700 mb-2">
                    Nama Jenis <span class="text-red-500">*</span>
                </label>
                <input type="text"
                    name="nama_jenis"
                    id="nama_jenis"
                    value="{{ old('nama_jenis') }}"
                    placeholder="Contoh: Obat Hewan"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('nama_jenis') border-red-500 @enderror"
                    required>
                @error('nama_jenis')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Deskripsi -->
            <div class="mb-6">
                <label for="deskripsi" class="block text-sm font-semibold text-gray-700 mb-2">
                    Deskripsi
                </label>
                <textarea
                    name="deskripsi"
                    id="deskripsi"
                    rows="4"
                    placeholder="Deskripsi singkat tentang jenis barang ini..."
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all resize-none @error('deskripsi') border-red-500 @enderror">{{ old('deskripsi') }}</textarea>
                @error('deskripsi')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center gap-3 pt-6 border-t border-gray-200">
                <button type="submit"
                    class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold transition-colors shadow-sm flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Simpan Data
                </button>
                <a href="{{ route('admin.jenis_barang.index', ['kategori_id' => request('kategori_id')]) }}"
                    class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-3 rounded-lg font-semibold transition-colors flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    Batal
                </a>
            </div>
        </form>
    </div>

    <!-- Info Card -->
    <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
        <div class="flex gap-3">
            <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
            </svg>
            <div class="text-sm text-blue-800">
                <p class="font-semibold mb-1">Informasi:</p>
                <ul class="list-disc list-inside space-y-1 text-blue-700">
                    <li>Kode jenis harus unik dan tidak boleh sama dengan jenis barang lain</li>
                    <li>Pastikan memilih kategori yang sesuai dengan jenis barang</li>
                    <li>Deskripsi bersifat opsional namun disarankan untuk diisi</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
