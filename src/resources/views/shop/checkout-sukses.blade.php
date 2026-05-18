<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Checkout Berhasil</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-100">

<div class="min-h-screen flex items-center justify-center px-6">

    <div class="bg-white max-w-xl w-full rounded-3xl shadow-sm p-12 text-center">

        <div class="w-24 h-24 bg-green-100 rounded-full flex items-center justify-center mx-auto">
            <span class="text-5xl">✅</span>
        </div>

        <h1 class="text-5xl font-black mt-8 text-slate-900">
            Checkout Berhasil
        </h1>

        <p class="text-slate-500 text-lg mt-4">
            Pesanan kamu berhasil dibuat.
        </p>

        <div class="bg-slate-100 rounded-2xl p-5 mt-8">
            <p class="text-slate-500 text-sm">
                Nomor Invoice
            </p>

            <h2 class="text-3xl font-black text-blue-700 mt-2">
                {{ $invoice }}
            </h2>
        </div>

        <div class="mt-10 flex flex-col sm:flex-row gap-4 justify-center">

            <a
                href="/"
                class="bg-blue-700 hover:bg-blue-800 text-white px-8 py-4 rounded-2xl font-bold transition"
            >
                Kembali Belanja
            </a>

            <a
                href="/admin/pemesanans"
                class="bg-slate-200 hover:bg-slate-300 text-slate-800 px-8 py-4 rounded-2xl font-bold transition"
            >
                Lihat Pesanan
            </a>

        </div>

    </div>

</div>

</body>
</html>