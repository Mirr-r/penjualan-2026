<?php

use Illuminate\Support\Facades\Route;
use Livewire\Livewire;
use Illuminate\Support\Facades\Response;
use App\Models\Produk;
use App\Models\Pemesanan;
use App\Models\DetailPesanan;
use Midtrans\Snap;
use Midtrans\Config;
use Midtrans\Notification;
use Illuminate\Http\Request;

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

    if ($produk->stok <= 0) {
        return back()->with('error', 'Stok produk habis.');
    }

    $keranjang = session()->get('keranjang', []);

    $qtySekarang = $keranjang[$produk->id]['qty'] ?? 0;

    if ($qtySekarang + 1 > $produk->stok) {
        return back()->with('error', 'Jumlah produk melebihi stok tersedia.');
    }

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

    foreach ($keranjang as $item) {
        $produk = Produk::find($item['id']);

        if (!$produk || $produk->stok < $item['qty']) {
            return redirect('/keranjang')
                ->with('error', 'Stok produk ' . $item['nama'] . ' tidak mencukupi.');
        }
    }

    $total = collect($keranjang)->sum(fn ($item) => $item['harga'] * $item['qty']);

    $pemesanan = Pemesanan::create([
        'user_id' => 1,
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

    Config::$serverKey = config('midtrans.server_key');
    Config::$isProduction = config('midtrans.is_production');
    Config::$isSanitized = config('midtrans.is_sanitized');
    Config::$is3ds = config('midtrans.is_3ds');

    $params = [
        'transaction_details' => [
            'order_id' => $pemesanan->invoice,
            'gross_amount' => (int) $pemesanan->total_harga,
        ],
        'customer_details' => [
            'first_name' => 'Customer',
            'email' => 'customer@example.com',
        ],
    ];

    $snapToken = Snap::getSnapToken($params);

    session()->forget('keranjang');

    return view('shop.checkout-sukses', [
        'invoice' => $pemesanan->invoice,
        'snapToken' => $snapToken,
        'clientKey' => config('midtrans.client_key'),
    ]);
});

Route::post('/midtrans/callback', function (Request $request) {
    Config::$serverKey = config('midtrans.server_key');
    Config::$isProduction = config('midtrans.is_production');
    Config::$isSanitized = config('midtrans.is_sanitized');
    Config::$is3ds = config('midtrans.is_3ds');

    $notification = new Notification();

    $invoice = $notification->order_id;
    $transactionStatus = $notification->transaction_status;
    $fraudStatus = $notification->fraud_status ?? null;

    $pemesanan = Pemesanan::where('invoice', $invoice)->first();

    if (! $pemesanan) {
        return response()->json([
            'message' => 'Pemesanan tidak ditemukan',
        ], 404);
    }

    if ($transactionStatus === 'capture') {
        if ($fraudStatus === 'accept') {
            $pemesanan->update([
                'status' => 'dibayar',
                'catatan' => 'Pembayaran berhasil melalui Midtrans',
            ]);
        }
    } elseif ($transactionStatus === 'settlement') {
        $pemesanan->update([
            'status' => 'dibayar',
            'catatan' => 'Pembayaran berhasil melalui Midtrans',
        ]);
    } elseif ($transactionStatus === 'pending') {
        $pemesanan->update([
            'status' => 'pending',
            'catatan' => 'Menunggu pembayaran Midtrans',
        ]);
    } elseif (in_array($transactionStatus, ['deny', 'expire', 'cancel'])) {
        $pemesanan->update([
            'status' => 'dibatalkan',
            'catatan' => 'Pembayaran gagal atau dibatalkan melalui Midtrans',
        ]);
    }

    return response()->json([
        'message' => 'Callback berhasil diproses',
    ]);
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