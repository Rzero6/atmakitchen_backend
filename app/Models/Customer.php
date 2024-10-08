<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_user',
        'no_telepon',
        'tanggal_lahir',
        'promo_poin',
        'saldo',
        'profil_pic',
        'verify_key',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
    public function alamat()
    {
        return $this->hasMany(Alamat::class, 'id_customer');
    }
}
