<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class BatchBarang extends Model
{
    use HasFactory;

    protected $fillable = [
        'barang_id',
        'nomor_batch',
        'tanggal_masuk',
        'tanggal_kadaluarsa',
        'jumlah',
        'status'
    ];

    protected $casts = [
        'tanggal_masuk' => 'date',
        'tanggal_kadaluarsa' => 'date'
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }

    // Relasi ke PenguranganStok
    public function penguranganStok()
    {
        return $this->hasMany(PenguranganStok::class, 'batch_barang_id');
    }

    public function updateStatus()
    {
        $today = Carbon::now();
        $expiry = Carbon::parse($this->tanggal_kadaluarsa);
        $daysUntilExpiry = $today->diffInDays($expiry, false);

        if ($daysUntilExpiry < 0) {
            $this->status = 'Kritis';
        } elseif ($daysUntilExpiry <= 30) {
            $this->status = 'Kritis';
        } elseif ($daysUntilExpiry <= 90) {
            $this->status = 'Perhatian';
        } else {
            $this->status = 'Stok Aman';
        }

        $this->save();
    }

    public function sisaHari()
    {
        $today = Carbon::now();
        $expiry = Carbon::parse($this->tanggal_kadaluarsa);
        return $today->diffInDays($expiry, false);
    }

    public function getBadgeClass()
    {
        return match($this->status) {
            'Stok Aman' => 'success',
            'Perhatian' => 'warning',
            'Kritis' => 'danger',
            default => 'secondary'
        };
    }

    // Method untuk mengurangi stok
    public function kurangiStok($jumlah)
    {
        if ($this->jumlah >= $jumlah) {
            $this->jumlah -= $jumlah;
            $this->save();

            // Update total stok di tabel barang
            $this->barang->total_stok = $this->barang->hitungTotalStok();
            $this->barang->save();

            return true;
        }
        return false;
    }
}
