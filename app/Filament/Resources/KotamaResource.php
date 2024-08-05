<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KotamaResource\Pages;
use App\Filament\Resources\KotamaResource\RelationManagers;
use App\Models\Kotama;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class KotamaResource extends Resource
{
    protected static ?string $model = Kotama::class;

    protected static ?string $navigationIcon = 'heroicon-s-building-library';
    protected static ?string $navigationGroup = 'Utility';
    protected static ?int $navigationSort = 1;
    protected static ?string $navigationLabel = 'Kotama';
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('kd_ktm')
                    ->required(),
                Forms\Components\TextInput::make('ur_ktm')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('kd_ktm')
                    ->searchable(),
                Tables\Columns\TextColumn::make('ur_ktm')
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
    protected function getHeaderActions(): array
    {
        return [
            \EightyNine\ExcelImport\ExcelImportAction::make()
                ->color("primary"),
            // Actions\CreateAction::make(),
        ];
    }   
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListKotamas::route('/'),
            'create' => Pages\CreateKotama::route('/create'),
            'edit' => Pages\EditKotama::route('/{record}/edit'),
        ];
    }
}
