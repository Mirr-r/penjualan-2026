<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Upload Bukti Pembayaran</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-100">

<div class="min-h-screen flex items-center justify-center px-6">
    <div class="bg-white max-w-xl w-full rounded-3xl shadow-sm p-10">

        <h1 class="text-3xl font-black">Upload Bukti Pembayaran</h1>

        <p class="text-slate-500 mt-2">
            Invoice: <span class="font-bold text-blue-700">{{ $pemesanan->invoice }}</span>
        </p>

        <p class="text-3xl font-black text-blue-700 mt-6">
            Rp {{ number_format($pemesanan->total_harga, 0, ',', '.') }}
        </p>

        <form action="/pesanan/{{ $pemesanan->invoice }}/upload-bukti" method="POST" enctype="multipart/form-data" class="mt-8">
            @csrf

            <label class="block font-bold mb-2">
                Bukti Pembayaran
            </label>

            <input
                type="file"
                name="bukti_pembayaran"
                accept="image/*"
                required
                class="w-full border rounded-2xl p-4 bg-slate-50"
            >

            @error('bukti_pembayaran')
                <p class="text-red-600 mt-2">{{ $message }}</p>
            @enderror

            <button
                type="submit"
                class="w-full bg-blue-700 hover:bg-blue-800 text-white py-4 rounded-2xl font-bold mt-6"
            >
                Upload Bukti
            </button>
        </form>

        <a href="/pesanan/{{ $pemesanan->invoice }}" class="block text-center mt-6 font-semibold text-slate-600">
            Kembali ke Detail Pesanan
        </a>

    </div>
</div>

</body>
</html>