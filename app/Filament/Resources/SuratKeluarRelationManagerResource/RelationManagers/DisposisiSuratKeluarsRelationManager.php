<?php

namespace App\Filament\Resources\SuratKeluarRelationManagerResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
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

    protected function getUsersByRole($status)
    {
        $currentUser = Auth::user();
        $currentUserId = $currentUser->id;

        $roleHierarchy = [
            'eselon_pelaksana' => ['eselon_pembantu_pimpinan'],
            'eselon_pembantu_pimpinan' => ['eselon_pimpinan'],
            'eselon_pimpinan' => ['TU'],
        ];

        $currentUserRole = $currentUser->getRoleNames()->first();
        $targetRoles = [];

        if ($status == 'Tinjau Kembali') {
            // Mendapatkan role satu tingkat di bawah
            foreach ($roleHierarchy as $role => $higherRoles) {
                if (in_array($currentUserRole, $higherRoles)) {
                    $targetRoles[] = $role;
                }
            }
        } else {
            // Mendapatkan role satu tingkat di atas
            $targetRoles = $roleHierarchy[$currentUserRole] ?? [];
        }

        if (!empty($targetRoles)) {
            return User::role($targetRoles)
                ->where('id', '!=', $currentUserId)
                ->pluck('jabatan', 'id');
        }

        return collect([]);
    }

    public function form(Form $form): Form
    {
        $statuses = [
            'Konsep' => 'Konsep',
            'Perbaikan' => 'Perbaikan',
            'Tinjau Kembali' => 'Tinjau Kembali',
            'Disetujui' => 'Disetujui',
        ];

        return $form
            ->schema([
                Section::make('Isi Disposisi')
                    ->schema([
                        Forms\Components\Select::make('status')
                            ->options($statuses)
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set) {
                                $set('user_id', null);
                            }),

                        Forms\Components\Hidden::make('created_by')->default(auth()->id()),
                        Forms\Components\Textarea::make('keterangan')
                            ->label(__('form.subject')),
                    ])
                    ->columns(2),
                Section::make('Tujuan Disposisi')
                    ->schema([
                        Forms\Components\Radio::make('user_id')
                            ->label('Diajukan Kepada')
                            ->options(function (callable $get) {
                                $status = $get('status');
                                return $this->getUsersByRole($status);
                            })
                            ->required()
                            ->columns(2),
                        SignaturePad::make('paraf')
                            ->label(__('Paraf disini'))
                            ->exportPenColor('#000')
                            ->penColor('#000')
                            ->penColorOnDark('#fff')
                            ->exportPenColor('#00f'),
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
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Konsep' => 'primary',
                        'Tinjau Kembali' => 'danger',
                        'Perbaikan' => 'info',
                        'Disetujui' => 'success',
                        default => 'info ',
                    }),
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
            ])
            ->filters([
                Filter::make('Konsep')
                    ->query(fn (Builder $query): Builder => $query->where('status', 'Konsep')),
                Filter::make('Perbaikan')
                    ->query(fn (Builder $query): Builder => $query->where('status', 'Perbaikan')),
                Filter::make('Tinjau Kembali')
                    ->query(fn (Builder $query): Builder => $query->where('status', 'Tinjau Kembali')),
                Filter::make('Disetujui')
                    ->query(fn (Builder $query): Builder => $query->where('status', 'Disetujui')),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->after(
                        function ($record, $data) {
                             $suratKeluar = $record->suratKeluar;
                            if ($suratKeluar) {
                                $suratKeluar->update(['status' => $data['status']]);
                            }
                            Notification::make()
                                ->title(__('notifications.new_disposisi'))
                                ->icon('heroicon-o-document-check')
                                ->body(
                                    "<b>" . __('notifications.number_agenda') . ":</b> {$record->suratKeluar->nomor_agenda} <br>" .
                                    "<b>" . __('notifications.subject') . ":</b> {$record->suratKeluar->perihal} <br>" .
                                    "<b>" . __('global.label_disposisi_surat_keluar') . ":</b> {$data['keterangan']} <br>"
                                )
                                ->actions([
                                    Action::make(__('notifications.view'))
                                        ->url(SuratKeluarResource::getUrl('edit', ['record' => $record->surat_keluar_id]))->markAsRead(),
                                ])
                                ->success()
                                ->sendToDatabase(User::find($data['user_id']));
                        }
                    ),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make()->color('info'),
                    Tables\Actions\EditAction::make()->color('info')
                        ->visible(fn ($record) => $record->created_by === $currentUser->id || $currentUser->hasRole('super_admin'))
                        ->after(
                            function ($record, $data) {
                                 $suratKeluar = $record->suratKeluar;
                            if ($suratKeluar) {
                                $suratKeluar->update(['status' => $data['status']]);
                            }
                                Notification::make()
                                    ->title(__('notifications.new_disposisi'))
                                    ->icon('heroicon-o-document-check')
                                    ->body(
                                        "<b>" . __('notifications.number_agenda') . ":</b> {$record->suratKeluar->nomor_agenda} <br>" .
                                        "<b>" . __('notifications.subject') . ":</b> {$record->suratKeluar->perihal} <br>" .
                                        "<b>" . __('global.label_disposisi_surat_keluar') . ":</b> {$data['keterangan']} <br>"
                                    )
                                    ->actions([
                                        Action::make(__('notifications.view'))
                                            ->url(SuratKeluarResource::getUrl('edit', ['record' => $record->surat_keluar_id]))->markAsRead(),
                                    ])
                                    ->success()
                                    ->sendToDatabase(User::find($data['user_id']));
                            }
                        ),
                    Tables\Actions\DeleteAction::make()
                        ->visible(fn ($record) => $record->created_by === $currentUser->id || $currentUser->hasRole('super_admin')),
                ]),
            ])
            ->bulkActions([]);
    }

}
