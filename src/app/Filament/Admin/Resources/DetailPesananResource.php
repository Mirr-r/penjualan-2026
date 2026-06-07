<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\DetailPesananResource\Pages;
use App\Filament\Admin\Resources\DetailPesananResource\RelationManagers;
use App\Models\DetailPesanan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DetailPesananResource extends Resource
{
    protected static ?string $model = DetailPesanan::class;
    
    protected static ?string $navigationLabel = 'Detail Pesanan';
    protected static ?string $modelLabel = 'Detail Pesanan';
    protected static ?string $pluralModelLabel = 'Detail Pesanan';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('pemesanan_id')
                    ->relationship('pemesanan', 'invoice')
                    ->searchable()
                    ->preload()
                    ->required(),

                Select::make('produk_id')
                    ->relationship('produk', 'nama')
                    ->searchable()
                    ->required()
                    ->live()
                    ->afterStateUpdated(function ($state, callable $set) {
                        $produk = \App\Models\Produk::find($state);

                        if ($produk) {
                            $set('harga', $produk->harga);
                        }
                    }),

                TextInput::make('qty')
                    ->numeric()
                    ->required()
                    ->live()
                    ->afterStateUpdated(function ($state, callable $get, callable $set) {
                        $set('subtotal', (int) $state * (int) $get('harga'));
                    }),

                TextInput::make('harga')
                    ->numeric()
                    ->required()
                    ->live()
                    ->afterStateUpdated(function ($state, callable $get, callable $set) {
                        $set('subtotal', (int) $state * (int) $get('qty'));
                    }),

                TextInput::make('subtotal')
                    ->numeric()
                    ->required()
                    ->readOnly(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('pemesanan.invoice')
                    ->searchable(),

                TextColumn::make('produk.nama')
                    ->searchable(),

                TextColumn::make('qty'),

                TextColumn::make('harga')
                    ->money('IDR'),

                TextColumn::make('subtotal')
                    ->money('IDR'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListDetailPesanans::route('/'),
            'create' => Pages\CreateDetailPesanan::route('/create'),
            'edit' => Pages\EditDetailPesanan::route('/{record}/edit'),
        ];
    }
}
