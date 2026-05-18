<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\ProdukResource\Pages;
use App\Filament\Admin\Resources\ProdukResource\RelationManagers;
use App\Models\Produk;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Textarea;
use Illuminate\Support\Str;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;    

class ProdukResource extends Resource
{
    protected static ?string $model = Produk::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
      return $form
        ->schema([
            TextInput::make('nama')
                ->required()
                ->live(onBlur: true)
                ->afterStateUpdated(fn ($state, callable $set) =>
                    $set('slug', Str::slug($state))
                ),

            TextInput::make('slug')
                ->required()
                ->readOnly(),
            Select::make('kategori_id')
                ->relationship('kategori', 'nama')
                ->searchable()
                ->required(),
             
                
                
            TextInput::make('harga')
                ->numeric()
                ->required(),

            TextInput::make('stok')
                ->numeric()
                ->required(),

            TextInput::make('merk'),

            TextInput::make('ukuran'),

            FileUpload::make('gambar')
                ->image()
                ->directory('produk'),

            Toggle::make('is_active')
                ->default(true),

            Textarea::make('deskripsi')
                ->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama')
                    ->searchable(),

                TextColumn::make('kategori.nama')
                    ->badge(),

                TextColumn::make('harga')
                    ->money('IDR'),

                TextColumn::make('stok'),

                IconColumn::make('is_active')
                    ->boolean(),

                ImageColumn::make('gambar'),
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
            'index' => Pages\ListProduks::route('/'),
            'create' => Pages\CreateProduk::route('/create'),
            'edit' => Pages\EditProduk::route('/{record}/edit'),
        ];
    }
}
