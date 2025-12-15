<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisBarang extends Model
{
    use HasFactory;

    protected $fillable = ['nama_jenis', 'kategori_id', 'icon'];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    public function suppliers()
    {
        return $this->hasMany(Supplier::class, 'jenis_barang_id');
    }
}
