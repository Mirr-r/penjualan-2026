<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemKeranjang extends Model
{
    protected $table = 'item_keranjangs';
    protected $fillable = [
        'keranjang_id',
        'produk_id',
        'qty',
        'harga',
        'subtotal',
    ];
    public function keranjang()
    {
        return $this->belongsTo(Keranjang::class);
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }
    
}