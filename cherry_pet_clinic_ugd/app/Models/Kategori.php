<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $fillable = ['nama_kategori'];

    public function jenisBarangs()
    {
        return $this->hasMany(JenisBarang::class, 'kategori_id');
    }

    public function suppliers()
    {
        return $this->hasManyThrough(
            Supplier::class,
            JenisBarang::class,
            'kategori_id',
            'jenis_barang_id',
            'id',
            'id'
        );
    }
}
