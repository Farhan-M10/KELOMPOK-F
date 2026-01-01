<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nama_supplier',
        'nib',
        'jenis_barang_id',
        'alamat',
        'kontak',
        'status'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function jenisBarang()
    {
        return $this->belongsTo(JenisBarang::class, 'jenis_barang_id');
    }

    public function getKategoriAttribute()
    {
        return $this->jenisBarang?->kategori;
    }

    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }
}
