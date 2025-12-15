<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Models\JenisBarang;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index(Request $request)
    {
        $query = Supplier::with(['jenisBarang.kategori']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_supplier', 'like', "%{$search}%")
                  ->orWhere('nib', 'like', "%{$search}%")
                  ->orWhere('kontak', 'like', "%{$search}%")
                  ->orWhere('alamat', 'like', "%{$search}%");
            });
        }

        if ($request->filled('jenis_barang_id')) {
            $query->where('jenis_barang_id', $request->jenis_barang_id);
        }

        $suppliers = $query->latest()->paginate(10);
        $jenisBarangs = JenisBarang::with('kategori')->get();

        return view('admin.suppliers.index', compact('suppliers', 'jenisBarangs'));
    }

    public function create()
    {
        $jenisBarangs = JenisBarang::with('kategori')->get();
        return view('admin.suppliers.create', compact('jenisBarangs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_supplier' => 'required|string|max:255',
            'nib' => 'required|string|unique:suppliers,nib',
            'jenis_barang_id' => 'required|exists:jenis_barangs,id',
            'alamat' => 'required|string',
            'kontak' => 'required|string|max:20',
            'status' => 'required|in:aktif,tidak_aktif'
        ]);

        Supplier::create($request->all());

        return redirect()->route('suppliers.index')
            ->with('success', 'Supplier berhasil ditambahkan');
    }

    public function show(Supplier $supplier)
    {
        $supplier->load(['jenisBarang.kategori']);
        return view('admin.suppliers.show', compact('supplier'));
    }

    public function edit(Supplier $supplier)
    {
        $jenisBarangs = JenisBarang::with('kategori')->get();
        return view('admin.suppliers.edit', compact('supplier', 'jenisBarangs'));
    }

    public function update(Request $request, Supplier $supplier)
    {
        $request->validate([
            'nama_supplier' => 'required|string|max:255',
            'nib' => 'required|string|unique:suppliers,nib,' . $supplier->id,
            'jenis_barang_id' => 'required|exists:jenis_barangs,id',
            'alamat' => 'required|string',
            'kontak' => 'required|string|max:20',
            'status' => 'required|in:aktif,tidak_aktif'
        ]);

        $supplier->update($request->all());

        return redirect()->route('admin.suppliers.index')
            ->with('success', 'Supplier berhasil diupdate');
    }

    public function destroy(Supplier $supplier)
    {
        $supplier->delete();
        return redirect()->route('suppliers.index')
            ->with('success', 'Supplier berhasil dihapus');
    }
}
