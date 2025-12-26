<?php
// File: database/seeders/JenisBarangSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JenisBarangSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil ID kategori medis dan non-medis
        $medisId = DB::table('kategoris')->where('nama_kategori', 'medis')->value('id');
        $nonMedisId = DB::table('kategoris')->where('nama_kategori', 'non-medis')->value('id');

        $jenisBarangs = [
            // Medis
            ['nama_jenis' => 'Obat Hewan', 'kategori_id' => $medisId, 'created_at' => now(), 'updated_at' => now()],
            ['nama_jenis' => 'Vaksin', 'kategori_id' => $medisId, 'created_at' => now(), 'updated_at' => now()],
            ['nama_jenis' => 'Vitamin', 'kategori_id' => $medisId, 'created_at' => now(), 'updated_at' => now()],
            ['nama_jenis' => 'Cairan Infus', 'kategori_id' => $medisId, 'created_at' => now(), 'updated_at' => now()],
            ['nama_jenis' => 'Alat Bedah', 'kategori_id' => $medisId, 'created_at' => now(), 'updated_at' => now()],
            ['nama_jenis' => 'Alat Medis Habis Pakai', 'kategori_id' => $medisId, 'created_at' => now(), 'updated_at' => now()],
            ['nama_jenis' => 'Alat Pemeriksaan', 'kategori_id' => $medisId, 'created_at' => now(), 'updated_at' => now()],

            // Non-Medis
            ['nama_jenis' => 'Makanan Hewan', 'kategori_id' => $nonMedisId, 'created_at' => now(), 'updated_at' => now()],
            ['nama_jenis' => 'Perawatan', 'kategori_id' => $nonMedisId, 'created_at' => now(), 'updated_at' => now()],
            ['nama_jenis' => 'Perawatan Klinik', 'kategori_id' => $nonMedisId, 'created_at' => now(), 'updated_at' => now()],
            ['nama_jenis' => 'Susu Formula', 'kategori_id' => $nonMedisId, 'created_at' => now(), 'updated_at' => now()],
            ['nama_jenis' => 'Snack', 'kategori_id' => $nonMedisId, 'created_at' => now(), 'updated_at' => now()],
            ['nama_jenis' => 'Alat Kesehatan', 'kategori_id' => $nonMedisId, 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('jenis_barangs')->insert($jenisBarangs);
    }
}
