<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\PemesananResource\Pages;
use App\Filament\Admin\Resources\PemesananResource\RelationManagers;
use App\Models\Pemesanan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;

use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;

class PemesananResource extends Resource
{
    protected static ?string $model = Pemesanan::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
       return $form
        ->schema([
          

            TextInput::make('invoice')
                ->required(),

            TextInput::make('total_harga')
                ->numeric()
                ->required(),

            Select::make('status')
                ->options([
                    'pending' => 'Pending',
                    'dibayar' => 'Dibayar',
                    'diproses' => 'Diproses',
                    'dikirim' => 'Dikirim',
                    'selesai' => 'Selesai',
                    'dibatalkan' => 'Dibatalkan',
                ])
                ->default('pending')
                ->required(),

            FileUpload::make('bukti_pembayaran')
                ->image()
                ->disk('public')
                ->directory('pembayaran'),

            Textarea::make('catatan')
                ->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
     return $table
        ->columns([
            TextColumn::make('invoice')
                ->searchable(),

            TextColumn::make('total_harga')
                ->money('IDR'),

            Tables\Columns\BadgeColumn::make('status')
                ->colors([
                    'warning' => 'pending',
                    'primary' => 'dibayar',
                    'info' => 'diproses',
                    'success' => 'selesai',
                    'danger' => 'dibatalkan',
                    'gray' => 'dikirim',
                ]),
            ImageColumn::make('bukti_pembayaran')
                ->disk('public')
                ->label('Bukti'),


            TextColumn::make('created_at')
                ->dateTime(),
        ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPemesanans::route('/'),
            'create' => Pages\CreatePemesanan::route('/create'),
            'edit' => Pages\EditPemesanan::route('/{record}/edit'),
        ];
    }
}
