<?php

namespace App\Http\Controllers;

use App\Models\JenisBarang;
use App\Models\Kategori;
use Illuminate\Http\Request;

class JenisBarangController extends Controller
{
    public function index(Request $request)
    {
        $kategori_id = $request->get('kategori_id');

        $query = JenisBarang::with('kategori');

        if ($kategori_id) {
            $query->where('kategori_id', $kategori_id);
        }

        $jenisBarangs = $query->paginate(10);
        $kategoris = Kategori::all();

        return view('admin.jenis_barang.index', compact('jenisBarangs', 'kategoris', 'kategori_id'));
    }

    public function create()
    {
        $kategoris = Kategori::all();
        return view('admin.jenis_barang.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kategori_id' => 'required|exists:kategoris,id',
            'kode_jenis' => 'required|unique:jenis_barangs,kode_jenis|max:50',
            'nama_jenis' => 'required|max:100',
            'deskripsi' => 'nullable|string'
        ]);

        JenisBarang::create($validated);

        return redirect()->route('admin_jenis_barang.index')
            ->with('success', 'Jenis barang berhasil ditambahkan');
    }

    public function show(JenisBarang $jenisBarang)
    {
        $jenisBarang->load('kategori');
        return view('admin.jenis_barang.show', compact('jenisBarang'));
    }

    public function edit(JenisBarang $jenisBarang)
    {
        $kategoris = Kategori::all();
        return view('admin.jenis_barang.edit', compact('jenisBarang', 'kategoris'));
    }

    public function update(Request $request, JenisBarang $jenisBarang)
    {
        $validated = $request->validate([
            'kategori_id' => 'required|exists:kategoris,id',
            'kode_jenis' => 'required|max:50|unique:jenis_barangs,kode_jenis,' . $jenisBarang->id,
            'nama_jenis' => 'required|max:100',
            'deskripsi' => 'nullable|string'
        ]);

        $jenisBarang->update($validated);

        return redirect()->route('admin.jenis_barang.index')
            ->with('success', 'Jenis barang berhasil diperbarui');
    }

    public function destroy(JenisBarang $jenisBarang)
    {
        try {
            $jenisBarang->delete();
            return redirect()->route('admin.jenis_barang.index')
                ->with('success', 'Jenis barang berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->route('admin.jenis_barang.index')
                ->with('error', 'Jenis barang tidak dapat dihapus karena masih memiliki relasi dengan data lain');
        }
    }
}
