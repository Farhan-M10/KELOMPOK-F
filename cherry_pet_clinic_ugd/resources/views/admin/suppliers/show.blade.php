@extends('layouts.app')

@section('title', 'Detail Supplier')
@section('page-title', 'Detail Supplier')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Back Button -->
    <a href="{{ route('suppliers.index') }}" class="inline-flex items-center gap-2 text-gray-600 hover:text-gray-800 mb-6">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Kembali
    </a>

    <!-- Card Header -->
    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-t-xl p-6 border-b">
        <div class="flex items-center gap-4">
            <div class="w-16 h-16 bg-white rounded-lg shadow-md flex items-center justify-center">
                <span class="text-3xl">{{ $supplier->jenisBarang->icon ?? '💊' }}</span>
            </div>
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <span class="text-xs font-semibold text-gray-500">ID:#{{ $supplier->id }}</span>
                    <span class="px-3 py-1 bg-blue-500 text-white text-xs rounded-full font-medium">
                        {{ $supplier->kategori->nama_kategori }}
                    </span>
                </div>
                <h2 class="text-2xl font-bold text-gray-800">{{ $supplier->nama_supplier }}</h2>
            </div>
        </div>
    </div>

    <!-- Card Body -->
    <div class="bg-white rounded-b-xl shadow-sm p-6">
        <!-- Info Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <!-- NIB -->
            <div class="border rounded-lg p-4">
                <h3 class="text-sm font-semibold text-gray-500 mb-2">NIB</h3>
                <p class="text-lg font-bold text-gray-800">{{ $supplier->nib }}</p>
            </div>

            <!-- Kategori -->
            <div class="border rounded-lg p-4">
                <h3 class="text-sm font-semibold text-gray-500 mb-2">Kategori</h3>
                <p class="text-lg font-bold text-gray-800">{{ $supplier->kategori->nama_kategori }}</p>
            </div>
        </div>

        <!-- Jenis Barang -->
        <div class="border rounded-lg p-4 mb-6">
            <h3 class="text-sm font-semibold text-gray-500 mb-2">Jenis Barang</h3>
            <p class="text-lg font-bold text-gray-800">{{ $supplier->jenisBarang->nama_jenis }}</p>
        </div>

        <!-- Nomor Kontak -->
        <div class="border rounded-lg p-4 mb-6">
            <h3 class="text-sm font-semibold text-gray-500 mb-2">Nomor Kontak</h3>
            <p class="text-lg font-bold text-gray-800 mb-3">{{ $supplier->kontak }}</p>
            <div class="flex gap-3">
                <a href="https://wa.me/62{{ ltrim($supplier->kontak, '0') }}" target="_blank"
                    class="flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                    </svg>
                    WhatsApp
                </a>
                <a href="tel:{{ $supplier->kontak }}"
                    class="flex items-center gap-2 bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                    </svg>
                    Telepon
                </a>
            </div>
        </div>

        <!-- Alamat -->
        <div class="border rounded-lg p-4 mb-6">
            <h3 class="text-sm font-semibold text-gray-500 mb-2">Alamat</h3>
            <p class="text-base text-gray-700 leading-relaxed">{{ $supplier->alamat }}</p>
        </div>

        <!-- Action Buttons -->
        <div class="flex gap-3">
            <a href="{{ route('suppliers.index') }}"
                class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 text-center px-6 py-3 rounded-lg font-medium transition">
                Tutup
            </a>
            <a href="{{ route('suppliers.edit', $supplier) }}"
                class="flex-1 bg-green-600 hover:bg-green-700 text-white text-center px-6 py-3 rounded-lg font-medium transition">
                Edit Supplier
            </a>
        </div>
    </div>

    <!-- Additional Info -->
    <div class="mt-4 text-xs text-gray-500 text-center">
        <p>Dibuat: {{ $supplier->created_at->format('d M Y, H:i') }}</p>
        <p>Diupdate: {{ $supplier->updated_at->format('d M Y, H:i') }}</p>
    </div>
</div>
@endsection
