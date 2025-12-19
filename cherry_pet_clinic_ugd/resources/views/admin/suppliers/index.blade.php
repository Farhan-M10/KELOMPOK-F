
@extends('admin.layouts.app')

@section('title', 'Data Supplier - Cherry Pet Clinic')

@section('header-title', 'Data Supplier')

@section('content')
        <!-- Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="bg-white rounded-lg p-4 shadow-sm">
                <div class="flex justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Total Supplier</p>
                        <p class="text-3xl font-bold">{{ \App\Models\Supplier::count() }}</p>
                    </div>
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                        <span class="text-2xl">🏢</span>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg p-4 shadow-sm">
                <div class="flex justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Supplier Aktif</p>
                        <p class="text-3xl font-bold">{{ \App\Models\Supplier::where('status', 'aktif')->count() }}</p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <span class="text-2xl">✅</span>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg p-4 shadow-sm">
                <div class="flex justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Jenis Produk</p>
                        <p class="text-3xl font-bold">{{ \App\Models\JenisBarang::count() }}</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <span class="text-2xl">📦</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter -->
        <div class="bg-white rounded-lg shadow-sm p-4 mb-6">
            <form method="GET" class="flex flex-col md:flex-row gap-3">
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Cari supplier..."
                    class="flex-1 px-4 py-2.5 border rounded-lg">
                <select name="jenis_barang_id" class="px-4 py-2.5 border rounded-lg">
                    <option value="">Semua Jenis</option>
                    @foreach($jenisBarangs->groupBy('kategori.nama_kategori') as $kat => $items)
                        <optgroup label="{{ $kat }}">
                            @foreach($items as $j)
                                <option value="{{ $j->id }}" {{ request('jenis_barang_id') == $j->id ? 'selected' : '' }}>
                                    {{ $j->icon }} {{ $j->nama_jenis }}
                                </option>
                            @endforeach
                        </optgroup>
                    @endforeach
                </select>
                <button class="px-6 py-2.5 bg-blue-600 text-white rounded-lg">Filter</button>
                <a href="{{ route('admin.suppliers.create') }}" class="px-6 py-2.5 bg-red-500 text-white rounded-lg">+ Tambah</a>
            </form>
        </div>

        @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-4">
            {{ session('success') }}
        </div>
        @endif

        <!-- Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @forelse($suppliers as $s)
            <div class="bg-white rounded-xl shadow-sm p-5">
                <div class="flex justify-between mb-4">
                    <div class="flex gap-3">
                        <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                            <span class="text-xl">{{ $s->jenisBarang->icon ?? '📦' }}</span>
                        </div>
                        <div>
                            <h3 class="font-bold">{{ $s->nama_supplier }}</h3>
                            <p class="text-xs text-gray-500">NIB: {{ $s->nib }}</p>
                        </div>
                    </div>
                    <span class="px-3 py-1 {{ $s->kategori->nama_kategori == 'Medis' ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700' }} text-xs rounded-full">
                        {{ $s->kategori->nama_kategori }}
                    </span>
                </div>

                <div class="space-y-2 mb-4">
                    <div class="flex gap-2">
                        <div class="w-9 h-9 bg-orange-50 rounded-lg flex items-center justify-center">
                            <span>📦</span>
                        </div>
                        <div class="flex-1">
                            <p class="text-xs text-gray-500">Jenis Barang</p>
                            <p class="text-sm font-semibold">{{ $s->jenisBarang->nama_jenis }}</p>
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <div class="w-9 h-9 bg-pink-50 rounded-lg flex items-center justify-center">
                            <span>📍</span>
                        </div>
                        <div class="flex-1">
                            <p class="text-xs text-gray-500">Alamat</p>
                            <p class="text-sm font-semibold truncate">{{ $s->alamat }}</p>
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <div class="w-9 h-9 bg-blue-50 rounded-lg flex items-center justify-center">
                            <span>📞</span>
                        </div>
                        <div class="flex-1">
                            <p class="text-xs text-gray-500">Kontak</p>
                            <p class="text-sm font-semibold">{{ $s->kontak }}</p>
                        </div>
                    </div>
                </div>

                <div class="flex gap-2 pt-3 border-t">
                    <a href="{{ route('admin.suppliers.show', $s) }}" class="flex-1 bg-blue-600 text-white text-center px-3 py-2 rounded-lg text-sm">Detail</a>
                    <a href="{{ route('admin.suppliers.edit', $s) }}" class="flex-1 bg-green-600 text-white text-center px-3 py-2 rounded-lg text-sm">Edit</a>
                    <form action="{{ route('admin.suppliers.destroy', $s) }}" method="POST" onsubmit="return confirm('Hapus?')" class="flex-1">
                        @csrf
                        @method('DELETE')
                        <button class="w-full bg-red-600 text-white px-3 py-2 rounded-lg text-sm">Hapus</button>
                    </form>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-12 bg-white rounded-lg">
                <span class="text-6xl">📦</span>
                <p class="text-lg mt-4">Belum ada supplier</p>
            </div>
            @endforelse
        </div>

        <div class="mt-6">{{ $suppliers->links() }}</div>
@endsection

