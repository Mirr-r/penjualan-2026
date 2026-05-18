<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pemesanan extends Model
{
    protected $table = 'pemesanans';

    protected $fillable = [
    'user_id',
    'invoice',
    'total_harga',
    'status',
    'bukti_pembayaran',
    'catatan',
];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function detailPesanans()
    {
        return $this->hasMany(DetailPesanan::class);
    }
}