<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kategori;
use App\Models\JenisBarang;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        $medis = Kategori::create(['nama_kategori' => 'Medis']);
        $nonMedis = Kategori::create(['nama_kategori' => 'Non Medis']);

        JenisBarang::create(['nama_jenis' => 'Obat Hewan', 'kategori_id' => $medis->id, 'icon' => '💊']);
        JenisBarang::create(['nama_jenis' => 'Vaksin', 'kategori_id' => $medis->id, 'icon' => '💉']);
        JenisBarang::create(['nama_jenis' => 'Vitamin', 'kategori_id' => $medis->id, 'icon' => '🧪']);
        JenisBarang::create(['nama_jenis' => 'Vitamin', 'kategori_id' => $medis->id, 'icon' => '🧴']);
        JenisBarang::create(['nama_jenis' => 'Alat Bedah', 'kategori_id' => $medis->id, 'icon' => '🩺']);

        JenisBarang::create(['nama_jenis' => 'Makanan Hewan', 'kategori_id' => $nonMedis->id, 'icon' => '🍖']);
        JenisBarang::create(['nama_jenis' => 'Perawatan', 'kategori_id' => $nonMedis->id, 'icon' => '🧴']);
        JenisBarang::create(['nama_jenis' => 'Perawatan Klinik', 'kategori_id' => $nonMedis->id, 'icon' => '🩺']);
        JenisBarang::create(['nama_jenis' => 'Susu Formula', 'kategori_id' => $nonMedis->id, 'icon' => '🍼']);
        JenisBarang::create(['nama_jenis' => 'Snack', 'kategori_id' => $nonMedis->id, 'icon' => '🍪']);


    }
}
