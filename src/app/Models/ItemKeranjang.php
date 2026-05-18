<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemKeranjang extends Model
{
    public function keranjang()
    {
        return $this->belongsTo(Keranjang::class);
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }
    
}