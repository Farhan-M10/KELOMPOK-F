<?php
// File: app/Http/Controllers/Admin/DashboardController.php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Supplier;
use App\Models\Kategori;
use App\Models\Pengadaan;
use App\Models\BatchBarang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik Utama
        $totalStokBarang = Barang::sum('total_stok');
        $barangKadaluarsa = BatchBarang::where('tanggal_kadaluarsa', '<', now())->count();
        $pengadaanPending = Pengadaan::where('status', 'Menunggu')->count();
        $totalPemasok = Supplier::where('status', 'aktif')->count();

        // Persentase perubahan (contoh: bandingkan dengan bulan lalu)
        $totalStokBulanLalu = Barang::whereMonth('updated_at', Carbon::now()->subMonth()->month)->sum('total_stok');
        $persentaseStok = $totalStokBulanLalu > 0 ? (($totalStokBarang - $totalStokBulanLalu) / $totalStokBulanLalu) * 100 : 0;

        // Data Pengadaan 6 Bulan Terakhir untuk Chart
        $pengadaanChart = Pengadaan::selectRaw('MONTH(tanggal) as bulan, COUNT(*) as jumlah')
            ->where('tanggal', '>=', Carbon::now()->subMonths(6))
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        // Distribusi Stok Berdasarkan Kategori untuk Pie Chart
        $distribusiKategori = Kategori::withCount(['barangs as total_stok' => function($query) {
            $query->select(DB::raw('SUM(total_stok)'));
        }])->get();

        // Pemasok Teratas (berdasarkan jumlah pengadaan) - FIXED
        $pemasokTeratas = Supplier::select('suppliers.id', 'suppliers.nama_supplier')
            ->leftJoin('pengadaan_stok', 'suppliers.id', '=', 'pengadaan_stok.suppliers_id')
            ->selectRaw('COUNT(pengadaan_stok.id) as pengadaans_count')
            ->selectRaw('COALESCE(SUM(pengadaan_stok.total_harga), 0) as total_nilai')
            ->where('suppliers.status', 'aktif')
            ->groupBy('suppliers.id', 'suppliers.nama_supplier')
            ->orderByDesc('pengadaans_count')
            ->limit(4)
            ->get();

        // Aktivitas & Peringatan
        $aktivitas = [];

        // Kadaluarsa
        $barangKadaluarsaList = BatchBarang::with('barang')
            ->where('tanggal_kadaluarsa', '<', now())
            ->where('jumlah', '>', 0)
            ->latest('tanggal_kadaluarsa')
            ->limit(2)
            ->get();

        foreach ($barangKadaluarsaList as $batch) {
            $aktivitas[] = [
                'type' => 'kadaluarsa',
                'icon' => 'fa-calendar-times',
                'color' => 'danger',
                'title' => 'Kadaluarsa',
                'message' => "{$batch->barang->nama_barang} telah kadaluarsa",
                'detail' => "Batch {$batch->nomor_batch} kadaluarsa pada {$batch->tanggal_kadaluarsa->format('d-m-Y')}",
                'time' => $batch->tanggal_kadaluarsa->diffForHumans(),
                'timestamp' => $batch->tanggal_kadaluarsa->timestamp
            ];
        }

        // Stok Habis
        $stokHabis = Barang::where('total_stok', '<=', DB::raw('stok_minimum'))
            ->latest()
            ->limit(2)
            ->get();

        foreach ($stokHabis as $barang) {
            $aktivitas[] = [
                'type' => 'stok_habis',
                'icon' => 'fa-exclamation-triangle',
                'color' => 'danger',
                'title' => 'Stok Habis',
                'message' => "{$barang->nama_barang} Stok Kritis",
                'detail' => "Stok tersisa {$barang->total_stok} {$barang->satuan}, di bawah minimum {$barang->stok_minimum}",
                'time' => $barang->updated_at->diffForHumans(),
                'timestamp' => $barang->updated_at->timestamp
            ];
        }

        // Pengadaan Menunggu
        $pengadaanMenunggu = Pengadaan::with('supplier')
            ->where('status', 'Menunggu')
            ->whereDate('tanggal', '>=', Carbon::now()->subDays(7))
            ->latest()
            ->limit(2)
            ->get();

        foreach ($pengadaanMenunggu as $pengadaan) {
            $aktivitas[] = [
                'type' => 'pengadaan',
                'icon' => 'fa-shopping-cart',
                'color' => 'warning',
                'title' => 'Pengadaan',
                'message' => "{$pengadaan->id_pengadaan} menunggu persetujuan",
                'detail' => "Pengadaan dari {$pengadaan->supplier->nama_supplier} senilai Rp " . number_format($pengadaan->total_harga, 0, ',', '.'),
                'time' => $pengadaan->tanggal->diffForHumans(),
                'timestamp' => $pengadaan->tanggal->timestamp
            ];
        }

        // Pengadaan Disetujui
        $pengadaanDisetujui = Pengadaan::with('supplier')
            ->where('status', 'Disetujui')
            ->whereDate('updated_at', '>=', Carbon::now()->subDays(7))
            ->latest()
            ->limit(2)
            ->get();

        foreach ($pengadaanDisetujui as $pengadaan) {
            $aktivitas[] = [
                'type' => 'sukses',
                'icon' => 'fa-check-circle',
                'color' => 'success',
                'title' => 'Sukses',
                'message' => "Pengadaan {$pengadaan->id_pengadaan} disetujui",
                'detail' => "Stok dari {$pengadaan->supplier->nama_supplier} telah disetujui",
                'time' => $pengadaan->updated_at->diffForHumans(),
                'timestamp' => $pengadaan->updated_at->timestamp
            ];
        }

        // Kadaluarsa Mendekati (dalam 30 hari)
        $mendekatiKadaluarsa = BatchBarang::with('barang')
            ->whereBetween('tanggal_kadaluarsa', [now(), now()->addDays(30)])
            ->where('jumlah', '>', 0)
            ->latest()
            ->limit(1)
            ->get();

        foreach ($mendekatiKadaluarsa as $batch) {
            $aktivitas[] = [
                'type' => 'kadaluarsa_soon',
                'icon' => 'fa-file-alt',
                'color' => 'warning',
                'title' => 'Kadaluarsa',
                'message' => "Stok Cepat Diperiksa mendekati expired",
                'detail' => "{$batch->barang->nama_barang} akan kadaluarsa dalam {$batch->tanggal_kadaluarsa->diffInDays()} hari",
                'time' => $batch->created_at->diffForHumans(),
                'timestamp' => $batch->created_at->timestamp
            ];
        }

        // Sort aktivitas berdasarkan timestamp terbaru
        usort($aktivitas, function($a, $b) {
            return $b['timestamp'] - $a['timestamp'];
        });

        // Ambil hanya 5 aktivitas terbaru
        $aktivitas = array_slice($aktivitas, 0, 5);

        return view('admin.dashboard.index', compact(
            'totalStokBarang',
            'barangKadaluarsa',
            'pengadaanPending',
            'totalPemasok',
            'persentaseStok',
            'pengadaanChart',
            'distribusiKategori',
            'pemasokTeratas',
            'aktivitas'
        ));
    }
}
