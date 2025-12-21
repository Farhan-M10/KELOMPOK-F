<?php
// app/Models/DetailPengadaan.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPengadaan extends Model
{
    use HasFactory;

    protected $table = 'detail_pengadaan_stok';

    protected $fillable = [
        'pengadaan_stok_id',
        'barangs_id',
        'jumlah_pesan',
        'harga_satuan',
        'subtotal',
    ];

    protected $casts = [
        'jumlah_pesan' => 'integer',
        'harga_satuan' => 'decimal:2',
        'subtotal' => 'decimal:2',
    ];

    // Relasi ke Pengadaan
    public function pengadaan()
    {
        return $this->belongsTo(Pengadaan::class, 'pengadaan_stok_id');
    }

    // Relasi ke Barang
    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barangs_id');
    }
}