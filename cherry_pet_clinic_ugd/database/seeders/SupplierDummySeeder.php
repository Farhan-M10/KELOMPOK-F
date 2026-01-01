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
        // Ambil kategori Medis dan Non Medis (sesuaikan dengan KategoriSeeder)
        $kategoriMedis = Kategori::where('nama_kategori', 'medis')->first();
        $kategoriNonMedis = Kategori::where('nama_kategori', 'non-medis')->first();

        // Ambil jenis barang berdasarkan kategori - MEDIS
        $obatHewan = JenisBarang::where('nama_jenis', 'Obat Hewan')
            ->where('kategori_id', $kategoriMedis->id)->first();

        $vaksin = JenisBarang::where('nama_jenis', 'Vaksin')
            ->where('kategori_id', $kategoriMedis->id)->first();

        $vitamin = JenisBarang::where('nama_jenis', 'Vitamin')
            ->where('kategori_id', $kategoriMedis->id)->first();

        $cairanInfus = JenisBarang::where('nama_jenis', 'Cairan Infus')
            ->where('kategori_id', $kategoriMedis->id)->first();

        $alatBedah = JenisBarang::where('nama_jenis', 'Alat Bedah')
            ->where('kategori_id', $kategoriMedis->id)->first();

        $alatMedisHabisPakai = JenisBarang::where('nama_jenis', 'Alat Medis Habis Pakai')
            ->where('kategori_id', $kategoriMedis->id)->first();

        $alatPemeriksaan = JenisBarang::where('nama_jenis', 'Alat Pemeriksaan')
            ->where('kategori_id', $kategoriMedis->id)->first();

        // Ambil jenis barang berdasarkan kategori - NON MEDIS
        $makananHewan = JenisBarang::where('nama_jenis', 'Makanan Hewan')
            ->where('kategori_id', $kategoriNonMedis->id)->first();

        $perawatan = JenisBarang::where('nama_jenis', 'Perawatan')
            ->where('kategori_id', $kategoriNonMedis->id)->first();

        $perawatanKlinik = JenisBarang::where('nama_jenis', 'Perawatan Klinik')
            ->where('kategori_id', $kategoriNonMedis->id)->first();

        $susuFormula = JenisBarang::where('nama_jenis', 'Susu Formula')
            ->where('kategori_id', $kategoriNonMedis->id)->first();

        $snack = JenisBarang::where('nama_jenis', 'Snack')
            ->where('kategori_id', $kategoriNonMedis->id)->first();

        $alatKesehatan = JenisBarang::where('nama_jenis', 'Alat Kesehatan')
            ->where('kategori_id', $kategoriNonMedis->id)->first();

        // ========================================
        // DATA DUMMY SUPPLIER MEDIS
        // ========================================

        $suppliersMedis = [
            // Obat Hewan (2 supplier)
            [
                'nama_supplier' => 'PT. Sejahtera Medika',
                'nib' => '1276189024571',
                'jenis_barang_id' => $obatHewan->id,
                'alamat' => 'Jl. Kesehatan No.1, Jakarta',
                'kontak' => '0882007612609',
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

            // Vaksin (2 supplier)
            [
                'nama_supplier' => 'PT. Vaksin Indonesia',
                'nib' => '1234567890123',
                'jenis_barang_id' => $vaksin->id,
                'alamat' => 'Jl. Pahlawan No.10, Bandung',
                'kontak' => '081234567890',
                'status' => 'aktif',
            ],
            [
                'nama_supplier' => 'CV. Bio Farma Vet',
                'nib' => '9876543210987',
                'jenis_barang_id' => $vaksin->id,
                'alamat' => 'Jl. Sudirman No.20, Jakarta',
                'kontak' => '082345678901',
                'status' => 'aktif',
            ],

            // Vitamin (2 supplier)
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

            // Cairan Infus (1 supplier)
            [
                'nama_supplier' => 'PT. Infus Medika',
                'nib' => '5566778899001',
                'jenis_barang_id' => $cairanInfus->id,
                'alamat' => 'Jl. Veteran No.15, Surabaya',
                'kontak' => '081122334455',
                'status' => 'aktif',
            ],

            // Alat Bedah (2 supplier)
            [
                'nama_supplier' => 'PT. Instrumen Bedah',
                'nib' => '3021847110296',
                'jenis_barang_id' => $alatBedah->id,
                'alamat' => 'Jl. Pemuda No.7, Surabaya',
                'kontak' => '081334422880',
                'status' => 'aktif',
            ],
            [
                'nama_supplier' => 'CV. Surgical Indo',
                'nib' => '4455667788990',
                'jenis_barang_id' => $alatBedah->id,
                'alamat' => 'Jl. Ahmad Yani No.25, Medan',
                'kontak' => '085566778899',
                'status' => 'aktif',
            ],

            // Alat Medis Habis Pakai (1 supplier)
            [
                'nama_supplier' => 'PT. Medis Disposable',
                'nib' => '2233445566778',
                'jenis_barang_id' => $alatMedisHabisPakai->id,
                'alamat' => 'Jl. Gatot Subroto No.50, Jakarta',
                'kontak' => '082233445566',
                'status' => 'aktif',
            ],

            // Alat Pemeriksaan (2 supplier)
            [
                'nama_supplier' => 'PT. Diagnostic Tools',
                'nib' => '6677889900112',
                'jenis_barang_id' => $alatPemeriksaan->id,
                'alamat' => 'Jl. Diponegoro No.30, Yogyakarta',
                'kontak' => '083344556677',
                'status' => 'aktif',
            ],
            [
                'nama_supplier' => 'CV. Lab Equipment',
                'nib' => '9988776655443',
                'jenis_barang_id' => $alatPemeriksaan->id,
                'alamat' => 'Jl. Soekarno Hatta No.40, Semarang',
                'kontak' => '084455667788',
                'status' => 'aktif',
            ],
        ];

        // ========================================
        // DATA DUMMY SUPPLIER NON MEDIS
        // ========================================

        $suppliersNonMedis = [
            // Makanan Hewan (2 supplier)
            [
                'nama_supplier' => 'CV. Hewan Nusantara',
                'nib' => '7974552347191',
                'jenis_barang_id' => $makananHewan->id,
                'alamat' => 'Jl. Cinta No.9, Jakarta',
                'kontak' => '089278978201',
                'status' => 'aktif',
            ],
            [
                'nama_supplier' => 'PT. Pet Food Indo',
                'nib' => '1122334455667',
                'jenis_barang_id' => $makananHewan->id,
                'alamat' => 'Jl. Kemang No.5, Jakarta Selatan',
                'kontak' => '081199887766',
                'status' => 'aktif',
            ],

            // Perawatan (1 supplier)
            [
                'nama_supplier' => 'PT. Grooming Jaya',
                'nib' => '3002184511267',
                'jenis_barang_id' => $perawatan->id,
                'alamat' => 'Jl. Pemuda No.12, Semarang',
                'kontak' => '081380740182',
                'status' => 'aktif',
            ],

            // Perawatan Klinik (2 supplier)
            [
                'nama_supplier' => 'CV. Klinik Pet Care',
                'nib' => '5544332211009',
                'jenis_barang_id' => $perawatanKlinik->id,
                'alamat' => 'Jl. Merdeka No.18, Bandung',
                'kontak' => '082244556688',
                'status' => 'aktif',
            ],
            [
                'nama_supplier' => 'PT. Animal Clinic Supply',
                'nib' => '8899001122334',
                'jenis_barang_id' => $perawatanKlinik->id,
                'alamat' => 'Jl. Asia Afrika No.22, Bandung',
                'kontak' => '085533221100',
                'status' => 'aktif',
            ],

            // Susu Formula (1 supplier)
            [
                'nama_supplier' => 'Toko Susu Sehat Anabul',
                'nib' => '9183581879149',
                'jenis_barang_id' => $susuFormula->id,
                'alamat' => 'Jl. Pendidikan No.7, Makassar',
                'kontak' => '089355339148',
                'status' => 'aktif',
            ],

            // Snack (2 supplier)
            [
                'nama_supplier' => 'Gudang Snack Hewan',
                'nib' => '7621890234576',
                'jenis_barang_id' => $snack->id,
                'alamat' => 'Jl. Pasar Rebo No.18, Denpasar',
                'kontak' => '082831021246',
                'status' => 'aktif',
            ],
            [
                'nama_supplier' => 'PT. Snack Pelitharam',
                'nib' => '4526891470382',
                'jenis_barang_id' => $snack->id,
                'alamat' => 'Jl. Gatama No.3, Bandung',
                'kontak' => '082279180212',
                'status' => 'aktif',
            ],

            // Alat Kesehatan (1 supplier)
            [
                'nama_supplier' => 'Alat Klinik Hewan Indo',
                'nib' => '4569812347865',
                'jenis_barang_id' => $alatKesehatan->id,
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
