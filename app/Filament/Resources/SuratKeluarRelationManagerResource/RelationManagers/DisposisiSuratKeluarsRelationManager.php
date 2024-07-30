<?php

namespace App\Filament\Resources\SuratKeluarRelationManagerResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Section;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Saade\FilamentAutograph\Forms\Components\SignaturePad;
use App\Filament\Resources\SuratKeluarResource;
class DisposisiSuratKeluarsRelationManager extends RelationManager
{
    protected static string $relationship = 'disposisi_surat_keluars';

    protected static ?string $recordTitleAttribute = 'nomor_agenda';

    protected function getUsersByRole()
    {
        $currentUser = Auth::user();
        $currentUserId = $currentUser->id;

        if ($currentUser->hasRole('super_admin')) {
            return User::where('id', '!=', $currentUserId)->pluck('jabatan', 'id');
        }

        // $roleHierarchy = [
        //     'eselon_pimpinan' => ['eselon_pimpinan', 'eselon_pembantu_pimpinan', 'eselon_pelaksana'],
        //     'eselon_pembantu_pimpinan' => ['eselon_pembantu_pimpinan', 'eselon_pelaksana'],
        // ];
        $roleHierarchy = [
            'eselon_pelaksana' => ['eselon_pembantu_pimpinan'],
            'eselon_pembantu_pimpinan' => ['eselon_pimpinan', 'eselon_pelaksana'],
            'eselon_pimpinan' => ['eselon_pembantu_pimpinan'],
        ];

        $currentUserRole = $currentUser->getRoleNames()->first();
        $higherLevelRoles = $roleHierarchy[$currentUserRole] ?? [];

        if (!empty($higherLevelRoles)) {
            return User::role($higherLevelRoles)
                ->where('id', '!=', $currentUserId)
                ->pluck('jabatan', 'id');
        }

        return collect([]);
    }
    protected function getRoleByUserId($userId)
    {
        $user = User::find($userId);
        return $user ? $user->getRoleNames()->first() : null;
    }
    public function form(Form $form): Form
    {
        return $form
            ->schema([             
                Section::make('Tujuan Disposisi')
                        ->schema([
                        Forms\Components\Radio::make('user_id')
                                ->label('Diajukan Kepada')
                                ->options($this->getUsersByRole())
                                ->required()
                                ->columns(4),
                        ]),   
                        
                Section::make('Tujuan Disposisi')
                ->schema([
                Forms\Components\Hidden::make('created_by')->default(auth()->id()),
                // Forms\Components\Select::make('user_id')
                //     ->relationship('user', 'name')
                //     ->required(),
                Forms\Components\Textarea::make('keterangan')
                ->label(__('form.subject')),
                Forms\Components\Select::make('status')
                    ->options([
                        'Draft' => 'Draft',
                        'Reviewed' => 'Reviewed',
                        'Approved' => 'Approved',
                    ])
                    ->required(),
                    ])
                    ->columns(2)
            ]);
    }

    public function table(Table $table): Table
    {
        $currentUser = Auth::user();
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                Tables\Columns\TextColumn::make('suratKeluar.nomor_agenda')
                ->label(__('form.no_agenda'))
                ->toggleable(isToggledHiddenByDefault: true),                
                Tables\Columns\TextColumn::make('suratKeluar.nomor_surat')
                ->label(__('form.letter_number'))
                ->toggleable(isToggledHiddenByDefault: true),      
                Tables\Columns\TextColumn::make('user.name') 
                ->label(__('form.from')),
                Tables\Columns\TextColumn::make('to.name') 
                ->label(__('form.to')),
                Tables\Columns\TextColumn::make('keterangan') 
                ->label(__('form.subject')),
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
                Tables\Actions\CreateAction::make()
                ->visible(fn() => $currentUser->hasRole(['super_admin', 'eselon_pimpinan', 'eselon_pembantu_pimpinan']))    
                ->after(
                    function ($record, $data) {
                        // foreach ($data['user_id'] as $kepada) {
                            Notification::make()
                                ->title(__('notifications.new_disposisi'))
                                ->icon('heroicon-o-document-check')
                                ->body(
                                    "<b>" . __('notifications.number_agenda') . ":</b> {$record->suratKeluar->nomor_agenda} <br>".
                                    "<b>" . __('notifications.subject') . ":</b> {$record->suratKeluar->keterangan} <br>"
                                )
                                ->actions([
                                    Action::make(__('notifications.view'))
                                        ->url(SuratKeluarResource::getUrl('edit', ['record' => $record->surat_keluar_id]))->markAsRead(),
                                ])
                                ->success()
                                ->sendToDatabase(User::find($data['user_id']));
                        // }
                    }
                ),
            ])
            ->actions([
                Tables\Actions\EditAction::make() ->after(
                    function ($record, $data) {
                        // foreach ($data['user_id'] as $kepada) {
                            Notification::make()
                                ->title(__('notifications.new_disposisi'))
                                ->icon('heroicon-o-document-check')
                                ->body(
                                    "<b>" . __('notifications.number_agenda') . ":</b> {$record->suratKeluar->nomor_agenda} <br>".
                                    "<b>" . __('notifications.subject') . ":</b> {$record->suratKeluar->keterangan} <br>"
                                )
                                ->actions([
                                    Action::make(__('notifications.view'))
                                        ->url(SuratKeluarResource::getUrl('edit', ['record' => $record->surat_keluar_id]))->markAsRead(),
                                ])
                                ->success()
                                ->sendToDatabase(User::find($data['user_id']));
                        // }
                    }
                ),
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
