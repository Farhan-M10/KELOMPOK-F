<?php
// app/Models/Pengadaan.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengadaan extends Model
{
    use HasFactory;

    protected $table = 'pengadaan_stok';

    protected $fillable = [
        'id_pengadaan',
        'tanggal',
        'suppliers_id',
        'total_harga',
        'status',
        'catatan',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'total_harga' => 'decimal:2',
    ];

    // Relasi ke Supplier
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'suppliers_id');
    }

    // Relasi ke Detail
    public function details()
    {
        return $this->hasMany(DetailPengadaan::class, 'pengadaan_stok_id');
    }

    // Generate ID Pengadaan
    public static function generateIdPengadaan()
    {
        $lastPengadaan = self::orderBy('id', 'desc')->first();
        
        if (!$lastPengadaan) {
            return 'PGD-' . date('Ymd') . '-001';
        }
        
        // Extract number dari id_pengadaan terakhir
        $lastNumber = intval(substr($lastPengadaan->id_pengadaan, -3));
        $newNumber = $lastNumber + 1;
        
        return 'PGD-' . date('Ymd') . '-' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
    }
}