<?php
// File: app/Http/Controllers/BarangController.php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BatchBarang;
use App\Models\Kategori;
use App\Models\JenisBarang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BarangController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = Barang::with(['batchBarangs', 'kategori', 'jenisBarang']);

            $jenisTab = $request->get('jenis_tab', 'medis');

            $query->whereHas('kategori', function($q) use ($jenisTab) {
                $q->where('jenis', $jenisTab);
            });

            if ($request->has('kategori_id') && $request->kategori_id != '') {
                $query->where('kategori_id', $request->kategori_id);
            }

            if ($request->has('lokasi') && $request->lokasi != '') {
                $query->where('lokasi', $request->lokasi);
            }

            if ($request->has('status') && $request->status != '') {
                $query->whereHas('batchBarangs', function($q) use ($request) {
                    $q->where('status', $request->status);
                });
            }

            if ($request->has('search') && $request->search != '') {
                $query->where('nama_barang', 'like', '%' . $request->search . '%');
            }

            $barangs = $query->paginate(10);
            $kategoris = Kategori::all();
            $jenisBarangs = JenisBarang::all();

            return view('admin.stok_barang.index', compact('barangs', 'kategoris', 'jenisBarangs'));

        } catch (\Exception $e) {
            Log::error('Error di BarangController index: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function create()
    {
        $kategoris = Kategori::all();
        $jenisBarangs = JenisBarang::all();
        return view('admin.stok_barang.create', compact('kategoris', 'jenisBarangs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategoris,id',
            'jenis_barang_id' => 'required|exists:jenis_barangs,id',
            'lokasi' => 'required|string|max:255',
            'ruangan' => 'required|string|max:255',
            'satuan' => 'required|string|max:50',
            'stok_minimum' => 'nullable|integer|min:0',
            'deskripsi' => 'nullable|string',
            'batches' => 'required|array|min:1',
            'batches.*.nomor_batch' => 'required|string|max:255',
            'batches.*.jumlah' => 'required|integer|min:1',
            'batches.*.tanggal_masuk' => 'required|date',
            'batches.*.tanggal_kadaluarsa' => 'required|date|after:batches.*.tanggal_masuk'
        ]);

        DB::beginTransaction();
        try {
            $barang = Barang::create([
                'nama_barang' => $request->nama_barang,
                'kategori_id' => $request->kategori_id,
                'jenis_barang_id' => $request->jenis_barang_id,
                'lokasi' => $request->lokasi,
                'ruangan' => $request->ruangan,
                'satuan' => $request->satuan,
                'stok_minimum' => $request->stok_minimum ?? 10,
                'deskripsi' => $request->deskripsi,
                'total_stok' => 0
            ]);

            $totalStok = 0;
            foreach ($request->batches as $batchData) {
                $batch = BatchBarang::create([
                    'barang_id' => $barang->id,
                    'nomor_batch' => $batchData['nomor_batch'],
                    'tanggal_masuk' => $batchData['tanggal_masuk'],
                    'tanggal_kadaluarsa' => $batchData['tanggal_kadaluarsa'],
                    'jumlah' => $batchData['jumlah']
                ]);

                $batch->updateStatus();
                $totalStok += $batchData['jumlah'];
            }

            $barang->total_stok = $totalStok;
            $barang->save();

            DB::commit();

            return redirect()->route('admin.stok_barang.index')
                ->with('success', 'Barang berhasil ditambahkan dengan ' . count($request->batches) . ' batch');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $barang = Barang::with('batchBarangs')->findOrFail($id);
        $kategoris = Kategori::all();
        $jenisBarangs = JenisBarang::all();
        // PERBAIKAN: Tambah titik antara admin dan stok_barang
        return view('admin.stok_barang.edit', compact('barang', 'kategoris', 'jenisBarangs'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategoris,id',
            'jenis_barang_id' => 'required|exists:jenis_barangs,id',
            'lokasi' => 'required|string|max:255',
            'ruangan' => 'required|string|max:255',
            'satuan' => 'required|string|max:50',
            'stok_minimum' => 'nullable|integer|min:0',
            'deskripsi' => 'nullable|string'
        ]);

        $barang = Barang::findOrFail($id);
        $barang->update($request->all());

        // PERBAIKAN: Ganti route ke admin.stok_barang.index
        return redirect()->route('admin.stok_barang.index')
            ->with('success', 'Barang berhasil diupdate');
    }

    public function destroy($id)
    {
        try {
            $barang = Barang::findOrFail($id);
            $barang->delete();

            // PERBAIKAN: Ganti route ke admin.stok_barang.index
            return redirect()->route('admin.stok_barang.index')
                ->with('success', 'Barang berhasil dihapus');
        } catch (\Exception $e) {
            // PERBAIKAN: Ganti route ke admin.stok_barang.index
            return redirect()->route('admin.stok_barang.index')
                ->with('error', 'Gagal menghapus barang: ' . $e->getMessage());
        }
    }

    public function addBatch(Request $request, $id)
    {
        $request->validate([
            'nomor_batch' => 'required|string|max:255',
            'tanggal_masuk' => 'required|date',
            'tanggal_kadaluarsa' => 'required|date|after:tanggal_masuk',
            'jumlah' => 'required|integer|min:1'
        ]);

        DB::beginTransaction();
        try {
            $barang = Barang::findOrFail($id);

            $batch = BatchBarang::create([
                'barang_id' => $barang->id,
                'nomor_batch' => $request->nomor_batch,
                'tanggal_masuk' => $request->tanggal_masuk,
                'tanggal_kadaluarsa' => $request->tanggal_kadaluarsa,
                'jumlah' => $request->jumlah
            ]);

            $batch->updateStatus();
            $barang->total_stok = $barang->hitungTotalStok();
            $barang->save();

            DB::commit();

            return redirect()->route('admin.stok_barang.index')
                ->with('success', 'Batch berhasil ditambahkan');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->with('error', 'Gagal menambahkan batch: ' . $e->getMessage());
        }
    }

    public function export()
    {
        return redirect()->back()
            ->with('info', 'Fitur export dalam pengembangan');
    }
}
