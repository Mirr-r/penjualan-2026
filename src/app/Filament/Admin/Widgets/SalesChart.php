<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Pemesanan;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;
use Filament\Support\RawJs;

class SalesChart extends ChartWidget
{
    protected static ?string $heading = 'Grafik Penjualan Bulanan';

    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $months = collect(range(5, 0))
            ->map(fn ($month) => now()->subMonths($month));
            

        $labels = $months->map(fn ($date) => $date->translatedFormat('M Y'))->toArray();

        $data = $months->map(function ($date) {
            return Pemesanan::query()
                ->whereIn('status', ['dibayar', 'diproses', 'dikirim', 'selesai'])
                ->whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year)
                ->sum('total_harga');
        })->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'Total Penjualan',
                    'data' => $data,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'tooltip' => [
                    'callbacks' => [
                        'label' => RawJs::make(
                            "function(context) {
                                return 'Rp ' + context.raw.toLocaleString('id-ID');
                            }"
                        ),
                    ],
                ],
            ],
        ];
    }
}