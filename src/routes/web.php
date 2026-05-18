<?php

use Illuminate\Support\Facades\Route;
use Livewire\Livewire;
use Illuminate\Support\Facades\Response;
use App\Models\Produk;
use APP\Models\Pemesanan;
use App\Models\DetailPesanan;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Livewire::setUpdateRoute(function ($handle) {
    return Route::post(config('app.asset_prefix') . '/livewire/update', $handle);
});

Livewire::setScriptRoute(function ($handle) {
    return Route::get(config('app.asset_prefix') . '/livewire/livewire.js', $handle);
});

Route::get('/', function () {

    $search = request('search');
    $kategori = request('kategori');

    $produks = Produk::with('kategori')
        ->when($search, function ($query) use ($search) {
            $query->where('nama', 'like', "%{$search}%")
                ->orWhere('merk', 'like', "%{$search}%");
        })
        ->when($kategori, function ($query) use ($kategori) {
            $query->whereHas('kategori', function ($q) use ($kategori) {
                $q->where('slug', $kategori);
            });
        })
        ->latest()
        ->get();

    $kategoris = \App\Models\Kategori::all();

    return view('shop.index', compact(
        'produks',
        'search',
        'kategori',
        'kategoris'
    ));
});

Route::get('/produk/{slug}', function ($slug) {

    $produk = Produk::with('kategori')
        ->where('slug', $slug)
        ->firstOrFail();

    return view('shop.detail', compact('produk'));
});

Route::post('/keranjang/{produk}', function (Produk $produk) {
    return back()->with('success', 'Produk berhasil ditambahkan ke keranjang.');
});

Route::get('/keranjang', function () {

    $keranjang = session()->get('keranjang', []);

    return view('shop.keranjang', compact('keranjang'));
});

Route::post('/keranjang/{produk}', function (Produk $produk) {

    $keranjang = session()->get('keranjang', []);

    if (isset($keranjang[$produk->id])) {
        $keranjang[$produk->id]['qty']++;
    } else {
        $keranjang[$produk->id] = [
            'id' => $produk->id,
            'nama' => $produk->nama,
            'harga' => $produk->harga,
            'gambar' => $produk->gambar,
            'qty' => 1,
        ];
    }

    session()->put('keranjang', $keranjang);

    return back()->with('success', 'Produk berhasil ditambahkan ke keranjang.');
});


Route::post('/checkout', function () {
    $keranjang = session()->get('keranjang', []);

    if (empty($keranjang)) {
        return redirect('/keranjang');
    }

    $total = collect($keranjang)->sum(fn ($item) => $item['harga'] * $item['qty']);

    $pemesanan = Pemesanan::create([
        'invoice' => 'INV-' . time(),
        'total_harga' => $total,
        'status' => 'pending',
        'catatan' => 'Checkout dari website',
    ]);

    foreach ($keranjang as $item) {
        DetailPesanan::create([
            'pemesanan_id' => $pemesanan->id,
            'produk_id' => $item['id'],
            'qty' => $item['qty'],
            'harga' => $item['harga'],
            'subtotal' => $item['harga'] * $item['qty'],
        ]);

        $produk = Produk::find($item['id']);

        if ($produk) {
            $produk->decrement('stok', $item['qty']);
        }
    }

    session()->forget('keranjang');

    return redirect('/checkout/sukses/' . $pemesanan->invoice);
});

Route::get('/checkout/sukses/{invoice}', function ($invoice) {
    return view('shop.checkout-sukses', compact('invoice'));
});

Route::post('/keranjang/{id}/tambah', function ($id) {
    $keranjang = session()->get('keranjang', []);

    if (isset($keranjang[$id])) {
        $keranjang[$id]['qty']++;
    }

    session()->put('keranjang', $keranjang);

    return back();
});

Route::post('/keranjang/{id}/kurang', function ($id) {
    $keranjang = session()->get('keranjang', []);

    if (isset($keranjang[$id])) {
        $keranjang[$id]['qty']--;

        if ($keranjang[$id]['qty'] <= 0) {
            unset($keranjang[$id]);
        }
    }

    session()->put('keranjang', $keranjang);

    return back();
});

Route::post('/keranjang/{id}/hapus', function ($id) {
    $keranjang = session()->get('keranjang', []);

    unset($keranjang[$id]);

    session()->put('keranjang', $keranjang);

    return back();
});

Route::get('/pesanan', function () {

    $pemesanans = \App\Models\Pemesanan::latest()->get();

    return view('shop.pesanan', compact('pemesanans'));

});

Route::get('/pesanan/{invoice}', function ($invoice) {
    $pemesanan = \App\Models\Pemesanan::with('detailPesanans.produk')
        ->where('invoice', $invoice)
        ->firstOrFail();

    return view('shop.pesanan-detail', compact('pemesanan'));
});

Route::get('/pesanan/{invoice}/upload-bukti', function ($invoice) {
    $pemesanan = \App\Models\Pemesanan::where('invoice', $invoice)->firstOrFail();

    return view('shop.upload-bukti', compact('pemesanan'));
});

Route::post('/pesanan/{invoice}/upload-bukti', function ($invoice, \Illuminate\Http\Request $request) {
    $request->validate([
        'bukti_pembayaran' => ['required', 'image', 'max:2048'],
    ]);

    $pemesanan = \App\Models\Pemesanan::where('invoice', $invoice)->firstOrFail();

    $path = $request->file('bukti_pembayaran')->store('pembayaran', 'public');

    $pemesanan->update([
        'bukti_pembayaran' => $path,
        'status' => 'dibayar',
    ]);

    return redirect('/pesanan/' . $invoice)
        ->with('success', 'Bukti pembayaran berhasil diupload.');
});