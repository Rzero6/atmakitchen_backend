<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoriSaldo extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_customer',
        'mutasi',
        'status',
        'tujuan',
        'bukti_transfer',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'id_customer');
    }
}
