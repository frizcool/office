<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SifatResource\Pages;
use App\Filament\Resources\SifatResource\RelationManagers;
use App\Models\Sifat;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SifatResource extends Resource
{
    protected static ?string $model = Sifat::class;

    protected static ?string $navigationIcon = 'heroicon-m-folder';

    protected static ?string $navigationGroup = 'Utility';
    protected static ?int $navigationSort = 4;
    protected static ?string $navigationLabel = 'Sifat';
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('ur_sifat'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('ur_sifat')
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
                Tables\Actions\ActionGroup::make([               
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ]),
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
            'index' => Pages\ListSifats::route('/'),
            'create' => Pages\CreateSifat::route('/create'),
            // 'edit' => Pages\EditSifat::route('/{record}/edit'),
        ];
    }
}
