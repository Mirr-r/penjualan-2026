<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\SettingResource\Pages;
use App\Models\Setting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SettingResource extends Resource
{
    protected static ?string $model = Setting::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?string $navigationLabel = 'Setting Website';

    protected static ?string $modelLabel = 'Setting Website';

    protected static ?string $pluralModelLabel = 'Setting Website';

    protected static ?string $navigationGroup = 'Pengaturan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Toko')
                    ->schema([
                        Forms\Components\TextInput::make('nama_toko')
                            ->label('Nama Toko')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('tagline')
                            ->label('Tagline')
                            ->maxLength(255),

                        Forms\Components\Textarea::make('deskripsi')
                            ->label('Deskripsi')
                            ->rows(4),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Kontak')
                    ->schema([
                        Forms\Components\TextInput::make('whatsapp')
                            ->label('WhatsApp')
                            ->placeholder('628xxxxxxxxxx')
                            ->maxLength(255),

                        Forms\Components\TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('instagram')
                            ->label('Instagram')
                            ->placeholder('@oneclicktkd')
                            ->maxLength(255),

                        Forms\Components\Textarea::make('alamat')
                            ->label('Alamat')
                            ->rows(3),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_toko')
                    ->label('Nama Toko')
                    ->searchable(),

                Tables\Columns\TextColumn::make('whatsapp')
                    ->label('WhatsApp'),

                Tables\Columns\TextColumn::make('email')
                    ->label('Email'),

                Tables\Columns\TextColumn::make('instagram')
                    ->label('Instagram'),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Terakhir Diubah')
                    ->dateTime('d M Y H:i'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([]);
    }

    public static function canCreate(): bool
    {
        return Setting::count() === 0;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSettings::route('/'),
            'create' => Pages\CreateSetting::route('/create'),
            'edit' => Pages\EditSetting::route('/{record}/edit'),
        ];
    }
}