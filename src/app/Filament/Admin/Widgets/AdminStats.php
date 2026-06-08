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
            )
                ->description('Produk tersedia')
                ->icon('heroicon-o-cube')
                ->color('primary'),

            Stat::make(
                'Total Pesanan',
                Pemesanan::count()
            )
                ->description('Semua pesanan')
                ->icon('heroicon-o-shopping-cart')
                ->color('success'),

            Stat::make(
                'Pesanan Pending',
                Pemesanan::where('status', 'pending')->count()
            )
                ->description('Menunggu pembayaran')
                ->icon('heroicon-o-clock')
                ->color('warning'),

            Stat::make(
                'Total Pendapatan',
                'Rp ' . number_format(
                    Pemesanan::whereIn('status', [
                        'dibayar',
                        'diproses',
                        'dikirim',
                        'selesai',
                    ])->sum('total_harga'),
                    0,
                    ',',
                    '.'
                )
            )
                ->description('Pendapatan valid')
                ->icon('heroicon-o-banknotes')
                ->color('success'),

            Stat::make(
                'Total User',
                \App\Models\User::count()
            )
                ->description('Pengguna terdaftar')
                ->icon('heroicon-o-users')
                ->color('info'),

        ];
    }
}