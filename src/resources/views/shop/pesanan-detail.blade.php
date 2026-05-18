<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Pesanan</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-100">

<div class="max-w-6xl mx-auto px-6 py-10">

    <div class="flex justify-between items-center mb-10">
        <div>
            <h1 class="text-4xl font-black">Detail Pesanan</h1>
            <p class="text-slate-500 mt-2">{{ $pemesanan->invoice }}</p>
        </div>

        <a href="/pesanan" class="bg-blue-700 text-white px-6 py-3 rounded-2xl font-bold">
            Kembali
        </a>
    </div>

    <div class="bg-white rounded-3xl shadow-sm p-6 mb-6">
        <div class="grid md:grid-cols-3 gap-6">
            <div>
                <p class="text-slate-500 text-sm">Invoice</p>
                <h2 class="text-xl font-black text-blue-700">{{ $pemesanan->invoice }}</h2>
            </div>

            <div>
                <p class="text-slate-500 text-sm">Status</p>
                <h2 class="font-black">{{ $pemesanan->status }}</h2>
            </div>

            <div>
                <p class="text-slate-500 text-sm">Total</p>
                <h2 class="text-xl font-black">
                    Rp {{ number_format($pemesanan->total_harga, 0, ',', '.') }}
                </h2>
            </div>
            <a
                href="/pesanan/{{ $pemesanan->invoice }}/upload-bukti"
                class="inline-block mt-6 bg-blue-700 text-white px-6 py-3 rounded-2xl font-bold"
            >
                Upload Bukti Pembayaran
            </a>
        </div>
    </div>

    <div class="space-y-5">
        @foreach ($pemesanan->detailPesanans as $detail)
            <div class="bg-white rounded-3xl p-6 shadow-sm flex items-center gap-6">
                <div class="w-32 h-32 bg-slate-100 rounded-2xl flex items-center justify-center overflow-hidden">
                    @if ($detail->produk?->gambar)
                        <img
                            src="{{ asset('storage/' . $detail->produk->gambar) }}"
                            class="w-24 h-24 object-contain"
                        >
                    @endif
                </div>

                <div class="flex-1">
                    <h2 class="text-2xl font-black">
                        {{ $detail->produk?->nama }}
                    </h2>

                    <p class="text-slate-500 mt-2">
                        Qty: {{ $detail->qty }}
                    </p>

                    <p class="text-blue-700 text-2xl font-black mt-3">
                        Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                    </p>
                </div>
            </div>
        @endforeach
    </div>

</div>

</body>
</html>