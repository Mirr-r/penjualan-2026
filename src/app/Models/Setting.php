<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'nama_toko',
        'tagline',
        'whatsapp',
        'email',
        'instagram',
        'alamat',
        'deskripsi',
    ];
}