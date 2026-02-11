<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengembalian extends Model
{
    protected $table = 'pengembalian';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'peminjaman_id',
        'tanggal_kembali',
        'status_kondisi'
    ];

    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class, 'peminjaman_id');
    }

    public function detailPengembalian()
    {
        return $this->hasMany(DetailPengembalian::class, 'pengembalian_id');
    }

}
