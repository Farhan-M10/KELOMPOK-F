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
            ['nama_kategori' => 'medis', 'created_at' => now(), 'updated_at' => now()],
            ['nama_kategori' => 'non-medis', 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('kategoris')->insert($kategoris);
    }
}
