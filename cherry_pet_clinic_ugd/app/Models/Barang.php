<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_barang',
        'kategori_id',
        'jenis_barang_id',
        'lokasi',
        'ruangan',
        'total_stok',
        'satuan',
        'stok_minimum',
        'deskripsi'
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    public function jenisBarang()
    {
        return $this->belongsTo(JenisBarang::class, 'jenis_barang_id');
    }

    public function batchBarangs()
    {
        return $this->hasMany(BatchBarang::class);
    }

    public function hitungTotalStok()
    {
        return $this->batchBarangs()->sum('jumlah');
    }

    public function jumlahBatch()
    {
        return $this->batchBarangs()->count();
    }

    public function isStokRendah()
    {
        return $this->total_stok < $this->stok_minimum;
    }

    public function getStatusStok()
    {
        if ($this->isStokRendah()) {
            return 'rendah';
        }
        return 'aman';
    }

    public function getLokasiLengkap()
    {
        return $this->lokasi . ' - ' . $this->ruangan;
    }
}
