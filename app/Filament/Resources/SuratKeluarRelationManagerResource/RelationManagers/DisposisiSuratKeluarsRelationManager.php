<?php

namespace App\Filament\Resources\SuratKeluarRelationManagerResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use App\Models\User;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
class DisposisiSuratKeluarsRelationManager extends RelationManager
{
    protected static string $relationship = 'disposisi_surat_keluars';

    protected static ?string $recordTitleAttribute = 'id';

    public function form(Form $form): Form
    {
        return $form
            ->schema([                
                Forms\Components\Hidden::make('created_by')->default(auth()->id()),
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
                Forms\Components\Textarea::make('keterangan'),
                Forms\Components\Select::make('status')
                    ->options([
                        'Draft' => 'Draft',
                        'Reviewed' => 'Reviewed',
                        'Approved' => 'Approved',
                    ])
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                Tables\Columns\TextColumn::make('suratKeluar.nomor_agenda'),                
                Tables\Columns\TextColumn::make('suratKeluar.nomor_surat'),
                Tables\Columns\TextColumn::make('user.name'),
                Tables\Columns\TextColumn::make('status'),
            ])
            ->filters([
                Filter::make('Draft')
                ->query(fn (Builder $query): Builder => $query->where('status', 'Draft')),
                Filter::make('Reviewed')
                    ->query(fn (Builder $query): Builder => $query->where('status', 'Reviewed')),
                Filter::make('Approved')
                    ->query(fn (Builder $query): Builder => $query->where('status', 'Approved')),
       
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
    public function afterCreate()
    {
        $this->record->update(['status' => 'Reviewed']);
    }
    public function afterDelete()
    {
        $this->record->update(['status' => 'Draft']);
    }
}
