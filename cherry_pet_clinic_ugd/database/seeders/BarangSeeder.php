<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BarangSeeder extends Seeder
{
    public function run()
    {
        // Get kategori IDs
        $medisId = DB::table('kategoris')->where('nama_kategori', 'medis')->value('id');
        $nonMedisId = DB::table('kategoris')->where('nama_kategori', 'non-medis')->value('id');

        // Get jenis barang IDs
        $obatHewanId = DB::table('jenis_barangs')->where('nama_jenis', 'Obat Hewan')->value('id');
        $vaksinId = DB::table('jenis_barangs')->where('nama_jenis', 'Vaksin')->value('id');
        $vitaminId = DB::table('jenis_barangs')->where('nama_jenis', 'Vitamin')->value('id');
        $cairanInfusId = DB::table('jenis_barangs')->where('nama_jenis', 'Cairan Infus')->value('id');
        $alatBedahId = DB::table('jenis_barangs')->where('nama_jenis', 'Alat Bedah')->value('id');
        $alatMedisId = DB::table('jenis_barangs')->where('nama_jenis', 'Alat Medis Habis Pakai')->value('id');
        $alatPemeriksaanId = DB::table('jenis_barangs')->where('nama_jenis', 'Alat Pemeriksaan')->value('id');
        $makananHewanId = DB::table('jenis_barangs')->where('nama_jenis', 'Makanan Hewan')->value('id');
        $perawatanId = DB::table('jenis_barangs')->where('nama_jenis', 'Perawatan')->value('id');
        $perawatanKlinikId = DB::table('jenis_barangs')->where('nama_jenis', 'Perawatan Klinik')->value('id');
        $susuFormulaId = DB::table('jenis_barangs')->where('nama_jenis', 'Susu Formula')->value('id');

        // ========== MEDIS ==========

        // 1. Amoxicilin 500mg
        $barang1Id = DB::table('barangs')->insertGetId([
            'nama_barang' => 'Amoxicilin 500mg',
            'kategori_id' => $medisId,
            'jenis_barang_id' => $obatHewanId,
            'lokasi' => 'Rak A-2',
            'ruangan' => 'Ruang Farmasi Lt. 1',
            'total_stok' => 30,
            'satuan' => 'box',
            'stok_minimum' => 10,
            'deskripsi' => 'Antibiotik untuk infeksi bakteri',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('batch_barangs')->insert([
            [
                'barang_id' => $barang1Id,
                'nomor_batch' => 'B-240915',
                'tanggal_masuk' => Carbon::parse('2024-09-15'),
                'tanggal_kadaluarsa' => Carbon::parse('2025-09-15'),
                'jumlah' => 15,
                'status' => 'Perhatian',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'barang_id' => $barang1Id,
                'nomor_batch' => 'B-241028',
                'tanggal_masuk' => Carbon::parse('2024-10-28'),
                'tanggal_kadaluarsa' => Carbon::parse('2026-04-28'),
                'jumlah' => 15,
                'status' => 'Stok Aman',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);

        // 2. Vaksin Rabies
        $barang2Id = DB::table('barangs')->insertGetId([
            'nama_barang' => 'Vaksin Rabies',
            'kategori_id' => $medisId,
            'jenis_barang_id' => $vaksinId,
            'lokasi' => 'Kulkas V-1',
            'ruangan' => 'Ruang Vaksinasi Lt. 1',
            'total_stok' => 28,
            'satuan' => 'vial',
            'stok_minimum' => 15,
            'deskripsi' => 'Vaksin pencegahan rabies',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('batch_barangs')->insert([
            [
                'barang_id' => $barang2Id,
                'nomor_batch' => 'V-240820',
                'tanggal_masuk' => Carbon::parse('2024-08-20'),
                'tanggal_kadaluarsa' => Carbon::parse('2025-01-20'),
                'jumlah' => 2,
                'status' => 'Kritis',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'barang_id' => $barang2Id,
                'nomor_batch' => 'V-241115',
                'tanggal_masuk' => Carbon::parse('2024-11-15'),
                'tanggal_kadaluarsa' => Carbon::parse('2026-05-15'),
                'jumlah' => 26,
                'status' => 'Stok Aman',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);

        // 3. Vitamin B Complex
        $barang3Id = DB::table('barangs')->insertGetId([
            'nama_barang' => 'Vitamin B Complex',
            'kategori_id' => $medisId,
            'jenis_barang_id' => $vitaminId,
            'lokasi' => 'Rak B-3',
            'ruangan' => 'Ruang Farmasi Lt. 1',
            'total_stok' => 22,
            'satuan' => 'botol',
            'stok_minimum' => 10,
            'deskripsi' => 'Suplemen vitamin B kompleks',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('batch_barangs')->insert([
            [
                'barang_id' => $barang3Id,
                'nomor_batch' => 'VT-241201',
                'tanggal_masuk' => Carbon::parse('2024-12-01'),
                'tanggal_kadaluarsa' => Carbon::parse('2027-11-05'),
                'jumlah' => 4,
                'status' => 'Stok Aman',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'barang_id' => $barang3Id,
                'nomor_batch' => 'VT-241105',
                'tanggal_masuk' => Carbon::parse('2024-11-05'),
                'tanggal_kadaluarsa' => Carbon::parse('2027-12-08'),
                'jumlah' => 18,
                'status' => 'Stok Aman',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);

        // 4. NaCl 0.9% (Infus)
        $barang4Id = DB::table('barangs')->insertGetId([
            'nama_barang' => 'NaCl 0.9% (Infus)',
            'kategori_id' => $medisId,
            'jenis_barang_id' => $cairanInfusId,
            'lokasi' => 'Rak A-4',
            'ruangan' => 'Ruang Vaksinasi Lt. 1',
            'total_stok' => 20,
            'satuan' => 'botol',
            'stok_minimum' => 15,
            'deskripsi' => 'Cairan infus NaCl 0.9%',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('batch_barangs')->insert([
            [
                'barang_id' => $barang4Id,
                'nomor_batch' => 'NC-241208',
                'tanggal_masuk' => Carbon::parse('2024-12-08'),
                'tanggal_kadaluarsa' => Carbon::parse('2027-11-08'),
                'jumlah' => 5,
                'status' => 'Stok Aman',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'barang_id' => $barang4Id,
                'nomor_batch' => 'NC-241120',
                'tanggal_masuk' => Carbon::parse('2024-11-20'),
                'tanggal_kadaluarsa' => Carbon::parse('2025-09-15'),
                'jumlah' => 15,
                'status' => 'Perhatian',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);

        // 5. Scalpel Bedah Steril
        $barang5Id = DB::table('barangs')->insertGetId([
            'nama_barang' => 'Scalpel Bedah Steril',
            'kategori_id' => $medisId,
            'jenis_barang_id' => $alatBedahId,
            'lokasi' => 'Rak A-1',
            'ruangan' => 'Ruang Operasi Lt. 2',
            'total_stok' => 8,
            'satuan' => 'unit',
            'stok_minimum' => 5,
            'deskripsi' => 'Pisau bedah steril sekali pakai',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('batch_barangs')->insert([
            [
                'barang_id' => $barang5Id,
                'nomor_batch' => 'SC-241015',
                'tanggal_masuk' => Carbon::parse('2024-10-15'),
                'tanggal_kadaluarsa' => Carbon::parse('2028-04-15'),
                'jumlah' => 1,
                'status' => 'Stok Aman',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'barang_id' => $barang5Id,
                'nomor_batch' => 'SC-240915',
                'tanggal_masuk' => Carbon::parse('2024-09-15'),
                'tanggal_kadaluarsa' => Carbon::parse('2028-03-16'),
                'jumlah' => 7,
                'status' => 'Stok Aman',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);

        // 6. Sarung Tangan Latex
        $barang6Id = DB::table('barangs')->insertGetId([
            'nama_barang' => 'Sarung Tangan Latex',
            'kategori_id' => $medisId,
            'jenis_barang_id' => $alatMedisId,
            'lokasi' => 'Rak B-2',
            'ruangan' => 'Ruang Alat Medis Lt. 1',
            'total_stok' => 120,
            'satuan' => 'box',
            'stok_minimum' => 50,
            'deskripsi' => 'Sarung tangan latex medis',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('batch_barangs')->insert([
            [
                'barang_id' => $barang6Id,
                'nomor_batch' => 'LX-240915',
                'tanggal_masuk' => Carbon::parse('2024-09-15'),
                'tanggal_kadaluarsa' => Carbon::parse('2026-05-15'),
                'jumlah' => 30,
                'status' => 'Stok Aman',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'barang_id' => $barang6Id,
                'nomor_batch' => 'LX-241215',
                'tanggal_masuk' => Carbon::parse('2024-12-15'),
                'tanggal_kadaluarsa' => Carbon::parse('2026-04-16'),
                'jumlah' => 90,
                'status' => 'Stok Aman',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);

        // 7. Stetoskop Veteriner
        $barang7Id = DB::table('barangs')->insertGetId([
            'nama_barang' => 'Stetoskop Veteriner',
            'kategori_id' => $medisId,
            'jenis_barang_id' => $alatPemeriksaanId,
            'lokasi' => 'Rak A-3',
            'ruangan' => 'Ruang Pemeriksaan Lt. 1',
            'total_stok' => 6,
            'satuan' => 'unit',
            'stok_minimum' => 3,
            'deskripsi' => 'Stetoskop untuk pemeriksaan hewan',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('batch_barangs')->insert([
            [
                'barang_id' => $barang7Id,
                'nomor_batch' => 'ST-290915',
                'tanggal_masuk' => Carbon::parse('2024-09-15'),
                'tanggal_kadaluarsa' => Carbon::parse('2028-03-16'),
                'jumlah' => 1,
                'status' => 'Stok Aman',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'barang_id' => $barang7Id,
                'nomor_batch' => 'ST-267915',
                'tanggal_masuk' => Carbon::parse('2024-12-15'),
                'tanggal_kadaluarsa' => Carbon::parse('2028-05-20'),
                'jumlah' => 5,
                'status' => 'Stok Aman',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);

        // 8. Ceftriaxone Injeksi
        $barang8Id = DB::table('barangs')->insertGetId([
            'nama_barang' => 'Ceftriaxone Injeksi',
            'kategori_id' => $medisId,
            'jenis_barang_id' => $obatHewanId,
            'lokasi' => 'Kulkas V-1',
            'ruangan' => 'Ruang Farmasi Lt. 1',
            'total_stok' => 35,
            'satuan' => 'vial',
            'stok_minimum' => 20,
            'deskripsi' => 'Antibiotik injeksi ceftriaxone',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('batch_barangs')->insert([
            [
                'barang_id' => $barang8Id,
                'nomor_batch' => 'C-243815',
                'tanggal_masuk' => Carbon::parse('2024-09-15'),
                'tanggal_kadaluarsa' => Carbon::parse('2026-03-15'),
                'jumlah' => 5,
                'status' => 'Stok Aman',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'barang_id' => $barang8Id,
                'nomor_batch' => 'C-240915',
                'tanggal_masuk' => Carbon::parse('2024-12-15'),
                'tanggal_kadaluarsa' => Carbon::parse('2026-08-15'),
                'jumlah' => 30,
                'status' => 'Stok Aman',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);

        // ========== NON MEDIS ==========

        // 9. Royal Canin Adult 20kg
        $barang9Id = DB::table('barangs')->insertGetId([
            'nama_barang' => 'Royal Canin Adult 20kg',
            'kategori_id' => $nonMedisId,
            'jenis_barang_id' => $makananHewanId,
            'lokasi' => 'Gudang G-1',
            'ruangan' => 'Gudang Lt. 1',
            'total_stok' => 30,
            'satuan' => 'sak',
            'stok_minimum' => 5,
            'deskripsi' => 'Makanan anjing dewasa Royal Canin',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('batch_barangs')->insert([
            [
                'barang_id' => $barang9Id,
                'nomor_batch' => 'RC-241020',
                'tanggal_masuk' => Carbon::parse('2024-10-20'),
                'tanggal_kadaluarsa' => Carbon::parse('2026-10-20'),
                'jumlah' => 15,
                'status' => 'Stok Aman',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'barang_id' => $barang9Id,
                'nomor_batch' => 'RC-241205',
                'tanggal_masuk' => Carbon::parse('2024-12-05'),
                'tanggal_kadaluarsa' => Carbon::parse('2026-12-05'),
                'jumlah' => 15,
                'status' => 'Stok Aman',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);

        // 10. Whiskas Dry Food 1.2kg
        $barang10Id = DB::table('barangs')->insertGetId([
            'nama_barang' => 'Whiskas Dry Food 1.2kg',
            'kategori_id' => $nonMedisId,
            'jenis_barang_id' => $makananHewanId,
            'lokasi' => 'Gudang G-2',
            'ruangan' => 'Gudang Lt. 1',
            'total_stok' => 28,
            'satuan' => 'pcs',
            'stok_minimum' => 10,
            'deskripsi' => 'Makanan kucing kering Whiskas',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('batch_barangs')->insert([
            [
                'barang_id' => $barang10Id,
                'nomor_batch' => 'WK-240820',
                'tanggal_masuk' => Carbon::parse('2024-08-20'),
                'tanggal_kadaluarsa' => Carbon::parse('2026-01-20'),
                'jumlah' => 2,
                'status' => 'Perhatian',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'barang_id' => $barang10Id,
                'nomor_batch' => 'WK-241115',
                'tanggal_masuk' => Carbon::parse('2024-11-15'),
                'tanggal_kadaluarsa' => Carbon::parse('2026-05-15'),
                'jumlah' => 26,
                'status' => 'Stok Aman',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);

        // 11. Pet Wipes Antiseptic 80s
        $barang11Id = DB::table('barangs')->insertGetId([
            'nama_barang' => 'Pet Wipes Antiseptic 80s',
            'kategori_id' => $nonMedisId,
            'jenis_barang_id' => $perawatanId,
            'lokasi' => 'Rak B-3',
            'ruangan' => 'Ruang Display Lt. 1',
            'total_stok' => 22,
            'satuan' => 'pack',
            'stok_minimum' => 15,
            'deskripsi' => 'Tisu basah antiseptik untuk hewan',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('batch_barangs')->insert([
            [
                'barang_id' => $barang11Id,
                'nomor_batch' => 'PW-241105',
                'tanggal_masuk' => Carbon::parse('2024-11-05'),
                'tanggal_kadaluarsa' => Carbon::parse('2027-11-05'),
                'jumlah' => 4,
                'status' => 'Stok Aman',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'barang_id' => $barang11Id,
                'nomor_batch' => 'PW-241208',
                'tanggal_masuk' => Carbon::parse('2024-12-08'),
                'tanggal_kadaluarsa' => Carbon::parse('2027-12-08'),
                'jumlah' => 18,
                'status' => 'Stok Aman',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);

        // 12. Kandang Rawat Inap 60×80cm
        $barang12Id = DB::table('barangs')->insertGetId([
            'nama_barang' => 'Kandang Rawat Inap 60×80cm',
            'kategori_id' => $nonMedisId,
            'jenis_barang_id' => $perawatanKlinikId,
            'lokasi' => 'Gudang D-1',
            'ruangan' => 'Gudang Lt. 1',
            'total_stok' => 20,
            'satuan' => 'unit',
            'stok_minimum' => 3,
            'deskripsi' => 'Kandang rawat inap untuk hewan',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('batch_barangs')->insert([
            [
                'barang_id' => $barang12Id,
                'nomor_batch' => 'KD-241108',
                'tanggal_masuk' => Carbon::parse('2024-11-08'),
                'tanggal_kadaluarsa' => Carbon::parse('2027-11-08'),
                'jumlah' => 5,
                'status' => 'Stok Aman',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'barang_id' => $barang12Id,
                'nomor_batch' => 'KD-240915',
                'tanggal_masuk' => Carbon::parse('2024-09-15'),
                'tanggal_kadaluarsa' => Carbon::parse('2027-11-08'),
                'jumlah' => 15,
                'status' => 'Stok Aman',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);

        // 13. Shampoo Anti Kutu
        $barang13Id = DB::table('barangs')->insertGetId([
            'nama_barang' => 'Shampoo Anti Kutu',
            'kategori_id' => $nonMedisId,
            'jenis_barang_id' => $perawatanId,
            'lokasi' => 'Rak A-1',
            'ruangan' => 'Ruang Display Lt. 1',
            'total_stok' => 8,
            'satuan' => 'unit',
            'stok_minimum' => 10,
            'deskripsi' => 'Shampoo anti kutu untuk hewan',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('batch_barangs')->insert([
            [
                'barang_id' => $barang13Id,
                'nomor_batch' => 'SH-240909',
                'tanggal_masuk' => Carbon::parse('2024-09-09'),
                'tanggal_kadaluarsa' => Carbon::parse('2026-04-15'),
                'jumlah' => 1,
                'status' => 'Perhatian',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'barang_id' => $barang13Id,
                'nomor_batch' => 'SH-241215',
                'tanggal_masuk' => Carbon::parse('2024-12-15'),
                'tanggal_kadaluarsa' => Carbon::parse('2026-03-08'),
                'jumlah' => 7,
                'status' => 'Stok Aman',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);

        // 14. Susu Kitten KMR 340g
        $barang14Id = DB::table('barangs')->insertGetId([
            'nama_barang' => 'Susu Kitten KMR 340g',
            'kategori_id' => $nonMedisId,
            'jenis_barang_id' => $susuFormulaId,
            'lokasi' => 'Rak B-2',
            'ruangan' => 'Ruang Display Lt. 1',
            'total_stok' => 120,
            'satuan' => 'kaleng',
            'stok_minimum' => 8,
            'deskripsi' => 'Susu formula untuk anak kucing',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('batch_barangs')->insert([
            [
                'barang_id' => $barang14Id,
                'nomor_batch' => 'KM-240915',
                'tanggal_masuk' => Carbon::parse('2024-09-15'),
                'tanggal_kadaluarsa' => Carbon::parse('2026-05-15'),
                'jumlah' => 30,
                'status' => 'Stok Aman',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'barang_id' => $barang14Id,
                'nomor_batch' => 'KM-240416',
                'tanggal_masuk' => Carbon::parse('2024-04-16'),
                'tanggal_kadaluarsa' => Carbon::parse('2026-08-16'),
                'jumlah' => 90,
                'status' => 'Stok Aman',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);

        // 15. Ear Cleaner 100ml
        $barang15Id = DB::table('barangs')->insertGetId([
            'nama_barang' => 'Ear Cleaner 100ml',
            'kategori_id' => $nonMedisId,
            'jenis_barang_id' => $perawatanId,
            'lokasi' => 'Rak A-3',
            'ruangan' => 'Ruang Display Lt. 1',
            'total_stok' => 6,
            'satuan' => 'unit',
            'stok_minimum' => 10,
            'deskripsi' => 'Pembersih telinga hewan',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('batch_barangs')->insert([
            [
                'barang_id' => $barang15Id,
                'nomor_batch' => 'EC-240915',
                'tanggal_masuk' => Carbon::parse('2024-09-15'),
                'tanggal_kadaluarsa' => Carbon::parse('2026-03-16'),
                'jumlah' => 1,
                'status' => 'Perhatian',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'barang_id' => $barang15Id,
                'nomor_batch' => 'EC-241215',
                'tanggal_masuk' => Carbon::parse('2024-12-15'),
                'tanggal_kadaluarsa' => Carbon::parse('2026-05-20'),
                'jumlah' => 5,
                'status' => 'Stok Aman',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);

        // 16. Syringe Feeding 20ml
        $barang16Id = DB::table('barangs')->insertGetId([
            'nama_barang' => 'Syringe Feeding 20ml',
            'kategori_id' => $nonMedisId,
            'jenis_barang_id' => $perawatanKlinikId,
            'lokasi' => 'Rak C-1',
            'ruangan' => 'Ruang Perawatan Lt. 1',
            'total_stok' => 35,
            'satuan' => 'pcs',
            'stok_minimum' => 20,
            'deskripsi' => 'Syringe untuk feeding hewan',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('batch_barangs')->insert([
            [
                 'barang_id' => $barang16Id,
            'nomor_batch' => 'SF-240915',
            'tanggal_masuk' => Carbon::parse('2024-09-15'),
            'tanggal_kadaluarsa' => Carbon::parse('2026-03-15'),
            'jumlah' => 5,
            'status' => 'Stok Aman',
            'created_at' => now(),
            'updated_at' => now()
        ],
        [
            'barang_id' => $barang16Id,
            'nomor_batch' => 'SF-241215',
            'tanggal_masuk' => Carbon::parse('2024-12-15'),
            'tanggal_kadaluarsa' => Carbon::parse('2026-08-15'),
            'jumlah' => 30,
            'status' => 'Stok Aman',
            'created_at' => now(),
            'updated_at' => now()
        ]
    ]);

    $this->command->info('✅ Berhasil membuat 16 barang dengan total ' . DB::table('batch_barangs')->count() . ' batch!');
}
}
