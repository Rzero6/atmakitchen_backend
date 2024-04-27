<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_user',
        'tanggal_lahir',
        'promo_poin',
        'saldo',
        'profil_pic',
        'verify_key',
    ];
}
