<?php
// File: database/seeders/KategoriSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        $kategoris = [
            ['nama_kategori' => 'Obat Hewan', 'jenis' => 'medis', 'created_at' => now(), 'updated_at' => now()],
            ['nama_kategori' => 'Vaksin', 'jenis' => 'medis', 'created_at' => now(), 'updated_at' => now()],
            ['nama_kategori' => 'Vitamin', 'jenis' => 'medis', 'created_at' => now(), 'updated_at' => now()],
            ['nama_kategori' => 'Cairan Infus', 'jenis' => 'medis', 'created_at' => now(), 'updated_at' => now()],
            ['nama_kategori' => 'Alat Bedah', 'jenis' => 'medis', 'created_at' => now(), 'updated_at' => now()],
            ['nama_kategori' => 'Alat Medis Habis Pakai', 'jenis' => 'medis', 'created_at' => now(), 'updated_at' => now()],
            ['nama_kategori' => 'Alat Pemeriksaan', 'jenis' => 'medis', 'created_at' => now(), 'updated_at' => now()],
            
            ['nama_kategori' => 'Makanan Hewan', 'jenis' => 'non-medis', 'created_at' => now(), 'updated_at' => now()],
            ['nama_kategori' => 'Perawatan', 'jenis' => 'non-medis', 'created_at' => now(), 'updated_at' => now()],
            ['nama_kategori' => 'Perawatan Klinik', 'jenis' => 'non-medis', 'created_at' => now(), 'updated_at' => now()],
            ['nama_kategori' => 'Susu Formula', 'jenis' => 'non-medis', 'created_at' => now(), 'updated_at' => now()],
            ['nama_kategori' => 'Snack', 'jenis' => 'non-medis', 'created_at' => now(), 'updated_at' => now()],
            ['nama_kategori' => 'Alat Kesehatan', 'jenis' => 'non-medis', 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('kategoris')->insert($kategoris);
    }
}