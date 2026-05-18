<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $table = 'produks';

     protected $fillable = [
        'kategori_id',
        'nama',
        'slug',
        'deskripsi',
        'harga',
        'stok',
        'ukuran',
        'merk',
        'gambar',
        'is_active',
    ];

      public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }
}
