<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pesanan Saya</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-100">

<div class="max-w-6xl mx-auto px-6 py-10">

    <div class="flex justify-between items-center mb-10">

        <div>
            <h1 class="text-4xl font-black">
                Riwayat Pesanan
            </h1>

            <p class="text-slate-500 mt-2">
                Daftar checkout yang sudah dilakukan
            </p>
        </div>

        <a
            href="/"
            class="bg-blue-700 text-white px-6 py-3 rounded-2xl font-bold"
        >
            Belanja Lagi
        </a>

    </div>

    <div class="space-y-6">

        @forelse ($pemesanans as $pemesanan)

            <div class="bg-white rounded-3xl shadow-sm p-6">

                <div class="flex justify-between items-start">

                    <div>

                        <p class="text-sm text-slate-500">
                            Invoice
                        </p>

                       <a
                            href="/pesanan/{{ $pemesanan->invoice }}"
                            class="text-2xl font-black text-blue-700 hover:underline"
                        >
                            {{ $pemesanan->invoice }}
                        </a>

                    </div>

                    <span class="px-4 py-2 rounded-full bg-yellow-100 text-yellow-700 font-bold text-sm">
                        {{ $pemesanan->status }}
                    </span>

                </div>

                <div class="mt-6 grid md:grid-cols-3 gap-6">

                    <div>
                        <p class="text-slate-500 text-sm">
                            Total
                        </p>

                        <h3 class="text-2xl font-black">
                            Rp {{ number_format($pemesanan->total_harga, 0, ',', '.') }}
                        </h3>
                    </div>

                    <div>
                        <p class="text-slate-500 text-sm">
                            Tanggal
                        </p>

                        <h3 class="font-bold">
                            {{ $pemesanan->created_at->format('d M Y H:i') }}
                        </h3>
                    </div>

                    <div>
                        <p class="text-slate-500 text-sm">
                            Catatan
                        </p>

                        <h3 class="font-bold">
                            {{ $pemesanan->catatan }}
                        </h3>
                    </div>

                </div>

            </div>

        @empty

            <div class="bg-white rounded-3xl p-10 text-center">

                <h2 class="text-2xl font-bold">
                    Belum ada pesanan
                </h2>

            </div>

        @endforelse

    </div>

</div>

</body>
</html>