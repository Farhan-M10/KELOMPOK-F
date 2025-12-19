@extends('admin.layouts.app')

@section('title', 'Data Supplier')
@section('page-title', 'Pemasok')

@section('content')
<div class="max-w-7xl mx-auto">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Pemasok</h1>
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-6">
            <div class="bg-white rounded-lg p-5 shadow border border-gray-100">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-gray-600 text-sm mb-1">Total Supplier</p>
                        <p class="text-3xl font-semibold text-gray-800">{{ \App\Models\Supplier::count() }}</p>
                    </div>
                    <div class="bg-indigo-50 p-3 rounded-lg">
                        <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg p-5 shadow border border-gray-100">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-gray-600 text-sm mb-1">Supplier Aktif</p>
                        <p class="text-3xl font-semibold text-gray-800">{{ \App\Models\Supplier::where('status', 'aktif')->count() }}</p>
                    </div>
                    <div class="bg-emerald-50 p-3 rounded-lg">
                        <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg p-5 shadow border border-gray-100">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-gray-600 text-sm mb-1">Jenis Produk</p>
                        <p class="text-3xl font-semibold text-gray-800">{{ \App\Models\JenisBarang::count() }}</p>
                    </div>
                    <div class="bg-sky-50 p-3 rounded-lg">
                        <svg class="w-6 h-6 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Search & Filter Bar -->
        <div class="bg-white rounded-lg shadow border border-gray-100 p-4 mb-6">
            <form method="GET" class="flex flex-col md:flex-row gap-3">
                <div class="flex-1 relative">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari nama supplier, NIB, atau alamat..."
                        class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <select name="kategori" class="px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white">
    <option value="">Semua Jenis Produk</option>
    <option value="Medis" {{ request('kategori') == 'Medis' ? 'selected' : '' }}>Medis</option>
    <option value="Non-Medis" {{ request('kategori') == 'Non-Medis' ? 'selected' : '' }}>Non Medis</option>
</select>

                <button type="submit" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors">
                    Filter
                </button>
                <a href="{{ route('admin.suppliers.create') }}" class="px-6 py-2.5 bg-red-500 hover:bg-red-600 text-white rounded-lg font-medium transition-colors">
                    + Tambah Supplier
                </a>
            </form>
        </div>

        @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 text-green-800 px-4 py-3 rounded mb-6">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        </div>
        @endif

        <!-- Supplier Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            @forelse($suppliers as $s)
            <div class="bg-white rounded-lg shadow border border-gray-100 p-5 hover:shadow-md transition-shadow border-l-4 {{ $s->kategori->nama_kategori == 'Medis' ? 'border-l-green-500' : 'border-l-blue-500' }}">
                <!-- Header -->
                <div class="flex items-start justify-between mb-4 pb-4 border-b border-gray-100">
                    <div>
                        <h3 class="font-semibold text-gray-800 text-lg">{{ $s->nama_supplier }}</h3>
                        <p class="text-xs text-gray-500 mt-0.5">NIB: {{ $s->nib }}</p>
                    </div>
                    <span class="px-3 py-1 text-xs font-medium rounded-full {{ $s->kategori->nama_kategori == 'Medis' ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700' }}">
                        {{ $s->kategori->nama_kategori }}
                    </span>
                </div>

                <!-- Info Section -->
                <div class="space-y-3 mb-4">
                    <div class="flex gap-3 items-start">
                        <svg class="w-4 h-4 text-gray-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs text-gray-500 mb-0.5">Jenis Barang</p>
                            <p class="text-sm font-medium text-gray-800">{{ $s->jenisBarang->nama_jenis }}</p>
                        </div>
                    </div>

                    <div class="flex gap-3 items-start">
                        <svg class="w-4 h-4 text-gray-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs text-gray-500 mb-0.5">Alamat</p>
                            <p class="text-sm font-medium text-gray-800 truncate">{{ $s->alamat }}</p>
                        </div>
                    </div>

                    <div class="flex gap-3 items-start">
                        <svg class="w-4 h-4 text-gray-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs text-gray-500 mb-0.5">Kontak</p>
                            <p class="text-sm font-medium text-gray-800">{{ $s->kontak }}</p>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-2 pt-4 border-t border-gray-100">
                    <a href="{{ route('admin.suppliers.show', $s) }}"
                       class="flex-1 bg-blue-600 hover:bg-blue-700 text-white text-center px-3 py-2.5 rounded-lg text-sm font-medium transition-colors">
                        Detail
                    </a>
                    <a href="{{ route('admin.suppliers.edit', $s) }}"
                       class="flex-1 bg-green-600 hover:bg-green-700 text-white text-center px-3 py-2.5 rounded-lg text-sm font-medium transition-colors">
                        Edit
                    </a>
                    <form action="{{ route('admin.suppliers.destroy', $s) }}" method="POST"
                          onsubmit="return confirm('Yakin ingin menghapus supplier ini?')" class="flex-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="w-full bg-red-600 hover:bg-red-700 text-white px-3 py-2.5 rounded-lg text-sm font-medium transition-colors">
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
            @empty
            <div class="col-span-full bg-white rounded-lg shadow border border-gray-100 py-16">
                <div class="text-center">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-gray-100 rounded-full mb-4">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-800 mb-1">Belum ada supplier</h3>
                    <p class="text-gray-500 text-sm">Klik tombol "Tambah Supplier" untuk menambahkan data</p>
                </div>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($suppliers->hasPages())
            <div class="mt-6">
                <div class="bg-white rounded-lg shadow-sm p-4">
                    <div class="flex items-center justify-between">
                        <div class="text-sm text-gray-600">
                            Menampilkan {{ $suppliers->firstItem() }} - {{ $suppliers->lastItem() }} dari {{ $suppliers->total() }} data
                        </div>
                        <div class="flex gap-1">
                            {{ $suppliers->appends(['kategori' => request('kategori'), 'search' => request('search')])->links() }}
                        </div>
                    </div>
                </div>
            </div>
        @endif
</div>
@endsection
