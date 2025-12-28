<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenguranganStok extends Model
{
    use HasFactory;

    protected $table = 'pengurangan_stok';

    protected $fillable = [
        'batch_barang_id',
        'user_id',
        'jumlah_pengurangan',
        'alasan',
        'keterangan',
        'tanggal_pengurangan',
    ];

    protected $casts = [
        'tanggal_pengurangan' => 'date',
    ];

    // Relasi ke BatchBarang
    public function batchBarang()
    {
        return $this->belongsTo(BatchBarang::class, 'batch_barang_id');
    }

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
