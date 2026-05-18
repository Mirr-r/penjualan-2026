<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPesanan extends Model
{
protected $table = 'detail_pesanans';

protected $fillable = [
    'pemesanan_id',
    'produk_id',
    'qty',
    'harga',
    'subtotal',
];

public function pemesanan()
{
    return $this->belongsTo(Pemesanan::class);
}

public function produk()
{
    return $this->belongsTo(Produk::class);
}
}