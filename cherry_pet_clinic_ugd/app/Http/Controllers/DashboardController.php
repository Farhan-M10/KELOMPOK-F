<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Supplier;
use App\Models\Pengadaan;
use App\Models\BatchBarang;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Total Stok Barang (dari total_stok di tabel barangs)
        $totalStokBarang = Barang::sum('total_stok');

        // Hitung persentase perubahan dari bulan lalu
        $bulanIni = Barang::whereMonth('updated_at', Carbon::now()->month)
                          ->whereYear('updated_at', Carbon::now()->year)
                          ->sum('total_stok');

        $bulanLalu = Barang::whereMonth('updated_at', Carbon::now()->subMonth()->month)
                           ->whereYear('updated_at', Carbon::now()->subMonth()->year)
                           ->sum('total_stok');

        $persentaseStok = $bulanLalu > 0
            ? (($bulanIni - $bulanLalu) / $bulanLalu) * 100
            : 0;

        // 2. Barang Kadaluarsa (dari batch_barangs yang sudah expired)
        $barangKadaluarsa = BatchBarang::where('tanggal_kadaluarsa', '<', Carbon::now())
                                       ->where('jumlah', '>', 0)
                                       ->count();

        // 3. Pengadaan Pending (status pending atau diproses)
        $pengadaanPending = Pengadaan::whereIn('status', ['pending', 'diproses'])
                                     ->count();

        // 4. Total Pemasok Aktif
        $totalPemasok = Supplier::where('status', 'aktif')->count();

        // 5. Data Chart Pengadaan (6 bulan terakhir)
        $pengadaanChart = Pengadaan::select(
                DB::raw('MONTH(tanggal) as bulan'),
                DB::raw('COUNT(*) as jumlah')
            )
            ->where('tanggal', '>=', Carbon::now()->subMonths(6))
            ->groupBy('bulan')
            ->orderBy('bulan', 'asc')
            ->get();

        // 6. Distribusi Stok Berdasarkan Kategori
        $distribusiKategori = Kategori::select(
                'kategoris.id',
                'kategoris.nama_kategori',
                DB::raw('SUM(barangs.total_stok) as total_stok')
            )
            ->join('barangs', 'kategoris.id', '=', 'barangs.kategori_id')
            ->groupBy('kategoris.id', 'kategoris.nama_kategori')
            ->having('total_stok', '>', 0)
            ->get();

        // 7. Pemasok Teratas (berdasarkan jumlah pengadaan dan total nilai)
        $pemasokTeratas = Supplier::select(
                'suppliers.*',
                DB::raw('COUNT(pengadaan_stok.id) as pengadaans_count'),
                DB::raw('COALESCE(SUM(pengadaan_stok.total_harga), 0) as total_nilai')
            )
            ->leftJoin('pengadaan_stok', 'suppliers.id', '=', 'pengadaan_stok.suppliers_id')
            ->where('suppliers.status', 'aktif')
            ->groupBy(
                'suppliers.id',
                'suppliers.nama_supplier',
                'suppliers.nib',
                'suppliers.jenis_barang_id',
                'suppliers.alamat',
                'suppliers.kontak',
                'suppliers.status',
                'suppliers.created_at',
                'suppliers.updated_at',
                'suppliers.deleted_at'
            )
            ->orderBy('pengadaans_count', 'desc')
            ->limit(5)
            ->get();

        // 8. Aktivitas & Peringatan
        $aktivitas = [];

        // Cek batch barang yang sudah kadaluarsa
        $batchExpired = BatchBarang::with('barang')
            ->where('tanggal_kadaluarsa', '<', Carbon::now())
            ->where('jumlah', '>', 0)
            ->latest('tanggal_kadaluarsa')
            ->limit(3)
            ->get();

        foreach ($batchExpired as $batch) {
            $aktivitas[] = [
                'type' => 'kadaluarsa',
                'color' => 'danger',
                'icon' => 'fa-exclamation-triangle',
                'title' => 'Barang Kadaluarsa',
                'message' => $batch->barang->nama_barang ?? 'Barang',
                'detail' => 'Batch: ' . $batch->kode_batch . ' - Kadaluarsa sejak ' . Carbon::parse($batch->tanggal_kadaluarsa)->format('d M Y'),
                'time' => Carbon::parse($batch->tanggal_kadaluarsa)->diffForHumans()
            ];
        }

        // Cek batch yang akan kadaluarsa dalam 30 hari
        $batchAkanExpired = BatchBarang::with('barang')
            ->whereBetween('tanggal_kadaluarsa', [
                Carbon::now(),
                Carbon::now()->addDays(30)
            ])
            ->where('jumlah', '>', 0)
            ->latest('tanggal_kadaluarsa')
            ->limit(2)
            ->get();

        foreach ($batchAkanExpired as $batch) {
            $hariLagi = Carbon::now()->diffInDays(Carbon::parse($batch->tanggal_kadaluarsa));
            $aktivitas[] = [
                'type' => 'kadaluarsa_soon',
                'color' => 'warning',
                'icon' => 'fa-clock',
                'title' => 'Segera Kadaluarsa',
                'message' => $batch->barang->nama_barang ?? 'Barang',
                'detail' => 'Batch: ' . $batch->kode_batch . ' - Kadaluarsa dalam ' . $hariLagi . ' hari (' . Carbon::parse($batch->tanggal_kadaluarsa)->format('d M Y') . ')',
                'time' => Carbon::parse($batch->tanggal_kadaluarsa)->diffForHumans()
            ];
        }

        // Cek stok yang rendah (di bawah stok minimum)
        $stokRendah = Barang::where('total_stok', '<', DB::raw('stok_minimum'))
            ->where('total_stok', '>', 0)
            ->latest('updated_at')
            ->limit(3)
            ->get();

        foreach ($stokRendah as $barang) {
            $selisih = $barang->stok_minimum - $barang->total_stok;
            $aktivitas[] = [
                'type' => 'stok_habis',
                'color' => 'danger',
                'icon' => 'fa-box-open',
                'title' => 'Stok Menipis',
                'message' => $barang->nama_barang,
                'detail' => 'Stok: ' . $barang->total_stok . ' ' . $barang->satuan . ' (Min: ' . $barang->stok_minimum . ') - Kurang ' . $selisih . ' ' . $barang->satuan,
                'time' => $barang->updated_at->diffForHumans()
            ];
        }

        // Cek pengadaan pending
        $pengadaanPendingList = Pengadaan::with('supplier')
            ->whereIn('status', ['pending', 'diproses'])
            ->latest('tanggal')
            ->limit(2)
            ->get();

        foreach ($pengadaanPendingList as $pengadaan) {
            $statusText = $pengadaan->status == 'pending' ? 'Menunggu Persetujuan' : 'Sedang Diproses';
            $aktivitas[] = [
                'type' => 'pengadaan',
                'color' => 'warning',
                'icon' => 'fa-shopping-cart',
                'title' => 'Pengadaan Pending',
                'message' => $pengadaan->id_pengadaan . ' dari ' . ($pengadaan->supplier->nama_supplier ?? 'Supplier'),
                'detail' => 'Status: ' . $statusText . ' - Total: Rp ' . number_format($pengadaan->total_harga, 0, ',', '.'),
                'time' => $pengadaan->created_at->diffForHumans()
            ];
        }

        // Cek pengadaan sukses terbaru (selesai)
        $pengadaanSukses = Pengadaan::with('supplier')
            ->where('status', 'selesai')
            ->latest('updated_at')
            ->limit(1)
            ->get();

        foreach ($pengadaanSukses as $pengadaan) {
            $aktivitas[] = [
                'type' => 'sukses',
                'color' => 'success',
                'icon' => 'fa-check-circle',
                'title' => 'Pengadaan Selesai',
                'message' => $pengadaan->id_pengadaan . ' dari ' . ($pengadaan->supplier->nama_supplier ?? 'Supplier'),
                'detail' => 'Pengadaan berhasil diselesaikan pada ' . Carbon::parse($pengadaan->updated_at)->format('d M Y') . ' - Total: Rp ' . number_format($pengadaan->total_harga, 0, ',', '.'),
                'time' => $pengadaan->updated_at->diffForHumans()
            ];
        }

        // Urutkan aktivitas berdasarkan created_at terbaru
        usort($aktivitas, function($a, $b) {
            // Bandingkan berdasarkan string waktu relatif
            // Karena sudah ada diffForHumans, kita pakai index array saja
            return 0; // Tetap gunakan urutan yang sudah dibuat
        });

        // Batasi hanya 8 aktivitas teratas
        $aktivitas = array_slice($aktivitas, 0, 8);

        return view('admin.dashboard.index', compact(
            'totalStokBarang',
            'persentaseStok',
            'barangKadaluarsa',
            'pengadaanPending',
            'totalPemasok',
            'pengadaanChart',
            'distribusiKategori',
            'pemasokTeratas',
            'aktivitas'
        ));
    }
}
