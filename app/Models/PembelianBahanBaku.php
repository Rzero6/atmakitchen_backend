<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembelianBahanBaku extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_bahanBaku',
        'jumlah',
        'tglPembelian',
        'harga',
    ];
    public function bahanBaku()
    {
        return $this->belongsTo(BahanBaku::class, 'id_bahanBaku');
    }
}
