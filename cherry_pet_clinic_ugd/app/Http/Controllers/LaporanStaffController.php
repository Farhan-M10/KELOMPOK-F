<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PenguranganStok;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LaporanStaffController extends Controller
{
    /**
     * Display laporan pengurangan stok.
     */
    public function index(Request $request)
    {
        // Statistik
        $totalBarangKeluar = Barang::count();

        $barangKritisCount = Barang::whereRaw('total_stok <= stok_minimum')->count();

        $jumlahPenguranganTercatat = PenguranganStok::count();

        // Query laporan pengurangan stok
        $query = PenguranganStok::with(['batchBarang.barang.kategori', 'user'])
            ->orderBy('tanggal_pengurangan', 'desc');

        // Filter berdasarkan periode
        if ($request->filled('periode')) {
            $periode = $request->periode;
            $today = now();

            switch ($periode) {
                case 'Hari Ini':
                    $query->whereDate('tanggal_pengurangan', $today);
                    break;
                case 'Minggu Ini':
                    $query->whereBetween('tanggal_pengurangan', [
                        $today->startOfWeek(),
                        $today->copy()->endOfWeek()
                    ]);
                    break;
                case 'Bulan Ini':
                    $query->whereMonth('tanggal_pengurangan', $today->month)
                          ->whereYear('tanggal_pengurangan', $today->year);
                    break;
                case 'Tahun Ini':
                    $query->whereYear('tanggal_pengurangan', $today->year);
                    break;
            }
        }

        // Filter berdasarkan rentang tanggal
        if ($request->filled('dari_tanggal') && $request->filled('sampai_tanggal')) {
            $query->whereBetween('tanggal_pengurangan', [
                $request->dari_tanggal,
                $request->sampai_tanggal
            ]);
        }

        // Filter berdasarkan pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('batchBarang.barang', function($q) use ($search) {
                $q->where('nama_barang', 'like', '%' . $search . '%');
            });
        }

        $laporanPengurangan = $query->paginate(15);

        return view('staff.laporan.index', compact(
            'totalBarangKeluar',
            'barangKritisCount',
            'jumlahPenguranganTercatat',
            'laporanPengurangan'
        ));
    }

    /**
     * Display detail laporan pengurangan stok.
     */
    public function show($id)
    {
        $pengurangan = PenguranganStok::with(['batchBarang.barang.kategori', 'user'])
            ->findOrFail($id);

        return view('staff.laporan.show', compact('pengurangan'));
    }

    /**
     * Export laporan ke PDF.
     */
    public function exportPdf(Request $request)
    {
        // TODO: Implement PDF export
        return back()->with('info', 'Fitur export PDF sedang dalam pengembangan');
    }
}
