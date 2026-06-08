<div>
    <section class="bg-white border-b">
        <div class="max-w-7xl mx-auto px-6 py-4 flex gap-4 overflow-x-auto">
            <button
                type="button"
                wire:click="$set('kategori', '')"
                class="px-5 py-2 rounded-full font-semibold {{ !$kategori ? 'bg-blue-700 text-white' : 'bg-slate-100' }}"
            >
                Semua
            </button>

            @foreach ($kategoris as $item)
                <button
                    type="button"
                    wire:click="$set('kategori', '{{ $item->slug }}')"
                    class="px-5 py-2 rounded-full font-semibold {{ $kategori === $item->slug ? 'bg-blue-700 text-white' : 'bg-slate-100' }}"
                >
                    {{ $item->nama }}
                </button>
            @endforeach
        </div>
    </section>

    <section id="produk" class="max-w-7xl mx-auto px-6 py-12">
        <div class="mb-8">
            <h2 class="text-4xl font-black">Produk Taekwondo</h2>
            <p class="text-slate-500 mt-2">Daftar perlengkapan yang tersedia</p>

            <input
                type="text"
                wire:model.live="search"
                placeholder="Cari produk atau merek..."
                class="w-full bg-white border rounded-2xl px-5 py-3 mt-6"
            >
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
                                <p>
                                    Stok:
                                    @if ($produk->stok > 0)
                                        <span class="font-bold text-green-600">{{ $produk->stok }}</span>
                                    @else
                                        <span class="font-bold text-red-600">Habis</span>
                                    @endif
                                </p>
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
</div>