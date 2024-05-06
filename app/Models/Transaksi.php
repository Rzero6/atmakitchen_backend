<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_customer',
        'id_alamat',
        'tanggal_pesanan',
        'status',
        'jarak',
        'tip',
    ];
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'id_customer', 'id');
    }
    public function alamat()
    {
        return $this->belongsTo(Alamat::class, 'id_alamat', 'id');
    }
}
