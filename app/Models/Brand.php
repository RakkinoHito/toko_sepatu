<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $fillable = ['nama', 'negara', 'deskripsi'];

    public function shoes()
    {
        return $this->hasMany(Shoe::class);
    }
}