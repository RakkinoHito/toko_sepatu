<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shoe extends Model
{
    protected $fillable = [
        'nama', 'merk', 'ukuran', 'harga', 'stok', 'image'
    ];
}