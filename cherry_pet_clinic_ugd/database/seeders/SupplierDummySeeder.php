<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Supplier;
use App\Models\JenisBarang;
use App\Models\Kategori;

class SupplierDummySeeder extends Seeder
{
    public function run(): void
    {
        // Ambil ID jenis barang
        $kategoriMedis = Kategori::firstOrCreate(['nama_kategori' => 'Medis']);
$kategoriNonMedis = Kategori::firstOrCreate(['nama_kategori' => 'Non Medis']);

// jenis barang + kategori_id
$obatHewan = JenisBarang::firstOrCreate(
    ['nama_jenis' => 'Obat Hewan'],
    ['kategori_id' => $kategoriMedis->id]
);

$vitamin = JenisBarang::firstOrCreate(
    ['nama_jenis' => 'Vitamin'],
    ['kategori_id' => $kategoriMedis->id]
);

$alatMedis = JenisBarang::firstOrCreate(
    ['nama_jenis' => 'Alat Medis'],
    ['kategori_id' => $kategoriMedis->id]
);

$pakan = JenisBarang::firstOrCreate(
    ['nama_jenis' => 'Pakan'],
    ['kategori_id' => $kategoriNonMedis->id]
);

$aksesoris = JenisBarang::firstOrCreate(
    ['nama_jenis' => 'Aksesoris'],
    ['kategori_id' => $kategoriNonMedis->id]
);

$lainnya = JenisBarang::firstOrCreate(
    ['nama_jenis' => 'Lainnya'],
    ['kategori_id' => $kategoriNonMedis->id]
);

        // ========================================
        // DATA DUMMY SUPPLIER MEDIS
        // ========================================

        $suppliersMedis = [
            // Obat Hewan
            [
                'nama_supplier' => 'PT. Sejahtera Medika',
                'nib' => '1276189024571',
                'jenis_barang_id' => $obatHewan->id,
                'alamat' => 'Jl. Kesehatan No.1, Jakarta',
                'kontak' => '081329891201',
                'status' => 'aktif',
            ],
            [
                'nama_supplier' => 'CV. Farmasi Jaya',
                'nib' => '8937809117289',
                'jenis_barang_id' => $obatHewan->id,
                'alamat' => 'Jl. Merdeka No.45, Surabaya',
                'kontak' => '087652389017',
                'status' => 'aktif',
            ],
            [
                'nama_supplier' => 'PT. Sehati Medika',
                'nib' => '9876321457098',
                'jenis_barang_id' => $obatHewan->id,
                'alamat' => 'Jl. Gatot Subroto No.99, Yogyakarta',
                'kontak' => '081380749985',
                'status' => 'aktif',
            ],
            [
                'nama_supplier' => 'CV. Mitra Sehat Veteriner',
                'nib' => '5521839064251',
                'jenis_barang_id' => $obatHewan->id,
                'alamat' => 'Jl. Candi Mas No.12, Yogyakarta',
                'kontak' => '081234567890',
                'status' => 'aktif',
            ],
            [
                'nama_supplier' => 'PT. Grooming Jaya',
                'nib' => '3002184511267',
                'jenis_barang_id' => $obatHewan->id,
                'alamat' => 'Jl. Pemuda No.12, Semarang',
                'kontak' => '081380740182',
                'status' => 'aktif',
            ],
            [
                'nama_supplier' => 'PT. Snack Pelitharam',
                'nib' => '4526891470382',
                'jenis_barang_id' => $obatHewan->id,
                'alamat' => 'Jl. Gatama No.3, Bandung',
                'kontak' => '082279180212',
                'status' => 'aktif',
            ],

            // Vitamin
            [
                'nama_supplier' => 'PT. Global Vet',
                'nib' => '7654321098765',
                'jenis_barang_id' => $vitamin->id,
                'alamat' => 'Jl. Pedurungan No.107, Semarang',
                'kontak' => '082457881559',
                'status' => 'aktif',
            ],
            [
                'nama_supplier' => 'UD. Sumber Sehat',
                'nib' => '1188452134527',
                'jenis_barang_id' => $vitamin->id,
                'alamat' => 'Jl. Kediri Rsyto No.8, Malang',
                'kontak' => '082456785539',
                'status' => 'aktif',
            ],
            [
                'nama_supplier' => 'UD. Sumber Sejati',
                'nib' => '1188431214457',
                'jenis_barang_id' => $vitamin->id,
                'alamat' => 'Jl. Diponegoro No.88, Medan',
                'kontak' => '088198781100',
                'status' => 'aktif',
            ],
            [
                'nama_supplier' => 'CV. Maju Jaya Medika',
                'nib' => '8962210612136',
                'jenis_barang_id' => $vitamin->id,
                'alamat' => 'Jl. Aria Wibu No.43, Bandung',
                'kontak' => '082457102138',
                'status' => 'aktif',
            ],
            [
                'nama_supplier' => 'CV. Pangan Satwa Lestari',
                'nib' => '7987653224109',
                'jenis_barang_id' => $vitamin->id,
                'alamat' => 'Jl. Melania No.4, Surabaya',
                'kontak' => '082182891955',
                'status' => 'aktif',
            ],
            [
                'nama_supplier' => 'CV. Makanan Haji Animal',
                'nib' => '8612954413886',
                'jenis_barang_id' => $vitamin->id,
                'alamat' => 'Jl. Gajah Mada No.22, Yogyakarta',
                'kontak' => '082385544435',
                'status' => 'aktif',
            ],

            // Alat Medis
            [
                'nama_supplier' => 'PT. Instrumen Bedah',
                'nib' => '3021847110296',
                'jenis_barang_id' => $alatMedis->id,
                'alamat' => 'Jl. Pemuda No.7, Surabaya',
                'kontak' => '081334422880',
                'status' => 'aktif',
            ],
            [
                'nama_supplier' => 'PT. Pharma Vet Indo',
                'nib' => '3121045120359',
                'jenis_barang_id' => $alatMedis->id,
                'alamat' => 'Jl. Sudirman No.5, Jakarta Selatan',
                'kontak' => '082349478215',
                'status' => 'aktif',
            ],
            [
                'nama_supplier' => 'PT. Indonesia Jaya',
                'nib' => '3002143511101',
                'jenis_barang_id' => $alatMedis->id,
                'alamat' => 'Jl. Jendral No.10, Tangerang',
                'kontak' => '089385544725',
                'status' => 'aktif',
            ],
            [
                'nama_supplier' => 'PT. Perawatan Sejati',
                'nib' => '5562223871096',
                'jenis_barang_id' => $alatMedis->id,
                'alamat' => 'Jl. Hasanudin No.8, Surabaya',
                'kontak' => '082277880612',
                'status' => 'aktif',
            ],
        ];

        // ========================================
        // DATA DUMMY SUPPLIER NON MEDIS
        // ========================================

        $suppliersNonMedis = [
            // Pakan
            [
                'nama_supplier' => 'CV. Hewan Nusantara',
                'nib' => '7974552347191',
                'jenis_barang_id' => $pakan->id,
                'alamat' => 'Jl. Cinta No.9, Jakarta',
                'kontak' => '089278978201',
                'status' => 'aktif',
            ],
            [
                'nama_supplier' => 'Toko Susu Sehat Anabul',
                'nib' => '9183581879149',
                'jenis_barang_id' => $pakan->id,
                'alamat' => 'Jl. Pendidikan No.7, Makassar',
                'kontak' => '089355339148',
                'status' => 'aktif',
            ],
            [
                'nama_supplier' => 'Gudang Snack Hewan',
                'nib' => '7621890234576',
                'jenis_barang_id' => $pakan->id,
                'alamat' => 'Jl. Pasar Rebo No.18, Denpasar',
                'kontak' => '082831021246',
                'status' => 'aktif',
            ],

            // Aksesoris
            [
                'nama_supplier' => 'Alat Klinik Hewan Indo',
                'nib' => '4569812347865',
                'jenis_barang_id' => $aksesoris->id,
                'alamat' => 'Jl. Setiabudhi No.3, Bandung',
                'kontak' => '082278182800',
                'status' => 'aktif',
            ],
        ];

        // Insert data ke database
        foreach ($suppliersMedis as $supplier) {
            Supplier::create($supplier);
        }

        foreach ($suppliersNonMedis as $supplier) {
            Supplier::create($supplier);
        }
    }
}
