<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Produk;
use App\Models\Pemesanan;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Produk', Produk::count())
                ->description('Jumlah produk tersedia')
                ->icon('heroicon-o-cube')
                ->color('primary'),

            Stat::make('Total Pesanan', Pemesanan::count())
                ->description('Semua pesanan customer')
                ->icon('heroicon-o-shopping-cart')
                ->color('success'),

            Stat::make('Pesanan Pending', Pemesanan::where('status', 'pending')->count())
                ->description('Menunggu pembayaran')
                ->icon('heroicon-o-clock')
                ->color('warning'),

            Stat::make('Total Pendapatan', 'Rp ' . number_format(
                Pemesanan::whereIn('status', ['dibayar', 'diproses', 'dikirim', 'selesai'])
                    ->sum('total_harga'),
                0,
                ',',
                '.'
            ))
                ->description('Pendapatan dari pesanan valid')
                ->icon('heroicon-o-banknotes')
                ->color('success'),

            Stat::make('Total User', User::count())
                ->description('Jumlah pengguna sistem')
                ->icon('heroicon-o-users')
                ->color('info'),
        ];
    }
}