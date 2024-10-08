<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alamat extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_customer',
        'nama_penerima',
        'no_telepon',
        'kota',
        'jalan',
        'rincian',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'id_customer');
    }
}
