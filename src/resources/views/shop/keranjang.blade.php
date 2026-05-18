<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Keranjang</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-100">

<div class="max-w-5xl mx-auto px-6 py-10">

    <div class="flex justify-between items-center mb-8">
        <h1 class="text-4xl font-black">Keranjang Belanja</h1>

        <a href="/" class="bg-blue-700 text-white px-5 py-3 rounded-2xl font-bold">
            Kembali Belanja
        </a>
        <a href="/pesanan" class="hover:text-blue-700">
    Pesanan
</a>
    </div>

    @php $total = 0; @endphp

    @forelse ($keranjang as $id => $item)
        @php
            $subtotal = $item['harga'] * $item['qty'];
            $total += $subtotal;
        @endphp

        <div class="bg-white rounded-3xl shadow-sm p-6 mb-6">
            <div class="flex items-center gap-6">
                <div class="w-44 h-44 bg-slate-100 rounded-2xl flex items-center justify-center overflow-hidden shrink-0">
                    <img
                        src="{{ asset('storage/' . $item['gambar']) }}"
                        alt="{{ $item['nama'] }}"
                        class="w-32 h-32 object-contain"
                    >
                </div>

                <div class="flex-1">
                    <h2 class="text-2xl font-black leading-tight">
                        {{ $item['nama'] }}
                    </h2>

                   <div class="flex items-center gap-3 mt-3">

                <form action="/keranjang/{{ $id }}/kurang" method="POST">
                    @csrf

                    <button class="w-10 h-10 bg-slate-200 rounded-xl font-bold">
                        -
                    </button>
                </form>

                <span class="font-bold text-lg">
                    {{ $item['qty'] }}
                </span>

                <form action="/keranjang/{{ $id }}/tambah" method="POST">
                    @csrf

                    <button class="w-10 h-10 bg-blue-700 text-white rounded-xl font-bold">
                        +
                    </button>
                </form>

                <form action="/keranjang/{{ $id }}/hapus" method="POST" class="ml-4">
                    @csrf

                    <button class="text-red-600 font-bold">
                        Hapus
                    </button>
                </form>

            </div>

                    <p class="text-3xl font-black text-blue-700 mt-4">
                        Rp {{ number_format($subtotal, 0, ',', '.') }}
                    </p>
                </div>
            </div>
        </div>

    @empty
        <div class="bg-white rounded-3xl p-10 text-center">
            <h2 class="text-2xl font-bold">Keranjang kosong</h2>
        </div>
    @endforelse

    @if ($total > 0)
        <div class="bg-white rounded-3xl p-8 mt-10 shadow-sm">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-slate-500">Total Belanja</p>

                    <h2 class="text-4xl font-black text-blue-700">
                        Rp {{ number_format($total, 0, ',', '.') }}
                    </h2>
                </div>

                <form action="/checkout" method="POST">
                    @csrf

                    <button
                        type="submit"
                        class="bg-blue-700 hover:bg-blue-800 text-white px-8 py-4 rounded-2xl font-bold text-lg"
                    >
                        Checkout
                    </button>
                </form>
            </div>
        </div>
    @endif

</div>

</body>
</html>