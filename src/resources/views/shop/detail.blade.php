<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ $produk->nama }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-100">

<nav class="bg-white border-b">
    <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
        <div>
            <a href="/" class="text-3xl font-black text-blue-700">ONE-CLICK TKD</a>
            <p class="text-sm text-slate-500">Sistem Penjualan Alat Taekwondo</p>
        </div>

        <div class="flex gap-6 font-semibold">
            <a href="/" class="hover:text-blue-700">Produk</a>
            <a href="/keranjang" class="hover:text-blue-700">Keranjang</a>
            <a href="/" class="hover:text-blue-700">Kembali</a>
            <a href="/pesanan" class="hover:text-blue-700">
    Pesanan
</a>
        </div>
    </div>
</nav>

<div class="max-w-7xl mx-auto px-6 py-10">

    @if (session('success'))
        <div class="mb-6 bg-green-100 border border-green-300 text-green-700 px-6 py-4 rounded-2xl font-semibold">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
    <div class="mb-6 bg-red-100 border border-red-300 text-red-700 px-6 py-4 rounded-2xl font-semibold">
        {{ session('error') }}
    </div>
    @endif

    <div class="bg-white rounded-3xl shadow-sm overflow-hidden grid md:grid-cols-2 gap-10 p-8">
        <div class="bg-slate-100 rounded-3xl flex items-center justify-center p-10">
            @if ($produk->gambar)
                <img
                    src="{{ asset('storage/' . $produk->gambar) }}"
                    alt="{{ $produk->nama }}"
                    class="max-h-[500px] object-contain"
                >
            @else
                <p class="text-slate-400">Tidak ada gambar</p>
            @endif
        </div>

        <div>
            <p class="text-sm font-bold text-blue-700 uppercase tracking-wider">
                {{ $produk->kategori?->nama }}
            </p>

            <h1 class="text-4xl font-black mt-3">
                {{ $produk->nama }}
            </h1>

            <p class="text-4xl font-black text-blue-700 mt-6">
                Rp {{ number_format($produk->harga, 0, ',', '.') }}
            </p>

            <div class="mt-8 space-y-3 text-slate-600">
                <div class="flex justify-between border-b pb-2">
                    <span>Merk</span>
                    <span class="font-semibold">{{ $produk->merk ?? '-' }}</span>
                </div>

                <div class="flex justify-between border-b pb-2">
                    <span>Ukuran</span>
                    <span class="font-semibold">{{ $produk->ukuran ?? '-' }}</span>
                </div>

                <div class="flex justify-between border-b pb-2">
                    <span>Stok</span>
                    <span class="font-semibold">{{ $produk->stok }}</span>
                </div>
            </div>

            <div class="mt-10">
                <h2 class="text-xl font-bold mb-3">Deskripsi Produk</h2>

                <p class="text-slate-600 leading-relaxed">
                    {{ $produk->deskripsi ?? 'Tidak ada deskripsi produk.' }}
                </p>
            </div>

            <form action="/keranjang/{{ $produk->id }}" method="POST">
                @csrf

                @if ($produk->stok > 0)
                <form action="/keranjang/{{ $produk->id }}" method="POST">
                    @csrf

                    <button
                        type="submit"
                        class="w-full mt-10 bg-blue-700 hover:bg-blue-800 text-white py-4 rounded-2xl font-bold text-lg transition"
                    >
                        Tambah ke Keranjang
                    </button>
                </form>
            @else
                <button
                    disabled
                    class="w-full mt-10 !bg-slate-400 !text-white py-4 rounded-2xl font-bold text-lg cursor-not-allowed"
                >
                    Stok Habis
                </button>
            @endif
            </form>
        </div>
    </div>
</div>

</body>
</html>