<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SatminkalResource\Pages;
use App\Filament\Resources\SatminkalResource\RelationManagers;
use App\Models\Satminkal;
use App\Models\Kotama; 
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;

use Filament\Tables\Filters\SelectFilter;
class SatminkalResource extends Resource
{
    protected static ?string $model = Satminkal::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Utility';
    protected static ?int $navigationSort = 2;
    protected static ?string $navigationLabel = 'Satminkal';
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Forms\Components\TextInput::make('kd_ktm')
                //     ->required(),

                Forms\Components\Select::make('kd_ktm')
                    ->label('Kotama')
                    ->options(Kotama::all()->pluck('ur_ktm', 'kd_ktm'))
                    ->required()->searchable(),
                Forms\Components\TextInput::make('kd_smk')
                    ->required(),
                Forms\Components\TextInput::make('ur_smk')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Tables\Columns\TextColumn::make('kd_ktm')
                //     ->searchable(),

                Tables\Columns\TextColumn::make('kotama.ur_ktm')
                    ->label('Kotama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('kd_smk')
                    ->searchable(),
                Tables\Columns\TextColumn::make('ur_smk')
                    ->searchable(),
                // Tables\Columns\TextColumn::make('created_at')
                //     ->dateTime()
                //     ->sortable()
                //     ->toggleable(isToggledHiddenByDefault: true),
                // Tables\Columns\TextColumn::make('updated_at')
                //     ->dateTime()
                //     ->sortable()
                //     ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
                SelectFilter::make('kd_ktm')->label('Kotama')
                    ->options(fn (): array => Kotama::query()->pluck('ur_ktm', 'kd_ktm')->all())
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(),
                    DeleteAction::make(),
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
            'index' => Pages\ListSatminkals::route('/'),
            'create' => Pages\CreateSatminkal::route('/create'),
            'edit' => Pages\EditSatminkal::route('/{record}/edit'),
        ];
    }
}
