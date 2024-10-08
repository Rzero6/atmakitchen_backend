<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_penitip',
        'nama',
        'jenis',
        'harga',
        'stok',
        'limit_po',
        'ukuran',
        'image',
    ];
    public function resep()
    {
        return $this->hasMany(Resep::class, 'id_produk');
    }
    public function penitip()
    {
        return $this->belongsTo(Penitip::class, 'id_penitip');
    }
}
