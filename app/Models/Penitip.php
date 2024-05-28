<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penitip extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama',
        'no_telp',
        'alamat',
    ];
}
