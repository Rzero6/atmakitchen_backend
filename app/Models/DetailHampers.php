<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailHampers extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_hampers',
        'id_produk',
        'id_bahan_baku',
        'jumlah',
    ];
    public function hampers()
    {
        return $this->belongsTo(Hampers::class, 'id_hampers');
    }
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk');
    }
    public function bahan_baku()
    {
        return $this->belongsTo(BahanBaku::class, 'id_bahan_baku');
    }
}
