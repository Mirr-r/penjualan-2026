<?php

use Illuminate\Support\Facades\Route;
use App\Models\Kategori;
use App\Models\Produk;
use App\Models\Pemesanan;

Route::get('/categories', function () {
    return response()->json(Kategori::all());
});

Route::get('/products', function () {
    return response()->json(
        Produk::with('kategori')->get()
    );
});

Route::get('/products/{id}', function ($id) {
    return response()->json(
        Produk::with('kategori')->findOrFail($id)
    );
});

Route::get('/orders', function () {
    return response()->json(
        Pemesanan::with('detailPesanans')->get()
    );
});

Route::get('/orders/{invoice}', function ($invoice) {
    return response()->json(
        Pemesanan::with('detailPesanans.produk')
            ->where('invoice', $invoice)
            ->firstOrFail()
    );
});