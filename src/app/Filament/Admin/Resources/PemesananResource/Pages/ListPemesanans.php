<?php

namespace App\Filament\Admin\Resources\PemesananResource\Pages;

use App\Filament\Admin\Resources\PemesananResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPemesanans extends ListRecords
{
    protected static string $resource = PemesananResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
