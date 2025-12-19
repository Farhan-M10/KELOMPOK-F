@extends('admin.layouts.app')

@section('title', 'Detail Supplier')
@section('header-title', 'Detail Supplier')

@section('content')
<div class="max-w-4xl mx-auto">

    <!-- Back Button -->
    <a href="{{ route('admin.suppliers.index') }}"
       class="inline-flex items-center gap-2 text-gray-600 hover:text-gray-800 mb-6">
        ← Kembali
    </a>

    <!-- Header Card -->
    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-t-xl p-6 border-b">
        <div class="flex items-center gap-4">
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <span class="text-xs font-semibold text-gray-500">
                        ID #{{ $supplier->id }}
                    </span>
                    <span class="px-3 py-1 text-xs rounded-full
                        {{ $supplier->kategori->nama_kategori == 'Medis'
                            ? 'bg-green-100 text-green-700'
                            : 'bg-blue-100 text-blue-700' }}">
                        {{ $supplier->kategori->nama_kategori }}
                    </span>
                </div>
                <h2 class="text-2xl font-bold text-gray-800">
                    {{ $supplier->nama_supplier }}
                </h2>
            </div>
        </div>
    </div>

    <!-- Body Card -->
    <div class="bg-white rounded-b-xl shadow-sm p-6">

        <!-- Info Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div class="border rounded-lg p-4">
                <p class="text-sm text-gray-500 mb-1">NIB</p>
                <p class="text-lg font-semibold">{{ $supplier->nib }}</p>
            </div>

            <div class="border rounded-lg p-4">
                <p class="text-sm text-gray-500 mb-1">Kategori</p>
                <p class="text-lg font-semibold">
                    {{ $supplier->kategori->nama_kategori }}
                </p>
            </div>
        </div>

        <!-- Jenis Barang -->
        <div class="border rounded-lg p-4 mb-6">
            <p class="text-sm text-gray-500 mb-1">Jenis Barang</p>
            <p class="text-lg font-semibold">
                {{ $supplier->jenisBarang->nama_jenis }}
            </p>
        </div>

        <!-- Kontak -->
        <div class="border rounded-lg p-4 mb-6">
            <p class="text-sm text-gray-500 mb-2">Kontak</p>
            <p class="text-lg font-semibold mb-4">
                {{ $supplier->kontak }}
            </p>

            <div class="flex gap-3">
                <a href="https://wa.me/62{{ ltrim($supplier->kontak, '0') }}"
                   target="_blank"
                   class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg">
                    WhatsApp
                </a>

                <a href="tel:{{ $supplier->kontak }}"
                   class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">
                    Telepon
                </a>
            </div>
        </div>

        <!-- Alamat -->
        <div class="border rounded-lg p-4 mb-6">
            <p class="text-sm text-gray-500 mb-2">Alamat</p>
            <p class="text-gray-700 leading-relaxed">
                {{ $supplier->alamat }}
            </p>
        </div>

        <!-- Actions -->
        <div class="flex gap-3">
            <a href="{{ route('admin.suppliers.index') }}"
               class="flex-1 bg-gray-300 text-center px-6 py-3 rounded-lg">
                Tutup
            </a>
            <a href="{{ route('admin.suppliers.edit', $supplier) }}"
               class="flex-1 bg-green-600 text-white text-center px-6 py-3 rounded-lg">
                Edit Supplier
            </a>
        </div>
    </div>

    <!-- Footer Info -->
    <div class="mt-4 text-xs text-gray-500 text-center">
        <p>Dibuat: {{ $supplier->created_at->format('d M Y, H:i') }}</p>
        <p>Diubah: {{ $supplier->updated_at->format('d M Y, H:i') }}</p>
    </div>

</div>
@endsection
