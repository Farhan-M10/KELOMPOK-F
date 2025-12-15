<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Supplier</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <div class="container mx-auto px-4 py-6 max-w-3xl">
        <div class="mb-6">
            <a href="{{ route('suppliers.index') }}" class="text-blue-600 flex items-center gap-2 mb-4">
                ← Kembali
            </a>
            <h1 class="text-2xl font-bold">Tambah Supplier Baru</h1>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-6">
            <form action="{{ route('suppliers.store') }}" method="POST">
                @csrf

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
                                    <option value="{{ $j->id }}" {{ old('jenis_barang_id') == $j->id ? 'selected' : '' }}>
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

                <div class="flex gap-3">
                    <button type="submit" class="flex-1 bg-blue-600 text-white px-6 py-3 rounded-lg">
                        Simpan
                    </button>
                    <a href="{{ route('suppliers.index') }}" class="flex-1 bg-gray-200 text-gray-800 px-6 py-3 rounded-lg text-center">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
