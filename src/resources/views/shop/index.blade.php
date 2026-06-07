<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>ONE-CLICK TKD</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
@livewireScripts

<body class="bg-slate-100 text-slate-900">

<nav class="bg-white border-b shadow-sm">
    <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
        <div>
            <h3 class="text-2xl font-black text-blue-700">
    {{ $setting->nama_toko ?? 'ONE-CLICK TKD' }}
            </h3>

            <p class="text-slate-500 mt-2">
                {{ $setting->deskripsi ?? 'Sistem penjualan perlengkapan taekwondo berbasis web.' }}
            </p>
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

<livewire:produk-list />


<footer class="bg-white border-t mt-16">
    <div class="max-w-7xl mx-auto px-6 py-10 grid md:grid-cols-3 gap-8">

        <div>
            <h3 class="text-2xl font-black text-blue-700">ONE-CLICK TKD</h3>
            <p class="text-slate-500 mt-2">
                Sistem penjualan perlengkapan taekwondo berbasis web.
            </p>
        </div>

        <div>
            <h4 class="font-bold mb-3">Kontak</h4>
            <p class="text-slate-500">
                WhatsApp: {{ $setting->whatsapp ?? '-' }}
            </p>

            <p class="text-slate-500">
                Email: {{ $setting->email ?? '-' }}
            </p>

            <p class="text-slate-500">
                Instagram: {{ $setting->instagram ?? '-' }}
            </p>

            <p class="text-slate-500">
                Alamat: {{ $setting->alamat ?? '-' }}
            </p>
        </div>

        <div>
            <h4 class="font-bold mb-3">Pembayaran</h4>
            <p class="text-slate-500">
                Transfer manual lalu upload bukti pembayaran melalui halaman pesanan.
            </p>
        </div>

    </div>

    <div class="border-t text-center text-slate-500 py-5">
        © {{ date('Y') }} {{ $setting->nama_toko ?? 'ONE-CLICK TKD' }}
    </div>
</footer>

</body>
</html>