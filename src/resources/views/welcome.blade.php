<!-- <!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Sistem Penjualan Alat Taekwondo</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    <nav class="bg-white shadow px-8 py-4 flex justify-between">
        <h1 class="font-bold text-xl text-blue-700">One Click TKD</h1>
        <a href="/admin" class="text-blue-600 font-semibold">Admin</a>
    </nav>

    <section class="px-8 py-8">
        <h2 class="text-2xl font-bold mb-6">Produk Taekwondo</h2>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            @foreach ($produks as $produk)
                <div class="bg-white rounded-xl shadow p-4">
                    <img
                        src="{{ asset('storage/' . $produk->gambar) }}"
                        class="w-full h-48 object-cover rounded-lg mb-4"
                        alt="{{ $produk->nama }}"
                    >

                    <h3 class="font-bold">{{ $produk->nama }}</h3>
                    <p class="text-sm text-gray-500">{{ $produk->kategori?->nama }}</p>

                    <p class="font-bold text-blue-700 mt-2">
                        Rp {{ number_format($produk->harga, 0, ',', '.') }}
                    </p>

                    <p class="text-sm text-gray-500">Stok: {{ $produk->stok }}</p>

                    <button class="mt-4 w-full bg-blue-600 text-white py-2 rounded-lg font-semibold">
                        Detail
                    </button>
                </div>
            @endforeach
        </div>
    </section>
</body>
</html> -->