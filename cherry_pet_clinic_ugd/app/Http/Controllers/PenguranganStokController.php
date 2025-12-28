<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BatchBarang;
use App\Models\PenguranganStok;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PenguranganStokController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->get('tab', 'medis');

        // Ambil semua kategori berdasarkan jenis
        $kategoris = Kategori::where('jenis', $tab)->orderBy('nama_kategori')->get();

        // Ambil lokasi unik
        $lokasis = Barang::select('lokasi')
            ->distinct()
            ->whereNotNull('lokasi')
            ->where('lokasi', '!=', '')
            ->orderBy('lokasi')
            ->pluck('lokasi');

        // Query barang - LEBIH FLEKSIBEL
        $query = Barang::with(['batchBarangs' => function($q) {
                $q->where('jumlah', '>', 0)->orderBy('tanggal_kadaluarsa', 'asc');
            }, 'kategori']);

        // Filter berdasarkan tab (medis/non-medis)
        if ($tab) {
            $query->whereHas('kategori', function($q) use ($tab) {
                $q->where('jenis', $tab);
            });
        }

        // Filter kategori (jika dipilih)
        if ($request->filled('kategori_id')) {
            $query->where('kategori_id', $request->kategori_id);
        }

        // Filter lokasi (jika dipilih)
        if ($request->filled('lokasi')) {
            $query->where('lokasi', $request->lokasi);
        }

        // Search (jika ada)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('nama_barang', 'like', '%' . $search . '%');
        }

        // Filter status stok (jika dipilih)
        if ($request->filled('status')) {
            $status = $request->status;
            if ($status === 'Stok Aman') {
                $query->whereRaw('total_stok > (stok_minimum * 2)');
            } elseif ($status === 'Perhatian') {
                $query->whereRaw('total_stok <= (stok_minimum * 2)')
                      ->whereRaw('total_stok > stok_minimum');
            } elseif ($status === 'Kritis') {
                $query->whereRaw('total_stok <= stok_minimum');
            }
        }

        $barangs = $query->orderBy('nama_barang')->get();

        return view('staff.pengurangan_stok.index', compact('barangs', 'kategoris', 'lokasis', 'tab'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'batch_barang_id' => 'required|exists:batch_barangs,id',
            'jumlah_pengurangan' => 'required|integer|min:1',
            'alasan' => 'required|string',
            'keterangan' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $batch = BatchBarang::with('barang')->findOrFail($request->batch_barang_id);

            if ($batch->jumlah < $request->jumlah_pengurangan) {
                return response()->json([
                    'success' => false,
                    'message' => 'Stok tidak mencukupi! Stok tersedia: ' . $batch->jumlah
                ], 400);
            }

            PenguranganStok::create([
                'batch_barang_id' => $request->batch_barang_id,
                'user_id' => Auth::id(),
                'jumlah_pengurangan' => $request->jumlah_pengurangan,
                'alasan' => $request->alasan,
                'keterangan' => $request->keterangan,
                'tanggal_pengurangan' => now(),
            ]);

            // Kurangi stok batch
            $batch->jumlah -= $request->jumlah_pengurangan;
            $batch->save();

            // Update total stok barang
            $barang = $batch->barang;
            $barang->total_stok -= $request->jumlah_pengurangan;
            $barang->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Pengurangan stok berhasil dicatat!'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}
