<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $table = 'kategori';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'nama_kategori',
        'keterangan'
    ];

    public function alat()
    {
    return $this->hasMany(Alat::class, 'kategori_id');
    }
}
