<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KopstukResource\Pages;
use App\Filament\Resources\KopstukResource\RelationManagers;
use App\Models\Satminkal;
use App\Models\Kotama; 
use App\Models\Kopstuk;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn;
class KopstukResource extends Resource
{
    protected static ?string $model = Kopstuk::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Utility';
    protected static ?int $navigationSort = 7;
    protected static ?string $navigationLabel = 'Kopstuk';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('kd_ktm')
                    ->label('Kotama')
                    ->options(Kotama::all()->pluck('ur_ktm', 'kd_ktm'))
                    ->required()->searchable()              
                    ->reactive()  
                    ->afterStateUpdated(fn(callable $set)=>$set('kd_smk',null)) ,
                Forms\Components\Select::make('kd_smk')
                    ->label('Satminkal')
                    ->options(function (callable $get){
                        if($get('kd_ktm')){
                            return Satminkal::where('kd_ktm',$get('kd_ktm'))->pluck('ur_smk', 'kd_smk');
                        }else{
                            return Satminkal::all()->pluck('ur_smk', 'kd_smk');
                        }   
                    })
                    ->required()->searchable(),                    
                Forms\Components\Textarea::make('ur_kopstuk')
// Suggested code may be subject to a license. Learn more: ~LicenseLog:2495151049.
                ->label('Kopstuk')
                ->rows(5)
                ->required(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('ur_kopstuk')->label('Uraian Kopstuk')
                    ->searchable()->limit(100)->wrap(),
                TextColumn::make('kotama.ur_ktm')
                    ->label('Kotama')
                    ->searchable(),
                TextColumn::make('satminkal.ur_smk')
                    ->label('Satminkal')
                    ->searchable()
                    ->default(function ($record) { 
                        $row=Satminkal::where('kd_ktm',$record->kd_ktm)->where('kd_smk',$record->kd_smk)->first();
                        return $row->ur_smk;
                    }),  
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
            'index' => Pages\ListKopstuks::route('/'),
            'create' => Pages\CreateKopstuk::route('/create'),
            // 'edit' => Pages\EditKopstuk::route('/{record}/edit'),
        ];
    }
}
