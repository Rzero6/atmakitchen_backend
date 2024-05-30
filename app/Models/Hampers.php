<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hampers extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama',
        'harga',
        'image',
    ];

    public function detailhampers()
    {
        return $this->hasMany(DetailHampers::class, 'id_hampers');
    }
}
