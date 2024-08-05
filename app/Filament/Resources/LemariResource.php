<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LemariResource\Pages;
use App\Filament\Resources\LemariResource\RelationManagers;
use App\Models\Lemari;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LemariResource extends Resource
{
    protected static ?string $model = Lemari::class;

    protected static ?string $navigationIcon = 'heroicon-m-cube';
    protected static ?string $navigationGroup = 'Utility';
    protected static ?int $navigationSort = 8;
    protected static ?string $navigationLabel = 'Lemari';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama_lemari')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_lemari')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageLemaris::route('/'),
        ];
    }
}
