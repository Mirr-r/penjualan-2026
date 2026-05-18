<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>ONE-CLICK TKD</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-100 text-slate-900">

<nav class="bg-white border-b shadow-sm">
    <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-black text-blue-700">ONE-CLICK TKD</h1>
            <p class="text-sm text-slate-500">Sistem Penjualan Alat Taekwondo</p>
        </div>

        <div class="flex gap-6 font-semibold">
            <a href="#produk" class="hover:text-blue-700">Produk</a>
            <a href="/keranjang" class="hover:text-blue-700">Keranjang</a>
            <a href="/admin" class="hover:text-blue-700">Admin</a>
            <a href="/pesanan" class="hover:text-blue-700">Pesanan</a>
        </div>
    </div>
</nav>

<section class="bg-blue-700 text-white">
    <div class="max-w-7xl mx-auto px-6 py-20 grid md:grid-cols-2 gap-10 items-center">
        <div>
            <h2 class="text-5xl font-black leading-tight">
                Perlengkapan Taekwondo Lengkap
            </h2>

            <p class="mt-6 text-blue-100 text-lg">
                Temukan dobok, pelindung, alat latihan, dan perlengkapan taekwondo berkualitas terbaik.
            </p>

            <a href="#produk" class="inline-block mt-8 bg-white text-blue-700 px-8 py-4 rounded-2xl font-bold">
                Belanja Sekarang
            </a>
        </div>

        <div class="hidden md:flex justify-center">
            <div class="text-[180px]">🥋</div>
        </div>
    </div>
</section>

<section class="bg-white border-b">
    <div class="max-w-7xl mx-auto px-6 py-4 flex gap-4 overflow-x-auto">
        <a href="/" class="px-5 py-2 rounded-full font-semibold {{ !$kategori ? 'bg-blue-700 text-white' : 'bg-slate-100' }}">
            Semua
        </a>

        @foreach ($kategoris as $item)
            <a
                href="/?kategori={{ $item->slug }}"
                class="px-5 py-2 rounded-full font-semibold {{ $kategori == $item->slug ? 'bg-blue-700 text-white' : 'bg-slate-100' }}"
            >
                {{ $item->nama }}
            </a>
        @endforeach
    </div>
</section>

<section id="produk" class="max-w-7xl mx-auto px-6 py-12">
    <div class="mb-8">
        <h2 class="text-4xl font-black">Produk Taekwondo</h2>
        <p class="text-slate-500 mt-2">Daftar perlengkapan yang tersedia</p>

        <form action="/" method="GET" class="mt-6 flex gap-3">
            @if ($kategori)
                <input type="hidden" name="kategori" value="{{ $kategori }}">
            @endif

            <input
                type="text"
                name="search"
                value="{{ $search ?? '' }}"
                placeholder="Cari produk atau merek..."
                class="w-full bg-white border rounded-2xl px-5 py-3"
            >

            <button
                type="submit"
                class="bg-blue-700 text-white px-6 py-3 rounded-2xl font-bold"
            >
                Cari
            </button>
        </form>
    </div>

    @if ($produks->count())
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
            @foreach ($produks as $produk)
                <div class="bg-white rounded-3xl shadow-sm border overflow-hidden hover:shadow-xl transition">
                    <div class="h-72 bg-slate-100 flex items-center justify-center p-6">
                        @if ($produk->gambar)
                            <img
                                src="{{ asset('storage/' . $produk->gambar) }}"
                                alt="{{ $produk->nama }}"
                                class="max-h-full object-contain"
                            >
                        @else
                            <span class="text-slate-400">Tidak ada gambar</span>
                        @endif
                    </div>

                    <div class="p-5">
                        <p class="text-sm text-blue-700 font-bold uppercase">
                            {{ $produk->kategori?->nama }}
                        </p>

                        <h3 class="text-xl font-black mt-2 leading-tight">
                            {{ $produk->nama }}
                        </h3>

                        <p class="text-2xl text-blue-700 font-black mt-4">
                            Rp {{ number_format($produk->harga, 0, ',', '.') }}
                        </p>

                        <div class="mt-4 space-y-1 text-sm text-slate-500">
                            <p>Merk: <span class="font-semibold text-slate-700">{{ $produk->merk ?? '-' }}</span></p>
                            <p>Ukuran: <span class="font-semibold text-slate-700">{{ $produk->ukuran ?? '-' }}</span></p>
                            <p>Stok: <span class="font-semibold text-slate-700">{{ $produk->stok }}</span></p>
                        </div>

                        <a
                            href="{{ url('/produk/' . $produk->slug) }}"
                            class="block text-center w-full mt-6 bg-blue-700 hover:bg-blue-800 text-white py-3 rounded-2xl font-bold transition"
                        >
                            Detail Produk
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="bg-white rounded-3xl p-12 text-center border">
            <p class="text-slate-500 text-lg">Produk tidak ditemukan.</p>
        </div>
    @endif
</section>

<footer class="bg-white border-t mt-16">
    <div class="max-w-7xl mx-auto px-6 py-8 text-center text-slate-500">
        © {{ date('Y') }} ONE-CLICK TKD - Sistem Penjualan Alat Taekwondo
    </div>
</footer>

</body>
</html>