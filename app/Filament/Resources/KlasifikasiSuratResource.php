<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KlasifikasiSuratResource\Pages;
use App\Filament\Resources\KlasifikasiSuratResource\RelationManagers;
use App\Models\KlasifikasiSurat;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class KlasifikasiSuratResource extends Resource
{
    protected static ?string $model = KlasifikasiSurat::class;

    protected static ?string $navigationIcon = 'heroicon-m-squares-2x2';
    protected static ?string $navigationGroup = 'Utility';
    protected static ?int $navigationSort = 3;
    protected static ?string $navigationLabel = 'Klasifikasi';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('ur_klasifikasi')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('ur_klasifikasi')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListKlasifikasiSurats::route('/'),
            'create' => Pages\CreateKlasifikasiSurat::route('/create'),
            'edit' => Pages\EditKlasifikasiSurat::route('/{record}/edit'),
        ];
    }
}
