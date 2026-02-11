<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alat extends Model
{
    protected $table = 'alat';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'kode_alat',
        'nama_alat',
        'kategori_id',
        'stok',
        'kondisi'
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    public function detailPeminjaman()
    {
        return $this->hasMany(DetailPeminjaman::class, 'alat_id');
    }

    public function detailPengembalian()
    {
        return $this->hasMany(DetailPengembalian::class, 'pengembalian_id');
    }
}
