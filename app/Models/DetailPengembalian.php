<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPengembalian extends Model
{
    protected $table = 'detail_pengembalian';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'pengembalian_id',
        'alat_id',
        'jumlah',
    ];

    public function pengembalian()
    {
        return $this->belongsTo(Pengembalian::class, 'pengembalian_id');
    }

    public function alat()
    {
        return $this->belongsTo(Alat::class, 'alat_id');
    }
}
