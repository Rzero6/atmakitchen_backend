<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailTransaksi extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_transaksi',
        'id_produk',
        'id_hampers',
        'jumlah',
    ];

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'id_transaksi', 'id');
    }
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk', 'id');
    }
    public function hampers()
    {
        return $this->belongsTo(Hampers::class, 'id_hampers', 'id');
    }
}
