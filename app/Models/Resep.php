<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resep extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_produk',
        'id_bahan_baku',
        'takaran',
    ];

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk');
    }
    public function bahan_baku()
    {
        return $this->belongsTo(BahanBaku::class, 'id_bahan_baku');
    }
}
