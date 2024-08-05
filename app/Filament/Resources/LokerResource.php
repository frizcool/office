<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LokerResource\Pages;
use App\Filament\Resources\LokerResource\RelationManagers;
use App\Models\Loker;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LokerResource extends Resource
{
    protected static ?string $model = Loker::class;

    protected static ?string $navigationIcon = 'heroicon-m-lock-open';
    protected static ?string $navigationGroup = 'Utility';
    protected static ?int $navigationSort = 9;
    protected static ?string $navigationLabel = 'Loker';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama_loker')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_loker')
                    ->searchable(),
                //
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
            'index' => Pages\ManageLokers::route('/'),
        ];
    }
}
