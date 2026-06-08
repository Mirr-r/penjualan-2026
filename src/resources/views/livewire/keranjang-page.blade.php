<div class="max-w-5xl mx-auto px-6 py-10">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-4xl font-black">Keranjang Belanja</h1>
            <p class="text-slate-500 mt-2">Produk yang sudah kamu pilih</p>
        </div>

        <a href="/" class="bg-blue-700 text-white px-6 py-3 rounded-2xl font-bold">
            Lanjut Belanja
        </a>
    </div>

    @if (count($keranjang))
        <div class="space-y-5">
            @foreach ($keranjang as $id => $item)
                <div class="bg-white rounded-3xl border shadow-sm p-5 flex flex-col md:flex-row md:items-center justify-between gap-5">
                    <div>
                        <h2 class="text-2xl font-black">
                            {{ $item['nama'] }}
                        </h2>

                        <p class="text-slate-500 mt-1">
                            Harga: Rp {{ number_format($item['harga'], 0, ',', '.') }}
                        </p>

                        <p class="text-slate-500">
                            Subtotal:
                            <span class="font-bold text-blue-700">
                                Rp {{ number_format($item['harga'] * $item['qty'], 0, ',', '.') }}
                            </span>
                        </p>
                    </div>

                    <div class="flex items-center gap-3">
                        <button
                            wire:click="kurangQty('{{ $id }}')"
                            class="bg-slate-200 px-4 py-2 rounded-xl font-black"
                        >
                            -
                        </button>

                        <span class="text-xl font-black min-w-8 text-center">
                            {{ $item['qty'] }}
                        </span>

                        <button
                            wire:click="tambahQty('{{ $id }}')"
                            class="bg-blue-700 text-white px-4 py-2 rounded-xl font-black"
                        >
                            +
                        </button>

                        <button
                            wire:click="hapusItem('{{ $id }}')"
                            onclick="return confirm('Hapus produk ini dari keranjang?')"
                            class="bg-red-600 text-black px-4 py-2 rounded-xl font-bold"
                        >
                            Hapus
                        </button>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="bg-white rounded-3xl border shadow-sm p-6 mt-8 flex flex-col md:flex-row justify-between items-center gap-5">
            <div>
                <p class="text-slate-500">Total Pembayaran</p>
                <h2 class="text-4xl font-black text-blue-700">
                    Rp {{ number_format($this->total, 0, ',', '.') }}
                </h2>
            </div>

            <div class="flex gap-3">
                <button
                    wire:click="kosongkan"
                    onclick="return confirm('Kosongkan keranjang?')"
                    class="bg-slate-200 px-6 py-3 rounded-2xl font-bold"
                >
                    Kosongkan
                </button>

                <form action="/checkout" method="POST">
                    @csrf

                    <button
                        type="submit"
                        class="bg-green-600 text-black px-8 py-3 rounded-2xl font-bold"
                    >
                        Checkout
                    </button>
                </form>
            </div>
        </div>
    @else
        <div class="bg-white rounded-3xl border p-12 text-center">
            <h2 class="text-2xl font-black">Keranjang masih kosong</h2>
            <p class="text-slate-500 mt-2">Silakan pilih produk terlebih dahulu.</p>

            <a href="/" class="inline-block mt-6 bg-blue-700 text-white px-6 py-3 rounded-2xl font-bold">
                Belanja Sekarang
            </a>
        </div>
    @endif
</div>