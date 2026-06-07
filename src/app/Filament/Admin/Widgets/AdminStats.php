<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Pemesanan;
use App\Models\Produk;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AdminStats extends BaseWidget
{
    protected function getStats(): array
    {
        return [

            Stat::make(
                'Total Produk',
                Produk::count()
            ),

            Stat::make(
                'Total Pesanan',
                Pemesanan::count()
            ),

            Stat::make(
                'Pesanan Pending',
                Pemesanan::where('status', 'pending')->count()
            ),

            Stat::make(
                'Total Pendapatan',
                'Rp ' . number_format(
                    Pemesanan::where('status', 'selesai')->sum('total_harga'),
                    0,
                    ',',
                    '.'
                )
            ),

        ];
    }
}