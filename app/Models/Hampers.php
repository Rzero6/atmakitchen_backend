<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hampers extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama',
        'id_produk1',
        'id_produk2',
        'rincian',
        'harga',
    ];

    public function produk1()
    {
        return $this->belongsTo(Produk::class, 'id_produk1');
    }
    public function produk2()
    {
        return $this->belongsTo(Produk::class, 'id_produk2');
    }
}
