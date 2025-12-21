<?php
// app/Http/Controllers/PengadaanController.php

namespace App\Http\Controllers;

use App\Models\Pengadaan;
use App\Models\DetailPengadaan;
use App\Models\Barang;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PengadaanController extends Controller
{
    public function index(Request $request)
    {
        $query = Pengadaan::with(['supplier']);

        if ($request->has('search')) {
            $search = $request->search;
            $query->where('id_pengadaan', 'like', "%{$search}%")
                  ->orWhereHas('supplier', function($q) use ($search) {
                      $q->where('nama_supplier', 'like', "%{$search}%");
                  });
        }

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $pengadaanStok = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.pengadaan.index', compact('pengadaanStok'));
    }

    public function create()
    {
        $idPengadaan = Pengadaan::generateIdPengadaan();
        $suppliers = Supplier::all();
        $barangs = Barang::all();
        
        return view('admin.pengadaan.create', compact('idPengadaan', 'suppliers', 'barangs'));
    }

    public function store(Request $request)
    {
        Log::info('Store Pengadaan - Request Data:', $request->all());

        try {
            $validated = $request->validate([
                'supplier_id' => 'required|exists:suppliers,id',
                'tanggal' => 'required|date',
                'barang_id' => 'required|array',
                'barang_id.*' => 'required|exists:barangs,id',
                'jumlah_pesan' => 'required|array',
                'jumlah_pesan.*' => 'required|integer|min:1',
                'harga_satuan' => 'required|array',
                'harga_satuan.*' => 'required|numeric|min:0',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation Error:', $e->errors());
            return back()->withErrors($e->errors())->withInput();
        }

        DB::beginTransaction();
        try {
            // Buat pengadaan
            $pengadaan = Pengadaan::create([
                'id_pengadaan' => Pengadaan::generateIdPengadaan(),
                'tanggal' => $request->tanggal,
                'suppliers_id' => $request->supplier_id,
                'total_harga' => 0,
                'status' => 'Menunggu',
            ]);

            Log::info('Pengadaan created:', ['id' => $pengadaan->id, 'id_pengadaan' => $pengadaan->id_pengadaan]);

            // Simpan detail
            $totalHarga = 0;
            foreach ($request->barang_id as $index => $barangId) {
                $jumlah = $request->jumlah_pesan[$index];
                $harga = $request->harga_satuan[$index];
                $subtotal = $jumlah * $harga;
                $totalHarga += $subtotal;

                DetailPengadaan::create([
                    'pengadaan_stok_id' => $pengadaan->id, // Pakai id (auto increment)
                    'barangs_id' => $barangId,
                    'jumlah_pesan' => $jumlah,
                    'harga_satuan' => $harga,
                    'subtotal' => $subtotal,
                ]);

                Log::info("Detail item {$index} saved");
            }

            // Update total harga
            $pengadaan->update(['total_harga' => $totalHarga]);

            DB::commit();
            
            Log::info('Pengadaan saved successfully');
            
            return redirect()->route('pengadaan.index')
                ->with('success', 'Pengadaan stok berhasil ditambahkan');
                
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error saving pengadaan: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $pengadaan = Pengadaan::with(['details.barang', 'supplier'])->findOrFail($id);
        return view('admin.pengadaan.show', compact('pengadaan'));
    }

    public function edit($id)
    {
        $pengadaan = Pengadaan::with(['details.barang', 'supplier'])->findOrFail($id);
        
        if ($pengadaan->status != 'Menunggu') {
            return back()->with('error', 'Hanya pengadaan dengan status Menunggu yang dapat diedit');
        }

        $suppliers = Supplier::all();
        $barangs = Barang::all();

        return view('admin.pengadaan.edit', compact('pengadaan', 'suppliers', 'barangs'));
    }

    public function update(Request $request, $id)
    {
        Log::info('Update Pengadaan - Request Data:', $request->all());

        try {
            $validated = $request->validate([
                'supplier_id' => 'required|exists:suppliers,id',
                'tanggal' => 'required|date',
                'barang_id' => 'required|array',
                'barang_id.*' => 'required|exists:barangs,id',
                'jumlah_pesan' => 'required|array',
                'jumlah_pesan.*' => 'required|integer|min:1',
                'harga_satuan' => 'required|array',
                'harga_satuan.*' => 'required|numeric|min:0',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation Error:', $e->errors());
            return back()->withErrors($e->errors())->withInput();
        }

        $pengadaan = Pengadaan::findOrFail($id);

        if ($pengadaan->status != 'Menunggu') {
            return back()->with('error', 'Hanya pengadaan dengan status Menunggu yang dapat diedit');
        }

        DB::beginTransaction();
        try {
            $pengadaan->update([
                'tanggal' => $request->tanggal,
                'suppliers_id' => $request->supplier_id,
            ]);

            // Hapus detail lama
            $pengadaan->details()->delete();

            // Simpan detail baru
            $totalHarga = 0;
            foreach ($request->barang_id as $index => $barangId) {
                $jumlah = $request->jumlah_pesan[$index];
                $harga = $request->harga_satuan[$index];
                $subtotal = $jumlah * $harga;
                $totalHarga += $subtotal;

                DetailPengadaan::create([
                    'pengadaan_stok_id' => $pengadaan->id, // Pakai id (auto increment)
                    'barangs_id' => $barangId,
                    'jumlah_pesan' => $jumlah,
                    'harga_satuan' => $harga,
                    'subtotal' => $subtotal,
                ]);
            }

            $pengadaan->update(['total_harga' => $totalHarga]);

            DB::commit();
            
            return redirect()->route('pengadaan.index')
                ->with('success', 'Pengadaan stok berhasil diperbarui');
                
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating pengadaan: ' . $e->getMessage());
            
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $pengadaan = Pengadaan::findOrFail($id);
        
        if ($pengadaan->status == 'Disetujui') {
            return back()->with('error', 'Pengadaan yang sudah disetujui tidak dapat dihapus');
        }

        try {
            $pengadaan->delete();
            return redirect()->route('pengadaan.index')
                ->with('success', 'Pengadaan stok berhasil dihapus');
        } catch (\Exception $e) {
            Log::error('Error deleting pengadaan: ' . $e->getMessage());
            return back()->with('error', 'Gagal menghapus pengadaan: ' . $e->getMessage());
        }
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Disetujui,Menunggu,Ditolak',
        ]);

        try {
            $pengadaan = Pengadaan::findOrFail($id);
            $pengadaan->update(['status' => $request->status]);

            return back()->with('success', 'Status pengadaan berhasil diperbarui');
        } catch (\Exception $e) {
            Log::error('Error updating status: ' . $e->getMessage());
            return back()->with('error', 'Gagal update status: ' . $e->getMessage());
        }
    }

    // Method untuk AJAX - get harga barang
    public function getHargaBarang($id)
    {
        try {
            $barang = Barang::findOrFail($id);
            return response()->json([
                'success' => true,
                'harga_beli' => $barang->harga_beli,
                'satuan' => $barang->satuan
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Barang tidak ditemukan'
            ], 404);
        }
    }
}